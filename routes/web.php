<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tentang', function () {
    return view('tentang');
});

Route::get('/sapa/{nama}', function ($nama) {
    return "Hallo, $nama! Selamat datang di toko online kami.";
});

Route::get('/kategori/{nama?}', function ($nama = 'semua') {
    return "Menampilkan kategori: $nama";
});

Route::get('/produk/{id}', function ($id) {
    return "Menampilkan produk dengan ID: $id";
})->name ('detail.produk');


Auth::routes();

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // /admin/dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');
         Route::resource('/products', AdminProductController::class);
    });

Route::controller(GoogleController::class)->group(function () {
    Route::get('auth/google', 'redirect')->name('auth.google');
    Route::get('auth/google/callback', 'callback');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
