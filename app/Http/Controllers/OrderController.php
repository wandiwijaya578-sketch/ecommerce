<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // List semua order user
    public function index()
    {
        $orders = auth()->user()->orders()
            ->with(['items.product'])
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    // Detail order
    public function show(Order $order, MidtransService $midtrans)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items.product', 'user']);

        $snapToken = null;
        if ($order->status === 'pending') {
            $snapToken = $midtrans->createSnapToken($order);
        }

        return view('orders.show', compact('order', 'snapToken'));
    }

    // Halaman success
    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('orders.success', compact('order'));
    }

    // Halaman pending
    public function pending(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('orders.pending', compact('order'));
    }

    // Membuat transaksi baru ke Midtrans
    public function pay(Order $order, MidtransService $midtrans)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Transaksi sudah diproses.');
        }

        $snapToken = $midtrans->createSnapToken($order);

        return redirect()->route('orders.show', $order)
            ->with('snapToken', $snapToken);
    }
}
