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
                        <i class="bi bi-shield-check fs-1 text-dark"></i>
                        <h4 class="fw-bold mt-2 mb-0 text-dark">
                            Reset Password
                        </h4>
                        <small class="text-dark opacity-75">
                            Dwaa Lux Lighting
                        </small>
                    </div>

                    {{-- Body --}}
                    <div class="card-body p-4 p-lg-5">

                        <p class="text-muted text-center mb-4">
                            Silakan buat password baru untuk akun Anda.
                        </p>

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            {{-- Token --}}
                            <input type="hidden" name="token" value="{{ $token }}">

                            {{-- Email --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email"
                                       name="email"
                                       value="{{ $email ?? old('email') }}"
                                       class="form-control form-control-lg rounded-3
                                       @error('email') is-invalid @enderror"
                                       placeholder="nama@email.com"
                                       required autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password Baru --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password Baru</label>
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

                            {{-- Konfirmasi --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Konfirmasi Password</label>
                                <input type="password"
                                       name="password_confirmation"
                                       class="form-control form-control-lg rounded-3"
                                       placeholder="••••••••"
                                       required>
                            </div>

                            {{-- Submit --}}
                            <div class="d-grid">
                                <button type="submit"
                                        class="btn btn-lg rounded-3 fw-bold text-dark"
                                        style="background:#C9A24D;">
                                    <i class="bi bi-check2-circle me-1"></i>
                                    Simpan Password Baru
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
