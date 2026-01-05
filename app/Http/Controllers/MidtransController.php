<?php
// app/Http/Controllers/MidtransController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\MidtransService;

class MidtransController extends Controller
{
    protected $midtrans;

    public function __construct(MidtransService $midtrans)
    {
        $this->midtrans = $midtrans;
    }

    /**
     * Terima callback dari Midtrans
     */
    public function callback(Request $request)
    {
        $orderId = $request->order_id ?? $request->input('order_id');

        try {
            $status = $this->midtrans->checkStatus($orderId);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        $order = Order::where('order_number', $orderId)->first();
        if (!$order) {
            return response()->json(['message' => 'Order tidak ditemukan'], 404);
        }

        // Update status order
        if (in_array($status->transaction_status, ['capture', 'settlement'])) {
            $order->status = 'paid';
            $order->payment_type = $status->payment_type;
            $order->save();
        } elseif (in_array($status->transaction_status, ['deny', 'expire', 'cancel'])) {
            $order->status = 'failed';
            $order->save();
        }

        return response()->json(['message' => 'OK']);
    }
}
