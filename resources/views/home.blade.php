@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

{{-- ================= HERO ================= --}}
<section class="hero-lux position-relative overflow-hidden py-5">
    <div class="hero-overlay"></div>

    <div class="container position-relative z-2">
        <div class="row align-items-center gy-4">
            <div class="col-lg-6">
                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill mb-3">
                    ✨ Koleksi Terbaru
                </span>

                <h1 class="fw-bold display-5 mb-3 lh-sm">
                    Cahaya Elegan<br>
                    <span class="text-lux">Untuk Setiap Sudut Rumah</span>
                </h1>

                <p class="fs-5 text-muted mb-3">
                    Lampu hias modern, elegan, dan berkualitas premium.
                </p>

                <div class="d-flex gap-2 mb-4 flex-wrap">
                    <span class="hero-tag">Desain Modern</span>
                    <span class="hero-tag">Kualitas Premium</span>
                    <span class="hero-tag">Harga Terbaik</span>
                </div>

                <a href="{{ route('catalog.index') }}" class="btn btn-lux btn-lg px-5 shadow">
                    Jelajahi Produk
                </a>
            </div>

            <div class="col-lg-6 d-none d-lg-block text-center">
                <img src="{{ asset('images/homo.png') }}"
                     class="img-fluid hero-image floating"
                     alt="Lampu Hias">
            </div>
        </div>
    </div>
</section>

{{-- ================= IKLAN VIDEO ================= --}}
<section class="py-5 bg-dark">
    <div class="container">
        <div class="row align-items-center gy-4">
            <div class="col-md-6 text-white">
                <h3 class="fw-bold mb-3">
                    Inspirasi Lampu Interior Modern
                </h3>
                <p class="opacity-75 mb-4">
                    Saksikan bagaimana lampu kami mempercantik rumah pelanggan.
                </p>
                <a href="{{ route('catalog.index') }}" class="btn btn-outline-light">
                    Lihat Koleksi
                </a>
            </div>

            <div class="col-md-6">
                <div class="video-wrapper rounded-4 overflow-hidden shadow position-relative">
                    <video autoplay muted loop playsinline class="w-100">
                        <source src="{{ asset('videos/5366416-hd_1920_1080_30fps.mp4') }}" type="video/mp4">
                    </video>

                    <div class="video-overlay"></div>

                    <div class="video-play-icon">
                        <i class="bi bi-play-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= KATEGORI ================= --}}
<section class="py-5">
    <div class="container">
        <h4 class="fw-bold text-center mb-4">Kategori Lampu</h4>

        <div class="row g-4 justify-content-center">
            @foreach($categories as $category)
                <div class="col-4 col-md-3 col-lg-2 text-center">
                    <a href="{{ route('catalog.index', ['category' => $category->slug]) }}"
                       class="text-decoration-none">
                        <div class="category-circle glow mx-auto shadow-sm">
                            <img src="{{ $category->image_url }}"
                                 width="48"
                                 alt="{{ $category->name }}">
                        </div>

                        <div class="fw-medium small mt-2 text-dark">
                            {{ $category->name }}
                        </div>
                        <div class="text-muted small">
                            {{ $category->products_count }} produk
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ================= PRODUK UNGGULAN ================= --}}
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

{{-- ================= PROMO BANNER ================= --}}
<section class="py-5">
    <div class="container">
        <div class="promo-banner rounded-4 p-5 text-white shadow">
            <h3 class="fw-bold mb-2">Diskon Hingga 40%</h3>
            <p class="mb-3">Lampu favorit pilihan minggu ini</p>
            <a href="{{ route('catalog.index') }}" class="btn btn-light btn-sm">
                Belanja Sekarang
            </a>
        </div>
    </div>
</section>

{{-- ================= PRODUK TERBARU ================= --}}
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
