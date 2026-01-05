<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Halaman wishlist user
     */
    public function index()
    {
        $wishlists = Wishlist::with('product.primaryImage')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('wishlist.index', compact('wishlists'));
    }

    /**
     * Toggle wishlist (AJAX)
     */
    public function toggle($productId)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['status' => 'removed']);
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
        ]);

        return response()->json(['status' => 'added']);
    }

    /**
     * Hapus dari halaman wishlist (FORM)
     */
    public function destroy($id)
    {
        Wishlist::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return redirect()->route('wishlist.index')
            ->with('success', 'Produk dihapus dari wishlist');
    }
}
