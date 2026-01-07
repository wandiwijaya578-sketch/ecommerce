@extends('layouts.app')

@section('content')
<div class="min-vh-100 d-flex align-items-center"
     style="background: linear-gradient(160deg, #111827, #1f2933);">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                    {{-- Header --}}
                    <div class="text-center py-4"
                         style="background: linear-gradient(135deg, #C9A24D, #E6C77A);">
                        <i class="bi bi-lightbulb-fill fs-1 text-dark"></i>
                        <h4 class="fw-bold mt-2 mb-0 text-dark">
                            Dwaa Lux Lighting
                        </h4>
                        <small class="text-dark opacity-75">
                            Masuk ke akun Anda
                        </small>
                    </div>

                    {{-- Body --}}
                    <div class="card-body p-4 p-lg-5">

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            {{-- Email --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       class="form-control form-control-lg rounded-3
                                       @error('email') is-invalid @enderror"
                                       placeholder="nama@email.com"
                                       required autofocus>
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

                            {{-- Remember --}}
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                           name="remember" id="remember"
                                           {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        Ingat saya
                                    </label>
                                </div>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}"
                                       class="text-decoration-none fw-semibold"
                                       style="color:#C9A24D;">
                                        Lupa password?
                                    </a>
                                @endif
                            </div>

                            {{-- Login Button --}}
                            <div class="d-grid mb-3">
                                <button type="submit"
                                        class="btn btn-lg rounded-3 fw-bold text-dark"
                                        style="background:#C9A24D;">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>
                                    Login
                                </button>
                            </div>

                            {{-- Google --}}
                            <div class="d-grid mb-4">
                                <a href="{{ route('auth.google') }}"
                                   class="btn btn-outline-dark btn-lg rounded-3">
                                    <i class="bi bi-google me-1"></i>
                                    Login dengan Google
                                </a>
                            </div>

                            {{-- Register --}}
                            <p class="text-center mb-0">
                                Belum punya akun?
                                <a href="{{ route('register') }}"
                                   class="fw-bold text-decoration-none"
                                   style="color:#C9A24D;">
                                    Daftar Sekarang
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
