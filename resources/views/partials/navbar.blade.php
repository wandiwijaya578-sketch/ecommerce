<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top navbar-lux">
    <div class="container align-items-center">

        {{-- LOGO --}}
        <a class="navbar-brand d-flex align-items-center fw-bold" href="{{ route('home') }}">
            <i class="bi bi-lightbulb-fill me-2 brand-icon"></i>
            <span class="brand-text">Dwaa Lux Lighting</span>
        </a>

        {{-- TOGGLE MOBILE --}}
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">

            {{-- KATEGORI --}}
            <ul class="navbar-nav ms-lg-4 me-3">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-medium d-flex align-items-center"
                       href="#"
                       data-bs-toggle="dropdown">
                        <i class="bi bi-grid-3x3-gap me-2 category-title-icon"></i>
                        Kategori
                    </a>

                    <ul class="dropdown-menu shadow rounded-3 category-dropdown">

                        {{-- AMAN: kalau categories belum ada --}}
                        @forelse(($categories ?? []) as $category)
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                   href="{{ route('catalog.index',['category'=>$category->slug]) }}">
                                    <i class="bi bi-lightbulb me-2 category-icon"></i>
                                    {{ $category->name }}
                                </a>
                            </li>
                        @empty
                            <li>
                                <span class="dropdown-item text-muted small">
                                    Belum ada kategori
                                </span>
                            </li>
                        @endforelse

                    </ul>
                </li>
            </ul>

            {{-- SEARCH --}}
            <form class="d-flex flex-grow-1 mx-lg-3 my-3 my-lg-0"
                  action="{{ route('catalog.index') }}" method="GET">
                <div class="input-group search-lux">
                    <input type="text"
                           class="form-control"
                           name="q"
                           placeholder="Cari produk..."
                           value="{{ request('q') }}">
                    <button class="btn btn-search" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            {{-- ICON MENU --}}
            <ul class="navbar-nav ms-auto align-items-center">

                {{-- WISHLIST --}}
                <li class="nav-item me-3">
                    <a class="nav-link position-relative" href="{{ route('wishlist.index') }}">
                        <i class="bi bi-heart fs-5"></i>
                        @auth
                            @if(auth()->user()->wishlistProducts()->count())
                                <span class="badge badge-lux">
                                    {{ auth()->user()->wishlistProducts()->count() }}
                                </span>
                            @endif
                        @endauth
                    </a>
                </li>

                {{-- CART --}}
                <li class="nav-item me-3">
                    <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                        <i class="bi bi-cart3 fs-5"></i>
                        @auth
                            @if(auth()->user()->cart?->items()->count())
                                <span class="badge badge-lux">
                                    {{ auth()->user()->cart->items()->count() }}
                                </span>
                            @endif
                        @endauth
                    </a>
                </li>

                {{-- USER --}}
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center"
                           data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-4 me-1"></i>
                            <span class="fw-medium">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow rounded-3">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
                            <li><a class="dropdown-item" href="{{ route('orders.index') }}">Pesanan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-login-lux px-4">
                            Masuk
                        </a>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>
