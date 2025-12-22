@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">
                        <i class="bi bi-shield-lock me-1"></i> Login ke Akun Anda
                    </h4>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="nama@email.com"
                                   required autofocus>

                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password"
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="••••••••"
                                   required>

                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Remember --}}
                        <div class="mb-3 form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="remember"
                                   id="remember"
                                   {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Ingat Saya
                            </label>
                        </div>

                        {{-- Login --}}
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Login
                            </button>
                        </div>

                        {{-- Lupa password --}}
                        @if (Route::has('password.request'))
                            <div class="text-center mb-3">
                                <a href="{{ route('password.request') }}" class="text-decoration-none">
                                    Lupa Password?
                                </a>
                            </div>
                        @endif

                        <hr>

                        {{-- Google Login --}}
                        <div class="d-grid mb-3">
                            <a href="{{ route('auth.google') }}"
                               class="btn btn-outline-danger btn-lg">
                                <i class="bi bi-google me-1"></i>
                                Login dengan Google
                            </a>
                        </div>

                        {{-- Register --}}
                        <p class="text-center mb-0">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="fw-bold text-decoration-none">
                                Daftar Sekarang
                            </a>
                        </p>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
