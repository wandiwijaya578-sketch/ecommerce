<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Daftar semua order user
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Detail order tertentu
     */
    public function show($id)
    {
        $order = Order::with('items.product') // load produk dari setiap item
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('orders.show', compact('order'));
    }
    public function destroy($id)
{
    $order = Order::where('id', $id)
                  ->where('user_id', Auth::id())
                  ->where('status', 'pending') // hanya bisa hapus pending
                  ->firstOrFail();

    $order->items()->delete(); // hapus item order
    $order->delete();          // hapus order

    return back()->with('success', 'Pesanan berhasil dihapus');
}

}
