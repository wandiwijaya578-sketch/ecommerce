<?php

namespace App\Services;

use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use Illuminate\Support\Str;
use Exception;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');
    }

    public function createSnapToken(Order $order): string
    {
        // ================= VALIDASI =================
        if ($order->items->isEmpty()) {
            throw new Exception('Order tidak memiliki item.');
        }

        // ================= HITUNG TOTAL (AMAN) =================
        $itemsTotal = $order->items->sum(fn ($item) =>
            (int) $item->price * (int) $item->quantity
        );

        $shippingCost = (int) ($order->shipping_cost ?? 0);
        $grossAmount  = (int) ($itemsTotal + $shippingCost);

        if ($grossAmount <= 0) {
            throw new Exception('Total pembayaran tidak valid.');
        }

        // ================= ORDER ID (ANTI DUPLIKAT) =================
        $orderId = $order->order_number;

        // Jika order_number berpotensi dipakai ulang, pakai suffix unik
        if (!str_contains($orderId, '-MT-')) {
            $orderId .= '-MT-' . Str::random(6);
        }

        // ================= TRANSACTION DETAILS =================
        $transactionDetails = [
            'order_id'     => $orderId,
            'gross_amount' => $grossAmount,
        ];

        // ================= CUSTOMER DETAILS =================
        $user = $order->user;

        $customerDetails = [
            'first_name' => $order->shipping_name
                ?? $user->name
                ?? 'Customer',

            'email' => $user->email
                ?? 'noemail@example.com',

            'phone' => $order->shipping_phone
                ?? $user->phone
                ?? '',
            'billing_address' => [
                'first_name'   => $order->shipping_name ?? 'Customer',
                'phone'        => $order->shipping_phone ?? '',
                'address'      => $order->shipping_address ?? '',
                'country_code' => 'IDN',
            ],
            'shipping_address' => [
                'first_name'   => $order->shipping_name ?? 'Customer',
                'phone'        => $order->shipping_phone ?? '',
                'address'      => $order->shipping_address ?? '',
                'country_code' => 'IDN',
            ],
        ];

        // ================= ITEM DETAILS =================
        $itemDetails = $order->items->map(function ($item) {
            return [
                'id'       => (string) $item->product_id,
                'price'    => (int) $item->price,
                'quantity' => (int) $item->quantity,
                'name'     => substr($item->product_name, 0, 50),
            ];
        })->toArray();

        if ($shippingCost > 0) {
            $itemDetails[] = [
                'id'       => 'SHIPPING',
                'price'    => $shippingCost,
                'quantity' => 1,
                'name'     => 'Biaya Pengiriman',
            ];
        }

        $params = [
            'transaction_details' => $transactionDetails,
            'customer_details'    => $customerDetails,
            'item_details'        => $itemDetails,
        ];

        // ================= REQUEST SNAP TOKEN =================
        try {
            return Snap::getSnapToken($params);
        } catch (Exception $e) {

            // LOG DETAIL (WAJIB)
            logger()->error('Midtrans Snap Token Error', [
                'order_id' => $orderId,
                'payload'  => $params,
                'error'    => $e->getMessage(),
            ]);

            // Tampilkan error ASLI saat development
            if (config('app.debug')) {
                throw new Exception($e->getMessage());
            }

            throw new Exception('Gagal membuat transaksi pembayaran.');
        }
    }

    public function checkStatus(string $orderId)
    {
        return Transaction::status($orderId);
    }

    public function cancelTransaction(string $orderId)
    {
        return Transaction::cancel($orderId);
    }
}
