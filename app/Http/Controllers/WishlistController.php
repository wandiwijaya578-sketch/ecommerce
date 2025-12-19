<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Tambahkan model jika sudah ada, misal: use App\Models\Product;

class WishlistController extends Controller
{
    /**
     * Menampilkan halaman wishlist
     */
    public function index()
    {
        // Contoh: ambil wishlist user yang login
        $user = Auth::user();
        // $wishlist = $user->wishlist()->with('product')->get(); // jika pakai relasi

        return view('wishlist.index', compact('user'));
        // atau return view('wishlist'); tergantung nama view kamu
    }

    /**
     * Tambah produk ke wishlist (contoh)
     */
    public function store(Request $request)
    {
        // Logika tambah ke wishlist
        return redirect()->back()->with('success', 'Produk ditambahkan ke wishlist!');
    }

    /**
     * Hapus dari wishlist (contoh)
     */
    public function destroy($id)
    {
        // Logika hapus
        return redirect()->back()->with('success', 'Produk dihapus dari wishlist!');
    }
}