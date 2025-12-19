<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Tampilkan halaman keranjang belanja
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil cart milik user yang login
        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id],
            ['user_id' => $user->id]
        );

        // Load relasi items → product → category agar tidak N+1 query
        $cart->load('items.product.category');

        return view('cart.index', compact('cart'));
    }

    /**
     * Tambah produk ke cart (dipanggil dari halaman produk)
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $product = Product::findOrFail($request->product_id);

        // Cek stock
        if ($request->quantity > $product->stock) {
            return back()->with('error', 'Stok tidak cukup!');
        }

        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        $cartItem = $cart->items()->updateOrCreate(
            ['product_id' => $product->id],
            ['quantity' => \DB::raw('quantity + ' . $request->quantity)]
        );

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Update quantity item di cart
     */
    public function update(Request $request, $cartItemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::whereHas('cart', function ($q) {
            $q->where('user_id', Auth::id());
        })->findOrFail($cartItemId);

        // Cek stock
        if ($request->quantity > $cartItem->product->stock) {
            return back()->with('error', 'Stok tidak cukup!');
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Keranjang berhasil diperbarui!');
    }

    /**
     * Hapus item dari cart
     */
    public function remove($cartItemId)
    {
        $cartItem = CartItem::whereHas('cart', function ($q) {
            $q->where('user_id', Auth::id());
        })->findOrFail($cartItemId);

        $cartItem->delete();

        return back()->with('success', 'Produk dihapus dari keranjang!');
    }
}