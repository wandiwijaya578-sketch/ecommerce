@extends('layouts.app')

@section('content')
<div class="min-vh-100 d-flex align-items-center"
     style="background: linear-gradient(135deg, #111827, #1f2933);">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                    {{-- Header --}}
                    <div class="text-center py-4"
                         style="background: linear-gradient(135deg, #C9A24D, #E6C77A);">
                        <i class="bi bi-shield-lock fs-1 text-dark"></i>
                        <h4 class="fw-bold mt-2 mb-0 text-dark">
                            Konfirmasi Password
                        </h4>
                        <small class="text-dark opacity-75">
                            Dwaa Lux Lighting
                        </small>
                    </div>

                    {{-- Body --}}
                    <div class="card-body p-4 p-lg-5">

                        <p class="text-muted text-center mb-4">
                            Demi keamanan akun Anda, silakan masukkan
                            password untuk melanjutkan.
                        </p>

                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            {{-- Password --}}
                            <div class="mb-4">
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

                            {{-- Confirm --}}
                            <div class="d-grid mb-3">
                                <button type="submit"
                                        class="btn btn-lg rounded-3 fw-bold text-dark"
                                        style="background:#C9A24D;">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Konfirmasi
                                </button>
                            </div>

                            {{-- Forgot --}}
                            @if (Route::has('password.request'))
                                <div class="text-center">
                                    <a href="{{ route('password.request') }}"
                                       class="text-decoration-none fw-semibold"
                                       style="color:#C9A24D;">
                                        Lupa password?
                                    </a>
                                </div>
                            @endif

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
