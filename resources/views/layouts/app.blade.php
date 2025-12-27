{{-- ================================================
     FILE: resources/views/layouts/app.blade.php
     FUNGSI: Master layout customer (FIXED VERSION)
     ================================================ --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        crossorigin="anonymous"
    >

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <!-- CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dwaa Lux') - {{ config('app.name') }}</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}">
</head>
<body>

    {{-- NAVBAR --}}
    @include('partials.navbar')

    {{-- FLASH MESSAGE --}}
    <div class="container mt-3">
        @include('partials.flash-messages')
    </div>

    {{-- MAIN CONTENT --}}
    <main class="min-vh-100">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('partials.footer')

    <!-- Bootstrap JS -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous">
    </script>

    {{-- =====================================
         WISHLIST SCRIPT (FIXED & SAFE)
         ===================================== --}}
    <script>
    async function toggleWishlist(productId) {
        try {
            const token = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content');

            const response = await fetch(`/wishlist/toggle/${productId}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token,
                },
            });

            if (response.status === 401) {
                window.location.href = "/login";
                return;
            }

            const data = await response.json();

            if (data.status === "success") {
                updateWishlistUI(productId, data.added);
                updateWishlistCounter(data.count);
            }
        } catch (error) {
            console.error("Wishlist error:", error);
        }
    }

    function updateWishlistUI(productId, isAdded) {
        const buttons = document.querySelectorAll(`.wishlist-btn-${productId}`);

        buttons.forEach(btn => {
            const icon = btn.querySelector("i");
            if (!icon) return;

            if (isAdded) {
                icon.classList.remove("bi-heart", "text-secondary");
                icon.classList.add("bi-heart-fill", "text-danger");
            } else {
                icon.classList.remove("bi-heart-fill", "text-danger");
                icon.classList.add("bi-heart", "text-secondary");
            }
        });
    }

    function updateWishlistCounter(count) {
        const badge = document.getElementById("wishlist-count");
        if (!badge) return;

        badge.innerText = count;
        badge.style.display = count > 0 ? "inline-block" : "none";
    }
    </script>

    {{-- SCRIPT TAMBAHAN DARI PAGE (Midtrans, dll) --}}
    @stack('scripts')

</body>
</html>
