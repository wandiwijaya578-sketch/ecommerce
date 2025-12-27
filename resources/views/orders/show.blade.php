
@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-sm">

                {{-- Header Order --}}
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h1 class="h3 mb-1 fw-bold text-dark">
                                Order #{{ $order->order_number }}
                            </h1>
                            <p class="text-muted mb-0">
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>

                        {{-- Status Badge --}}
                        <span class="badge rounded-pill fs-6 px-4 py-2
                            @switch($order->status)
                                @case('pending')
                                    bg-warning text-dark
                                    @break
                                @case('processing')
                                    bg-primary text-white
                                    @break
                                @case('shipped')
                                    bg-info text-white
                                    @break
                                @case('delivered')
                                    bg-success text-white
                                    @break
                                @case('cancelled')
                                    bg-danger text-white
                                    @break
                                @default
                                    bg-secondary text-white
                            @endswitch
                        ">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>

                {{-- Detail Items --}}
                <div class="card-body">
                    <h3 class="h5 fw-semibold mb-4">Produk yang Dipesan</h3>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">Produk</th>
                                    <th class="border-0 text-center">Qty</th>
                                    <th class="border-0 text-end">Harga</th>
                                    <th class="border-0 text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">
                                        Rp {{ number_format($item->discount_price ?? $item->price, 0, ',', '.') }}
                                    </td>
                                    <td class="text-end">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="border-top border-3">
                                @if($order->shipping_cost > 0)
                                <tr>
                                    <td colspan="3" class="pt-3 text-end">Ongkos Kirim:</td>
                                    <td class="pt-3 text-end">
                                        Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="3" class="pt-3 text-end">
                                        <strong class="h5 mb-0">TOTAL BAYAR:</strong>
                                    </td>
                                    <td class="pt-3 text-end">
                                        <strong class="h4 mb-0 text-primary">
                                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                        </strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                {{-- Alamat Pengiriman --}}
                <div class="card-body bg-light border-top">
                    <h3 class="h5 fw-semibold mb-3">Alamat Pengiriman</h3>
                    <address class="mb-0">
                        <strong>{{ $order->shipping_name }}</strong><br>
                        {{ $order->shipping_phone }}<br>
                        {{ $order->shipping_address }}
                    </address>
                </div>

                <div class="alert alert-info">
                    Status : {{ ($order->status) ?? 'NULL' }}.
                </div>

                {{-- Tombol Bayar (hanya jika pending) --}}
                @if($order->status === 'pending' && $snapToken)
                <div class="card-body bg-primary bg-opacity-10 border-top text-center">
                    <p class="text-muted mb-4">
                        Selesaikan pembayaran Anda sebelum batas waktu berakhir.
                    </p>
                    <button id="pay-button" class="btn btn-primary btn-lg px-5 shadow-sm">
                        <i class="bi bi-credit-card me-2"></i> Bayar Sekarang
                    </button>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

{{-- Snap.js Integration --}}
@if($snapToken)
@push('scripts')

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.clientKey') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const payButton = document.getElementById('pay-button');

    if (!payButton) return;

    payButton.addEventListener('click', function () {
        payButton.disabled = true;
        payButton.innerHTML = 'Memproses...';

        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function () {
                window.location.href = "{{ route('orders.success', $order) }}";
            },
            onPending: function () {
                window.location.href = "{{ route('orders.pending', $order) }}";
            },
            onError: function () {
                alert('Pembayaran gagal');
                payButton.disabled = false;
                payButton.innerHTML = 'Bayar Sekarang';
            },
            onClose: function () {
                payButton.disabled = false;
                payButton.innerHTML = 'Bayar Sekarang';
            }
        });
    });
});
</script>

@endpush
@endif
`

@endsection
