@extends('layouts.app')

@section('content')

<style>
    :root {
        --lux-gold: #C9A24D;
        --lux-dark: #111111;
        --lux-soft: #F7F7F7;
    }

    .lux-card {
        background: #fff;
        border-radius: 18px;
    }

    .lux-header {
        background: linear-gradient(135deg, #111111, #1c1c1c);
        color: #fff;
    }

    .lux-badge {
        background: var(--lux-gold);
        color: #111;
        font-weight: 600;
    }

    .lux-title i {
        color: var(--lux-gold);
    }

    .lux-total {
        background: linear-gradient(135deg, #fffaf0, #ffffff);
        border: 1px solid #f0e6cc;
        border-radius: 14px;
        padding: 16px 20px;
    }

    .btn-lux {
        background: linear-gradient(135deg, #C9A24D, #E6C77B);
        border: none;
        color: #111;
        font-weight: 600;
    }

    .btn-lux:hover {
        background: linear-gradient(135deg, #B8913D, #D9B968);
        color: #111;
    }

    .step {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #555;
    }

    .step.active {
        background: var(--lux-gold);
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-9">

            <div class="card lux-card border-0 shadow-lg overflow-hidden">

                {{-- HEADER --}}
                <div class="lux-header px-4 py-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <h1 class="h4 fw-bold mb-1">
                                Toko Dwaa Lux
                            </h1>
                            <small class="opacity-75">
                                Order #{{ $order->order_number }} •
                                {{ $order->created_at->format('d M Y • H:i') }}
                            </small>
                        </div>

                        <span class="badge lux-badge px-4 py-2 rounded-pill">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    {{-- PROGRESS --}}
                    <div class="d-flex align-items-center gap-2 mt-3">
                        <div class="step {{ in_array($order->status,['pending','processing','shipped','delivered']) ? 'active' : '' }}"></div>
                        <div class="step {{ in_array($order->status,['processing','shipped','delivered']) ? 'active' : '' }}"></div>
                        <div class="step {{ in_array($order->status,['shipped','delivered']) ? 'active' : '' }}"></div>
                        <div class="step {{ $order->status === 'delivered' ? 'active' : '' }}"></div>
                        <small class="ms-2 opacity-75">Status Pesanan</small>
                    </div>
                </div>

                {{-- PRODUK --}}
                <div class="card-body px-4 pt-4">
                    <h5 class="fw-semibold mb-4 lux-title">
                        <i class="bi bi-gem me-2"></i>
                        Detail Produk
                    </h5>

                    <div class="table-responsive">
                        <table class="table table-borderless align-middle">
                            <thead class="text-muted border-bottom">
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Harga</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr class="border-bottom">
                                    <td class="fw-medium">{{ $item->product_name }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">
                                        Rp {{ number_format($item->discount_price ?? $item->price, 0, ',', '.') }}
                                    </td>
                                    <td class="text-end fw-semibold">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                @if($order->shipping_cost > 0)
                                <tr>
                                    <td colspan="3" class="text-end pt-3 text-muted">
                                        Ongkos Kirim
                                    </td>
                                    <td class="text-end pt-3">
                                        Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="4" class="pt-4">
                                        <div class="d-flex justify-content-between align-items-center lux-total">
                                            <span class="fw-semibold fs-5">
                                                TOTAL PEMBAYARAN
                                            </span>
                                            <span class="fs-4 fw-bold text-dark">
                                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                {{-- ALAMAT --}}
                <div class="card-body bg-light px-4 border-top">
                    <h5 class="fw-semibold mb-3 lux-title">
                        <i class="bi bi-geo-alt-fill me-2"></i>
                        Alamat Pengiriman
                    </h5>
                    <address class="mb-0 text-muted">
                        <strong class="text-dark">{{ $order->shipping_name }}</strong><br>
                        {{ $order->shipping_phone }}<br>
                        {{ $order->shipping_address }}
                    </address>
                </div>

                {{-- BAYAR --}}
                @if($order->status === 'pending' && $snapToken)
                <div class="card-body text-center border-top py-4">
                    <p class="text-muted mb-4">
                        Selesaikan pembayaran untuk melanjutkan pesanan Anda.
                    </p>
                    <button id="pay-button"
                        class="btn btn-lux btn-lg px-5 rounded-pill shadow-lg">
                        <i class="bi bi-credit-card me-2"></i>
                        Bayar Sekarang
                    </button>
                </div>
                @endif

            </div>

        </div>
    </div>
</div>

{{-- MIDTRANS --}}
@if($snapToken)
@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.clientKey') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('pay-button');
    if (!btn) return;

    btn.addEventListener('click', function () {
        btn.disabled = true;
        btn.innerHTML =
            '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';

        snap.pay('{{ $snapToken }}', {
            onSuccess: () => window.location.href = "{{ route('orders.success', $order) }}",
            onPending: () => window.location.href = "{{ route('orders.pending', $order) }}",
            onError: () => {
                alert('Pembayaran gagal');
                btn.disabled = false;
                btn.innerHTML = 'Bayar Sekarang';
            },
            onClose: () => {
                btn.disabled = false;
                btn.innerHTML = 'Bayar Sekarang';
            }
        });
    });
});
</script>
@endpush
@endif
@endsection
