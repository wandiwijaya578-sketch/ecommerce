<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">

            {{-- ⬅️ Kembali --}}
            <li class="nav-item">
                <a href="{{ url()->previous() }}"
                   class="nav-link nav-icon-hover d-flex align-items-center gap-1"
                   title="Kembali">
                    <i class="ti ti-arrow-left fs-5"></i>
                </a>
            </li>

            {{-- 🏪 Lihat Toko --}}
            <li class="nav-item">
                <a href="{{ route('home') }}"
                   class="nav-link nav-icon-hover d-flex align-items-center gap-1"
                   title="Lihat Toko">
                    <i class="ti ti-building-store fs-5"></i>
                </a>
            </li>

            {{-- ☰ Toggle Sidebar (Mobile) --}}
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover"
                   id="headerCollapse"
                   href="javascript:void(0)">
                    <i class="ti ti-menu-2 fs-5"></i>
                </a>
            </li>

            {{-- 🔔 Notifikasi --}}
            <li class="nav-item">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                    <i class="ti ti-bell-ringing fs-5"></i>
                    <div class="notification bg-primary rounded-circle"></div>
                </a>
            </li>

        </ul>

        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">

                {{-- 👤 Profile --}}
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon-hover"
                       href="javascript:void(0)"
                       id="drop2"
                       data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <img src="{{ asset('assets/images/profile/user-1.jpg') }}"
                             alt="User"
                             width="35"
                             height="35"
                             class="rounded-circle border">
                    </a>

                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                         aria-labelledby="drop2">
                        <div class="message-body">

                            <a href="javascript:void(0)"
                               class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-user fs-6"></i>
                                <p class="mb-0 fs-3">My Profile</p>
                            </a>

                            <a href="javascript:void(0)"
                               class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-mail fs-6"></i>
                                <p class="mb-0 fs-3">My Account</p>
                            </a>

                            <a href="javascript:void(0)"
                               class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-list-check fs-6"></i>
                                <p class="mb-0 fs-3">My Task</p>
                            </a>

                            {{-- 🚪 Logout --}}
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="btn btn-outline-primary mx-3 mt-2 d-flex align-items-center justify-content-center gap-1">
                                <i class="ti ti-logout"></i> Logout
                            </a>

                            <form method="POST"
                                  action="{{ route('logout') }}"
                                  id="logout-form"
                                  class="d-none">
                                @csrf
                            </form>

                        </div>
                    </div>
                </li>

            </ul>
        </div>
    </nav>
</header>
