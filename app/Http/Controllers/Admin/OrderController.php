<?php
// app/Http/Controllers/Admin/OrderController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan untuk admin.
     * Dilengkapi filter by status.
     */
    public function index(Request $request)
    {
        $orders = Order::query()
            ->with('user') // N+1 prevention
            ->when($request->status, function ($q, $status) {
                $q->where('status', $status);
            })
            ->latest()
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Detail order untuk admin.
     */
    public function show(Order $order)
    {
        $order->load(['items.product', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update status pesanan (misal: kirim barang)
     */
    public function updateStatus(Request $request, Order $order)
    {
        // ============================================================
        // Ambil semua status yang valid dari database agar aman
        // ============================================================
        $validStatuses = ['pending', 'processing', 'completed', 'cancelled'];

        $request->validate([
            'status' => 'required|in:' . implode(',', $validStatuses),
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // ============================================================
        // LOGIKA RESTOCK: Jika dibatalkan
        // ============================================================
        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }
        }

        // ============================================================
        // UPDATE STATUS
        // ============================================================
        $order->status = $newStatus;
        $order->save(); // menggunakan save() lebih aman daripada update() langsung untuk enum

        return back()->with('success', "Status pesanan diperbarui menjadi $newStatus");
    }
}
