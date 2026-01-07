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
                        <i class="bi bi-key fs-1 text-dark"></i>
                        <h4 class="fw-bold mt-2 mb-0 text-dark">
                            Reset Password
                        </h4>
                        <small class="text-dark opacity-75">
                            Dwaa Lux Lighting
                        </small>
                    </div>

                    {{-- Body --}}
                    <div class="card-body p-4 p-lg-5">

                        {{-- Status --}}
                        @if (session('status'))
                            <div class="alert alert-success rounded-3 text-center">
                                {{ session('status') }}
                            </div>
                        @endif

                        <p class="text-muted text-center mb-4">
                            Masukkan email yang terdaftar.
                            Kami akan mengirimkan link untuk
                            mengatur ulang password Anda.
                        </p>

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            {{-- Email --}}
                            <div class="mb-4">
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

                            {{-- Submit --}}
                            <div class="d-grid mb-3">
                                <button type="submit"
                                        class="btn btn-lg rounded-3 fw-bold text-dark"
                                        style="background:#C9A24D;">
                                    <i class="bi bi-envelope-arrow-up me-1"></i>
                                    Kirim Link Reset Password
                                </button>
                            </div>

                            <div class="text-center">
                                <a href="{{ route('login') }}"
                                   class="text-decoration-none fw-semibold"
                                   style="color:#C9A24D;">
                                    ← Kembali ke Login
                                </a>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
