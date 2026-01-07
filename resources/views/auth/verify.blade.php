@extends('layouts.app')

@section('content')
<div class="min-vh-100 d-flex align-items-center"
     style="background: linear-gradient(135deg, #111827, #1f2933);">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                    {{-- Header --}}
                    <div class="text-center py-4"
                         style="background: linear-gradient(135deg, #C9A24D, #E6C77A);">
                        <i class="bi bi-envelope-check fs-1 text-dark"></i>
                        <h4 class="fw-bold mt-2 mb-0 text-dark">
                            Verifikasi Email
                        </h4>
                        <small class="text-dark opacity-75">
                            Dwaa Lux Lighting
                        </small>
                    </div>

                    {{-- Body --}}
                    <div class="card-body p-4 p-lg-5 text-center">

                        {{-- Alert sukses --}}
                        @if (session('resent'))
                            <div class="alert alert-success rounded-3">
                                Link verifikasi baru telah dikirim ke email Anda.
                            </div>
                        @endif

                        <p class="text-muted mb-3">
                            Sebelum melanjutkan, silakan periksa email Anda dan klik
                            link verifikasi yang kami kirimkan.
                        </p>

                        <p class="text-muted mb-4">
                            Tidak menerima email?
                        </p>

                        <form method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit"
                                    class="btn btn-lg rounded-3 fw-bold text-dark"
                                    style="background:#C9A24D;">
                                <i class="bi bi-arrow-repeat me-1"></i>
                                Kirim Ulang Email Verifikasi
                            </button>
                        </form>

                        <hr class="my-4">

                        <a href="{{ route('home') }}"
                           class="text-decoration-none fw-semibold"
                           style="color:#C9A24D;">
                            ← Kembali ke Beranda
                        </a>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
