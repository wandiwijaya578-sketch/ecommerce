@props(['product'])

<div class="card h-100 border-0 shadow-sm product-card">
    {{-- Gambar --}}
    <div class="position-relative overflow-hidden bg-light" style="padding-top: 100%;">
        <img src="{{ $product->image_url }}"
             class="card-img-top position-absolute top-0 start-0 w-100 h-100 object-fit-cover">

        @if($product->has_discount)
             <span class="position-absolute top-0 start-0 m-2 badge bg-danger">
                 -{{ $product->discount_percentage }}%
             </span>
        @endif
    </div>

    {{-- Info --}}
    <div class="card-body d-flex flex-column">
        <small class="text-muted mb-1">{{ $product->category->name }}</small>
        <h6 class="card-title mb-2">
            <a href="{{ route('catalog.show', $product->slug) }}" class="text-decoration-none text-dark stretched-link">
                {{ $product->name }}
            </a>
        </h6>
        <div class="mt-auto">
            @if($product->has_discount)
                <p class="fw-bold text-danger mb-0">{{ $product->formatted_price }}</p>
                <small class="text-decoration-line-through text-muted">{{ $product->formatted_original_price }}</small>
            @else
                <p class="fw-bold text-primary mb-0">{{ $product->formatted_price }}</p>
            @endif
        </div>
    </div>
</div>
{{-- components/order-status-badge.blade.php --}}
@props(['status'])

@php
$colors = [
    'pending' => 'bg-yellow-100 text-yellow-800',
    'processing' => 'bg-blue-100 text-blue-800',
    'completed' => 'bg-green-100 text-green-800',
    'cancelled' => 'bg-red-100 text-red-800',
];
$colorClass = $colors[$status] ?? 'bg-gray-100 text-gray-800';
@endphp

<span class="px-2 py-1 text-xs rounded-full font-semibold {{ $colorClass }}">
    {{ ucfirst($status) }}
</span>