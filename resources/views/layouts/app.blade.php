{{-- ================================================
     FILE: resources/views/layouts/app.blade.php
     FUNGSI: Master layout untuk halaman customer/publik
     ================================================ --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
     <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    {{-- CSRF Token untuk AJAX --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Meta Tags --}}
    <title>@yield('title', 'Dwaa Lux') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_description', 'Toko online terpercaya dengan produk berkualitas')">

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
</head>
<body>
    {{-- ============================================
         NAVBAR
         ============================================ --}}
    @include('partials.navbar')

    {{-- ============================================
         FLASH MESSAGES
         ============================================ --}}
    <div class="container mt-3">
        @include('partials.flash-messages')
    </div>

    {{-- ============================================
         MAIN CONTENT
         ============================================ --}}
    <main class="min-vh-100">
        @yield('content')
    </main>

    {{-- ============================================
         FOOTER
         ============================================ --}}
    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
        
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        btn.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();

            const productId = this.dataset.id;

            fetch(`/wishlist/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                const icon = this.querySelector('i');
                const alertBox = document.getElementById('wishlist-alert');

                if (data.status === 'added') {
                    this.classList.remove('btn-outline-danger');
                    this.classList.add('btn-danger');
                    icon.className = 'bi bi-heart-fill';

                    alertBox.textContent = '❤️ Produk yang diinginkan telah dimasukkan ke wishlist! jangan lupa cek nanti yaa..😘';
                    alertBox.classList.remove('d-none');
                } else {
                    this.classList.add('btn-outline-danger');
                    this.classList.remove('btn-danger');
                    icon.className = 'bi bi-heart';

                    alertBox.textContent = '💔 Produk dihapus dari wishlist';
                    alertBox.classList.remove('d-none');
                }

                setTimeout(() => {
                    alertBox.classList.add('d-none');
                }, 2000);
            });
        });
    });
});
</script>


@stack('scripts')

</body>
<div id="wishlist-alert"
     class="alert alert-success position-fixed top-0 end-0 m-4 d-none shadow"
     style="z-index:99999;">
    ❤️ Produk yang diinginkan telah dimasukkan ke wishlist! jangan lupa cek nanti yaa..😘
</div>

</html>