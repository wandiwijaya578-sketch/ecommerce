{{-- ================================================
     FILE: resources/views/layouts/admin.blade.php
     FUNGSI: Master layout untuk halaman admin
     ================================================ --}}

<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - Admin Panel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .sidebar {
            min-height: 100vh;
            width: 260px;
            background: linear-gradient(180deg, #1e3a5f 0%, #0f172a 100%);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.7);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 4px 12px;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
        }
        .sidebar .nav-link i {
            width: 24px;
            text-align: center;
        }
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
        }
        .avatar {
            width: 36px;
            height: 36px;
            object-fit: cover;
        }
        @media (max-width: 992px) {
            .sidebar {
                width: 100%;
                position: relative;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="d-flex">
        {{-- Sidebar --}}
        <aside class="sidebar d-flex flex-column">
            {{-- Brand --}}
            <div class="p-4 border-bottom border-secondary">
                <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none d-flex align-items-center">
                    <i class="bi bi-shop fs-3 me-3"></i>
                    <span class="fs-5 fw-bold">Admin Panel</span>
                </a>
            </div>

            {{-- Navigation --}}
            <nav class="flex-grow-1 py-3 px-2">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2"></i>
                            <span class="ms-2">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.products.index') }}"
                           class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                            <i class="bi bi-box-seam"></i>
                            <span class="ms-2">Produk</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.categories.index') }}"
                           class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            <i class="bi bi-folder"></i>
                            <span class="ms-2">Kategori</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.orders.index') }}"
                           class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }} d-flex align-items-center">
                            <i class="bi bi-receipt"></i>
                            <span class="ms-2 flex-grow-1">Pesanan</span>
                            @if($pendingOrderCount ?? 0 > 0)
                                <span class="badge bg-warning text-dark rounded-pill">{{ $pendingOrderCount }}</span>
                            @endif
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href=""
                           class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="bi bi-people"></i>
                            <span class="ms-2">Pengguna</span>
                        </a>
                    </li>

                    <li class="nav-item mt-4">
                        <span class="nav-link text-muted small text-uppercase px-4">Laporan</span>
                    </li>

                    <li class="nav-item">
                        <a href=""
                           class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                            <i class="bi bi-graph-up"></i>
                            <span class="ms-2">Laporan Penjualan</span>
                        </a>
                    </li>
                </ul>
            </nav>

            {{-- User Info --}}
            <div class="p-3 border-top border-secondary">
                <div class="d-flex align-items-center text-white">
                    <img src="{{ auth()->user()->avatar_url ?? asset('images/default-avatar.png') }}"
                         alt="{{ auth()->user()->name }}"
                         class="rounded-circle avatar me-3">
                    <div>
                        <div class="small fw-semibold">{{ auth()->user()->name }}</div>
                        <div class="small text-muted">Administrator</div>
                    </div>
                </div>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="main-content">
            {{-- Top Bar --}}
            <header class="bg-white shadow-sm py-3 px-4 d-flex justify-content-between align-items-center border-bottom">
                <h4 class="mb-0">@yield('page-title', 'Dashboard')</h4>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm" target="_blank">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Toko
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
                    </form>
                </div>
            </header>

            {{-- Flash Messages --}}
            <div class="px-4 pt-3">
                @include('partials.flash-messages')
            </div>

            {{-- Page Content --}}
            <main class="p-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>

    @stack('scripts')
</body>
</html>