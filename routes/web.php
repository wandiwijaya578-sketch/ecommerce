<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/coba', function () {
    return view('flexy');
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
        Route::resource('/categories', AdminCategoryController::class);

    });

Route::controller(GoogleController::class)->group(function () {
    Route::get('auth/google', 'redirect')->name('auth.google');
    Route::get('auth/google/callback', 'callback');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.destroy');

});

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/search', [CatalogController::class, 'search'])->name('catalog.search');
Route::get('/catalog/category/{category}', [CatalogController::class, 'category'])->name('catalog.category');
Route::get('/catalog/product/{product}', [CatalogController::class, 'show'])->name('catalog.product');


Route::middleware('auth')->group(function () {
    // Keranjang Belanja
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{item}', [CartController::class, 'remove'])->name('cart.remove');

    // Wishlist
    Route::post('/wishlist/{product}', [WishlistController::class, 'toggle'])
    ->middleware('auth')
    ->name('wishlist.toggle');

Route::get('/wishlist', [WishlistController::class, 'index'])
    ->middleware('auth')
    ->name('wishlist.index');

Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])
    ->middleware('auth')
    ->name('wishlist.destroy');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    

    // Pesanan Saya
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Produk CRUD
    Route::resource('products', AdminProductController::class);

    // Kategori CRUD
    Route::resource('categories', AdminCategoryController::class);

    // Manajemen Pesanan
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

   //order
   Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Kategori
    Route::resource('categories', CategoryController::class)->except(['show']); // Kategori biasanya tidak butuh show detail page

    // Produk
    Route::resource('products', ProductController::class);

    // Route tambahan untuk AJAX Image Handling (jika diperlukan)
    // ...
});

Auth::routes();

Route::get('/login', function () {
    return view('auth.login');
})->name('login');


Auth::routes();