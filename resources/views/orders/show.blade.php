@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

            {{-- Header Order --}}
            <div class="p-6 border-b border-gray-200 flex justify-between items-start">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Order #{{ $order->order_number }}
                    </h1>
                    <p class="text-gray-500 mt-1">
                        {{ $order->created_at->format('d M Y, H:i') }}
                    </p>
                </div>

                {{-- Status --}}
                <span class="px-4 py-2 rounded-full text-sm font-semibold
                    @switch($order->status)
                        @case('pending') bg-yellow-100 text-yellow-800 @break
                        @case('processing') bg-blue-100 text-blue-800 @break
                        @case('shipped') bg-purple-100 text-purple-800 @break
                        @case('delivered') bg-green-100 text-green-800 @break
                        @case('cancelled') bg-red-100 text-red-800 @break
                    @endswitch">
                    {{ ucfirst($order->status) }}
                </span>
            </div>

            {{-- Detail Items --}}
            <div class="p-6">
                <h3 class="text-lg font-semibold mb-4">Produk yang Dipesan</h3>

                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left pb-3">Produk</th>
                            <th class="text-center pb-3">Qty</th>
                            <th class="text-right pb-3">Harga</th>
                            <th class="text-right pb-3">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($order->items as $item)
                        <tr>
                            <td class="py-4">{{ $item->product_name }}</td>
                            <td class="py-4 text-center">{{ $item->quantity }}</td>
                            <td class="py-4 text-right">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </td>
                            <td class="py-4 text-right">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-t-2">
                        @if($order->shipping_cost > 0)
                        <tr>
                            <td colspan="3" class="pt-4 text-right">Ongkos Kirim:</td>
                            <td class="pt-4 text-right">
                                Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td colspan="3" class="pt-2 text-right font-bold text-lg">
                                TOTAL BAYAR:
                            </td>
                            <td class="pt-2 text-right font-bold text-lg text-indigo-600">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- Alamat --}}
            <div class="p-6 bg-gray-50 border-t">
                <h3 class="text-lg font-semibold mb-3">Alamat Pengiriman</h3>
                <p class="font-medium">{{ $order->shipping_name }}</p>
                <p>{{ $order->shipping_phone }}</p>
                <p>{{ $order->shipping_address }}</p>
            </div>

            {{-- Tombol Bayar --}}
            @if($order->status === 'pending' && !empty($snapToken))
            <div class="p-6 bg-indigo-50 border-t text-center">
                <button id="pay-button"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white
                               font-bold py-3 px-8 rounded-lg text-lg">
                    💳 Bayar Sekarang
                </button>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection

{{-- SNAP SCRIPT --}}
@if(!empty($snapToken))
@push('scripts')
<script src="{{ config('midtrans.snap_url') }}"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.getElementById('pay-button')?.addEventListener('click', function () {
    const btn = this;
    btn.disabled = true;
    btn.innerText = 'Memproses...';

    snap.pay('{{ $snapToken }}', {
        onSuccess: function () {
            window.location.href = "{{ route('orders.success', $order) }}";
        },
        onPending: function () {
            window.location.href = "{{ route('orders.pending', $order) }}";
        },
        onError: function () {
            alert('Pembayaran gagal.');
            btn.disabled = false;
            btn.innerText = '💳 Bayar Sekarang';
        },
        onClose: function () {
            btn.disabled = false;
            btn.innerText = '💳 Bayar Sekarang';
        }
    });
});
</script>
@endpush
@endif
