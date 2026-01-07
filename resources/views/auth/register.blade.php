@extends('layouts.app')

@section('content')
<div class="min-vh-100 d-flex align-items-center"
     style="background: linear-gradient(135deg, #111827, #1f2933);">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                    {{-- Header --}}
                    <div class="text-center py-4"
                         style="background: linear-gradient(135deg, #C9A24D, #E6C77A);">
                        <i class="bi bi-lightbulb-fill fs-1 text-dark"></i>
                        <h4 class="fw-bold mt-2 mb-0 text-dark">
                            Dwaa Lux Lighting
                        </h4>
                        <small class="text-dark opacity-75">
                            Buat akun baru
                        </small>
                    </div>

                    {{-- Body --}}
                    <div class="card-body p-4 p-lg-5">

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            {{-- Nama --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text"
                                       name="name"
                                       value="{{ old('name') }}"
                                       class="form-control form-control-lg rounded-3
                                       @error('name') is-invalid @enderror"
                                       placeholder="Nama Anda"
                                       required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       class="form-control form-control-lg rounded-3
                                       @error('email') is-invalid @enderror"
                                       placeholder="nama@email.com"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password</label>
                                <input type="password"
                                       name="password"
                                       class="form-control form-control-lg rounded-3
                                       @error('password') is-invalid @enderror"
                                       placeholder="••••••••"
                                       required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Konfirmasi Password --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Konfirmasi Password</label>
                                <input type="password"
                                       name="password_confirmation"
                                       class="form-control form-control-lg rounded-3"
                                       placeholder="••••••••"
                                       required>
                            </div>

                            {{-- Register --}}
                            <div class="d-grid mb-4">
                                <button type="submit"
                                        class="btn btn-lg rounded-3 fw-bold text-dark"
                                        style="background:#C9A24D;">
                                    <i class="bi bi-person-plus me-1"></i>
                                    Daftar
                                </button>
                            </div>

                            {{-- Divider --}}
                            <div class="position-relative text-center mb-4">
                                <hr>
                                <span class="position-absolute top-50 start-50 translate-middle
                                             bg-white px-3 text-muted">
                                    atau daftar dengan
                                </span>
                            </div>

                            {{-- Google --}}
                            <div class="d-grid mb-4">
                                <a href="{{ route('auth.google') }}"
                                   class="btn btn-outline-dark btn-lg rounded-3">
                                    <i class="bi bi-google me-1"></i>
                                    Daftar dengan Google
                                </a>
                            </div>

                            {{-- Login --}}
                            <p class="text-center mb-0">
                                Sudah punya akun?
                                <a href="{{ route('login') }}"
                                   class="fw-bold text-decoration-none"
                                   style="color:#C9A24D;">
                                    Login
                                </a>
                            </p>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
