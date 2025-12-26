<?php

namespace App\Services;

use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use Exception;

class MidtransService
{
    public function __construct()
    {
        // ================= CONFIG YANG BENAR =================
        Config::$serverKey    = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction', false);
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    }

    /**
     * Generate Snap Token
     */
    public function createSnapToken(Order $order): string
    {
        // ================= VALIDASI =================
        if ($order->items->isEmpty()) {
            throw new Exception('Order tidak memiliki item.');
        }

        // ================= HITUNG TOTAL =================
        $itemsTotal = $order->items->sum(fn ($item) =>
            (int) $item->price * (int) $item->quantity
        );

        $shippingCost = (int) ($order->shipping_cost ?? 0);
        $grossAmount  = $itemsTotal + $shippingCost;

        if ($grossAmount <= 0) {
            throw new Exception('Total pembayaran tidak valid.');
        }

        // ================= ORDER ID (WAJIB SAMA DB) =================
        $orderId = $order->order_number;

        // ================= CUSTOMER DETAILS =================
        $user = $order->user;

        $customerDetails = [
            'first_name' => $order->shipping_name ?? $user->name ?? 'Customer',
            'email'      => $user->email ?? 'noemail@example.com',
            'phone'      => $order->shipping_phone ?? $user->phone ?? '',
        ];

        // ================= ITEM DETAILS =================
        $itemDetails = [];

        foreach ($order->items as $item) {
            $itemDetails[] = [
                'id'       => (string) $item->product_id,
                'price'    => (int) $item->price,
                'quantity' => (int) $item->quantity,
                'name'     => substr($item->product_name, 0, 50),
            ];
        }

        if ($shippingCost > 0) {
            $itemDetails[] = [
                'id'       => 'SHIPPING',
                'price'    => $shippingCost,
                'quantity' => 1,
                'name'     => 'Biaya Pengiriman',
            ];
        }

        // ================= PAYLOAD =================
        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => $customerDetails,
            'item_details'     => $itemDetails,
        ];

        // ================= SNAP TOKEN =================
        try {
            return Snap::getSnapToken($params);
        } catch (Exception $e) {

            logger()->error('Midtrans Snap Error', [
                'order_id' => $orderId,
                'payload'  => $params,
                'error'    => $e->getMessage(),
            ]);

            if (config('app.debug')) {
                throw $e;
            }

            throw new Exception('Gagal membuat transaksi pembayaran.');
        }
    }

    /**
     * Cek status transaksi
     */
    public function checkStatus(string $orderId)
    {
        return Transaction::status($orderId);
    }

    /**
     * Batalkan transaksi
     */
    public function cancelTransaction(string $orderId)
    {
        return Transaction::cancel($orderId);
    }
}
