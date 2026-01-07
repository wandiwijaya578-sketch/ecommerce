@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h1 class="h3 fw-bold mb-3">
        {{ $product->name }}
    </h1>

    <p class="text-muted mb-2">
        Kategori: {{ $product->category->name ?? '-' }}
    </p>

    <p>
        Harga:
        <strong>
            Rp {{ number_format($product->discount_price ?? $product->price, 0, ',', '.') }}
        </strong>
    </p>

    <p>Stok: {{ $product->stock }}</p>

    <p>Status:
        @if($product->is_active)
            <span class="badge bg-success">Aktif</span>
        @else
            <span class="badge bg-secondary">Nonaktif</span>
        @endif
    </p>

</div>
@endsection
