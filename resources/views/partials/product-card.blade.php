{{-- ================================================
FILE: resources/views/partials/product-card.blade.php
STYLE: Dwaa Lux – Warm Elegant Product Card
================================================ --}}

<div class="card h-100 border-0 product-card-lux">

    {{-- Image --}}
    <div class="position-relative overflow-hidden rounded-top">
        <a href="{{ route('catalog.show', $product->slug) }}">
            <img src="{{ $product->image_url }}"
                 alt="{{ $product->name }}"
                 class="card-img-top product-img">
        </a>

        {{-- Discount --}}
        @if($product->has_discount)
            <span class="badge-discount-lux">
                -{{ $product->discount_percentage }}%
            </span>
        @endif

        {{-- Wishlist --}}
        @auth
            <button type="button"
                    onclick="toggleWishlist({{ $product->id }})"
                    class="wishlist-btn-lux wishlist-btn-{{ $product->id }}">
                <i class="bi {{ auth()->user()->hasInWishlist($product) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
            </button>
        @endauth
    </div>

    {{-- Body --}}
    <div class="card-body d-flex flex-column p-3">

        {{-- Category --}}
        <small class="text-muted mb-1">{{ $product->category->name }}</small>

        {{-- Name --}}
        <h6 class="product-title">
            <a href="{{ route('catalog.show', $product->slug) }}"
               class="stretched-link text-decoration-none text-dark">
                {{ Str::limit($product->name, 45) }}
            </a>
        </h6>

        {{-- Price --}}
        <div class="mt-auto">
            @if($product->has_discount)
                <div class="small text-muted text-decoration-line-through">
                    {{ $product->formatted_original_price }}
                </div>
            @endif

            <div class="product-price">
                {{ $product->formatted_price }}
            </div>
        </div>

        {{-- Stock --}}
        @if($product->stock <= 5 && $product->stock > 0)
            <small class="text-warning mt-1">
                Stok tinggal {{ $product->stock }}
            </small>
        @elseif($product->stock == 0)
            <small class="text-danger mt-1">
                Stok habis
            </small>
        @endif
    </div>

    {{-- Footer --}}
    <div class="px-3 pb-3">
        <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">

            <button type="submit"
                    class="btn btn-lux-outline btn-sm w-100"
                    @if($product->stock == 0) disabled @endif>
                <i class="bi bi-cart-plus me-1"></i>
                {{ $product->stock == 0 ? 'Stok Habis' : 'Tambah ke Keranjang' }}
            </button>
        </form>
    </div>
</div>
