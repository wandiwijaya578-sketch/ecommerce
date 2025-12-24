<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function getSnapToken(Order $order, MidtransService $midtransService)
{
    // Authorization
    if ($order->user_id !== auth()->id()) {
        abort(403);
    }

    // Sudah dibayar
    if ($order->payment_status === 'paid') {
        return response()->json(['error' => 'Pesanan sudah dibayar.'], 400);
    }

    // Gunakan token lama jika ada
    if ($order->snap_token) {
        return response()->json(['token' => $order->snap_token]);
    }

    try {
        $snapToken = $midtransService->createSnapToken($order);

        $order->update([
            'snap_token' => $snapToken,
        ]);

        return response()->json(['token' => $snapToken]);
    } catch (\Exception $e) {

        logger()->error('Get Snap Token Error', [
            'order_id' => $order->id,
            'error' => $e->getMessage(),
        ]);

        return response()->json(['error' => 'Gagal memproses pembayaran'], 500);
    }
}

}
