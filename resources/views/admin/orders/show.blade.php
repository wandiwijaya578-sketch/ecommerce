@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">

    <h3>Order #{{ $order->order_number }}</h3>
    <p>Status: {{ $order->status }}</p>

    @if($order->status === 'pending' && $snapToken)
        <button id="pay-button" class="btn btn-primary btn-lg">
            Bayar Sekarang
        </button>
    @else
        <p class="text-danger">Snap token tidak tersedia</p>
    @endif

</div>
@endsection


@if($snapToken)
@push('scripts')

<!-- SNAP JS (WAJIB ADA DI NETWORK TAB) -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.clientKey') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    console.log('DOM LOADED');

    const btn = document.getElementById('pay-button');
    console.log('Button:', btn);

    if (!btn) {
        console.log('BUTTON TIDAK ADA');
        return;
    }

    btn.addEventListener('click', function () {
        console.log('BUTTON DIKLIK');

        if (typeof window.snap === 'undefined') {
            alert('Snap.js TIDAK KELOAD');
            return;
        }

        window.snap.pay('{{ $snapToken }}');
    });

});
</script>

@endpush
@endif
