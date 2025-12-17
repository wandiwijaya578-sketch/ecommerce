<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- FONT MODERN -->
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700,800" rel="stylesheet">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
</head>
<body>
    <div id="app">
      {{-- ================================================ NAVBAR (Menu
      Navigasi Atas) ================================================ --}}
      <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        {{-- ↑ navbar-expand-md = hamburger menu di layar kecil navbar-light =
        warna teks gelap bg-white = background putih shadow-sm = bayangan halus
        --}}

        <div class="container">
          {{-- Logo dan Nama Toko --}}
          <a class="navbar-brand" href="{{ url('/') }}">
            🛒 {{ config('app.name', 'Toko Online') }}
          </a>

          {{-- Tombol Hamburger (untuk mobile) --}}
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
          >
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar (Kosong untuk sekarang) -->
            <ul class="navbar-nav me-auto"></ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
              {{-- ================================================ CEK STATUS
              LOGIN ================================================ @guest =
              user BELUM login @else = user SUDAH login
              ================================================ --}} @guest {{--
              TAMPILAN UNTUK GUEST (Belum Login) --}} @if (Route::has('login'))
              <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}"> Login </a>
              </li>
              @endif @if (Route::has('register'))
              <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">
                  Register
                </a>
              </li>
              @endif @else {{-- TAMPILAN UNTUK USER YANG SUDAH LOGIN --}}

              <li class="nav-item dropdown">
                <a
                  id="navbarDropdown"
                  class="nav-link dropdown-toggle"
                  href="#"
                  role="button"
                  data-bs-toggle="dropdown"
                >
                  {{ Auth::user()->name }} {{-- ↑ Tampilkan nama user yang login
                  --}}
                </a>

                <div class="dropdown-menu dropdown-menu-end">
                  {{-- Tombol Logout --}}
                  <a
                    class="dropdown-item"
                    href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"
                  >
                    Logout
                  </a>
                  {{-- ↑ onclick: Mencegah link biasa, lalu submit form logout
                  --}} {{-- Form Logout (tersembunyi) --}}
                  <form
                    id="logout-form"
                    action="{{ route('logout') }}"
                    method="POST"
                    class="d-none"
                  >
                    @csrf {{-- ↑ WAJIB ada @csrf untuk POST request --}}
                  </form>
                </div>
              </li>
              @endguest
            </ul>
          </div>
        </div>
      </nav>

      {{-- ================================================ MAIN CONTENT
      ================================================ --}}
      <main class="py-4">
        @yield('content') {{-- ↑ Di sinilah konten dari setiap halaman akan
        ditampilkan Setiap halaman menggunakan @section('content') --}}
      </main>
    </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
  </body>
</html>
