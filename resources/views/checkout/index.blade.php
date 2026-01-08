@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-5">

    <h1 class="fw-bold mb-5 text-center">
        Checkout
        <span class="d-block text-muted fs-6 fw-normal">
            Lengkapi informasi sebelum melakukan pemesanan
        </span>
    </h1>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf

        <div class="row g-5">

            {{-- ================= INFORMASI PENGIRIMAN ================= --}}
            <div class="col-lg-8">
                <div class="card card-lux shadow-sm">
                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                            <i class="bi bi-truck text-lux"></i>
                            Informasi Pengiriman
                        </h5>

                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label">Nama Penerima</label>
                                <input type="text"
                                       name="name"
                                       class="form-control form-control-lux"
                                       value="{{ auth()->user()->name }}"
                                       required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="text"
                                       name="phone"
                                       class="form-control form-control-lux"
                                       placeholder="08xxxxxxxxxx"
                                       required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea name="address"
                                          rows="4"
                                          class="form-control form-control-lux"
                                          placeholder="Nama jalan, nomor rumah, kota"
                                          required></textarea>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ================= RINGKASAN PESANAN ================= --}}
            <div class="col-lg-4">
                <div class="card card-lux shadow sticky-top" style="top: 1.5rem;">
                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                            <i class="bi bi-receipt text-lux"></i>
                            Ringkasan Pesanan
                        </h5>

                        <div class="order-items mb-4">
                            @foreach($cart->items as $item)
                                <div class="d-flex justify-content-between align-items-start mb-3 small">
                                    <div class="me-2">
                                        <div class="fw-medium">
                                            {{ $item->product->name }}
                                        </div>
                                        <div class="text-muted">
                                            Qty {{ $item->quantity }}
                                        </div>
                                    </div>
                                    <div class="fw-semibold text-dark">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="fw-semibold">Total Pembayaran</span>
                            <span class="fs-5 fw-bold text-lux">
                                Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}
                            </span>
                        </div>

                        <button type="submit"
                                class="btn btn-lux btn-lg w-100 shadow">
                            <i class="bi bi-lock-fill me-1"></i>
                            Buat Pesanan
                        </button>

                        <p class="text-center text-muted small mt-3 mb-0">
                            Pembayaran aman & terenkripsi
                        </p>

                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection
