@extends('layouts.admin')

@section('title', 'Detail Produk')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 fw-bold mb-1">
                <i class="bi bi-box-seam me-1"></i>
                Detail Produk
            </h1>
            <p class="text-muted mb-0">
                Informasi lengkap produk
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning text-white">
                <i class="bi bi-pencil-square"></i> Edit
            </a>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row g-4">

        {{-- GALERI GAMBAR --}}
        <div class="col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">

                    {{-- PRIMARY IMAGE --}}
                    <img
                        src="{{ $product->primaryImage
                            ? $product->primaryImage->image_url
                            : asset('img/no-image.png') }}"
                        class="img-fluid rounded mb-3"
                        style="max-height:300px; object-fit:contain"
                    >

                    {{-- THUMBNAILS --}}
                    @if($product->images->count())
                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                            @foreach($product->images as $image)
                                <img
                                    src="{{ $image->image_url }}"
                                    class="rounded border"
                                    width="60"
                                    height="60"
                                    style="object-fit:cover"
                                >
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- DETAIL PRODUK --}}
        <div class="col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <h3 class="fw-bold mb-3">
                        {{ $product->name }}
                    </h3>

                    {{-- STATUS --}}
                    <p class="mb-3">
                        @if($product->is_active)
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle"></i> Aktif
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                <i class="bi bi-x-circle"></i> Nonaktif
                            </span>
                        @endif
                    </p>

                    <hr>

                    {{-- INFO --}}
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">
                            <i class="bi bi-tags"></i> Kategori
                        </div>
                        <div class="col-sm-8 fw-semibold">
                            {{ $product->category->name ?? '-' }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">
                            <i class="bi bi-cash-stack"></i> Harga
                        </div>
                        <div class="col-sm-8 fw-semibold">
                            Rp {{ number_format($product->discount_price ?? $product->price, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">
                            <i class="bi bi-box"></i> Stok
                        </div>
                        <div class="col-sm-8 fw-semibold">
                            {{ $product->stock }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 text-muted">
                            <i class="bi bi-info-circle"></i> Deskripsi
                        </div>
                        <div class="col-sm-8">
                            {!! nl2br(e($product->description ?? '-')) !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>
@endsection
