<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Events\OrderPaidEvent;

class MidtransNotificationController extends Controller
{
    /**
     * Handle incoming webhook notification from Midtrans
     * URL: POST /midtrans/notification
     */
    public function handle(Request $request)
    {
        // 1. Ambil payload
        $payload = $request->all();
        Log::info('Midtrans Notification Received', $payload);

        // 2. Extract field penting
        $orderId           = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $statusCode        = $payload['status_code'] ?? null;
        $grossAmount       = $payload['gross_amount'] ?? null;
        $signatureKey      = $payload['signature_key'] ?? null;
        $paymentType       = $payload['payment_type'] ?? null;
        $fraudStatus       = $payload['fraud_status'] ?? null;
        $transactionId     = $payload['transaction_id'] ?? null;

        // 3. Validasi payload wajib
        if (!$orderId || !$transactionStatus || !$signatureKey) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        // 4. Validasi Signature Key (WAJIB)
        $serverKey = config('midtrans.server_key');

        $expectedSignature = hash(
            'sha512',
            $orderId . $statusCode . $grossAmount . $serverKey
        );

        if ($signatureKey !== $expectedSignature) {
            Log::warning('Midtrans Notification: Invalid signature', [
                'order_id' => $orderId,
            ]);

            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // 5. Cari order
        $order = Order::where('order_number', $orderId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // 6. Idempotency check
        if (in_array($order->status, ['processing', 'shipped', 'delivered'])) {
            return response()->json(['message' => 'Order already processed'], 200);
        }

        // 7. Update payment data
        $payment = $order->payment;

        if ($payment) {
            $payment->update([
                'midtrans_transaction_id' => $transactionId,
                'payment_type'            => $paymentType,
                'raw_response'            => json_encode($payload),
            ]);
        }

        // 8. Mapping status Midtrans
        switch ($transactionStatus) {
            case 'capture':
                if ($fraudStatus === 'challenge') {
                    $this->handlePending($order, $payment, 'Fraud challenge');
                } else {
                    $this->handleSuccess($order, $payment);
                }
                break;

            case 'settlement':
                $this->handleSuccess($order, $payment);
                break;

            case 'pending':
                $this->handlePending($order, $payment, 'Menunggu pembayaran');
                break;

            case 'deny':
            case 'expire':
            case 'cancel':
                $this->handleFailed($order, $payment, 'Pembayaran gagal');
                break;

            case 'refund':
            case 'partial_refund':
                $this->handleRefund($order, $payment);
                break;

            default:
                Log::info('Midtrans Notification: Unknown status', [
                    'status' => $transactionStatus,
                ]);
        }

        return response()->json(['message' => 'Notification processed'], 200);
    }

    /**
     * =========================
     * PAYMENT SUCCESS
     * =========================
     */
    protected function handleSuccess(Order $order, ?Payment $payment): void
    {
        Log::info("Payment SUCCESS: {$order->order_number}");

        $order->update([
            'status'         => 'processing',
            'payment_status' => 'paid',
        ]);

        if ($payment) {
            $payment->update([
                'status'  => 'success',
                'paid_at' => now(),
            ]);
        }

        // 🔥 FIRE EVENT (EMAIL, NOTIFIKASI, DLL)
        event(new OrderPaidEvent($order));
    }

    /**
     * =========================
     * PAYMENT PENDING
     * =========================
     */
    protected function handlePending(Order $order, ?Payment $payment, string $message = ''): void
    {
        Log::info("Payment PENDING: {$order->order_number}", [
            'message' => $message
        ]);

        if ($payment) {
            $payment->update(['status' => 'pending']);
        }
    }

    /**
     * =========================
     * PAYMENT FAILED
     * =========================
     */
    protected function handleFailed(Order $order, ?Payment $payment, string $reason = ''): void
    {
        Log::info("Payment FAILED: {$order->order_number}", [
            'reason' => $reason
        ]);

        $order->update([
            'status'         => 'cancelled',
            'payment_status' => 'failed',
        ]);

        if ($payment) {
            $payment->update(['status' => 'failed']);
        }

        // Restock produk
        foreach ($order->items as $item) {
            $item->product?->increment('stock', $item->quantity);
        }
    }

    /**
     * =========================
     * PAYMENT REFUND
     * =========================
     */
    protected function handleRefund(Order $order, ?Payment $payment): void
    {
        Log::info("Payment REFUNDED: {$order->order_number}");

        if ($payment) {
            $payment->update(['status' => 'refunded']);
        }
    }
}
