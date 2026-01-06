@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

{{-- HERO --}}
<section class="hero-lux py-5">
    <div class="container">
        <div class="row align-items-center gy-4">
            <div class="col-lg-6">
                <h1 class="fw-bold display-5 mb-3 text-dark">
                    Cahaya Indah untuk Setiap Sudut Rumah
                </h1>
                <p class="fs-5 mb-4 text-muted">
                    Temukan lampu hias elegan dengan kualitas premium & desain modern.
                </p>
                <a href="{{ route('catalog.index') }}" class="btn btn-lux btn-lg px-5">
                    Jelajahi Produk
                </a>
            </div>
            <div class="col-lg-6 d-none d-lg-block text-center">
                <img src="{{ asset('images/homo.png') }}"
                     alt="Lampu Hias"
                     class="img-fluid hero-image">
            </div>
        </div>
    </div>
</section>

{{-- KATEGORI --}}
<section class="py-5">
    <div class="container">
        <h4 class="fw-bold mb-4 text-center">Kategori Lampu</h4>
        <div class="row g-4 justify-content-center">
            @foreach($categories as $category)
                <div class="col-4 col-md-3 col-lg-2 text-center">
                    <a href="{{ route('catalog.index', ['category' => $category->slug]) }}"
                       class="text-decoration-none">
                        <div class="category-card p-3 h-100">
                            <img src="{{ $category->image_url }}"
                                 alt="{{ $category->name }}"
                                 width="64" height="64"
                                 class="mb-2">
                            <div class="fw-medium text-dark small">{{ $category->name }}</div>
                            <div class="text-muted small">
                                {{ $category->products_count }} produk
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- PRODUK UNGGULAN --}}
<section class="py-5 bg-soft">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Produk Unggulan</h4>
            <a href="{{ route('catalog.index') }}" class="lux-link">
                Lihat Semua →
            </a>
        </div>

        <div class="row g-4">
            @foreach($featuredProducts as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    @include('partials.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- PROMO --}}
<section class="py-5">
    <div class="container">
        <div class="row g-4">

            <div class="col-md-6">
                <div class="promo-lux h-100">
                    <h4 class="fw-bold">Lampu Pilihan Minggu Ini</h4>
                    <p class="opacity-75 mb-3">
                        Diskon spesial untuk lampu favorit pelanggan
                    </p>
                    <a href="{{ route('catalog.index') }}" class="btn btn-light btn-sm">
                        Lihat Promo
                    </a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-4 rounded-4 border h-100 bg-white">
                    <h4 class="fw-bold">Member Baru?</h4>
                    <p class="text-muted mb-3">
                        Dapatkan voucher Rp50.000 untuk pembelian pertama
                    </p>
                    <a href="{{ route('register') }}" class="btn btn-lux btn-sm">
                        Daftar Sekarang
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- PRODUK TERBARU --}}
<section class="py-5 bg-soft">
    <div class="container">
        <h4 class="fw-bold text-center mb-4">Produk Terbaru</h4>
        <div class="row g-4">
            @foreach($latestProducts as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    @include('partials.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
