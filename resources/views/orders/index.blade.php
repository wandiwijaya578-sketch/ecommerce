@extends('layouts.app')

@section('content')
<style>
    :root {
        --lux-gold: #C9A24D;
        --lux-dark: #111111;
        --lux-soft: #F7F7F7;
    }

    .lux-card {
        border-radius: 18px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    }

    .lux-badge {
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 12px;
        font-size: 0.85rem;
    }

    .lux-badge.pending {
        background: #facc15; color: #111;
    }
    .lux-badge.processing {
        background: #0ea5e9; color: #fff;
    }
    .lux-badge.shipped {
        background: #6366f1; color: #fff;
    }
    .lux-badge.delivered {
        background: #16a34a; color: #fff;
    }
    .lux-badge.cancelled {
        background: #dc2626; color: #fff;
    }

    .table-hover tbody tr:hover {
        background-color: #f7f7f7;
    }

    .btn-lux-outline {
        border-color: var(--lux-gold);
        color: var(--lux-gold);
        font-weight: 500;
    }

    .btn-lux-outline:hover {
        background: var(--lux-gold);
        color: #111;
    }

    .pagination .page-item.active .page-link {
        background: var(--lux-gold);
        border-color: var(--lux-gold);
        color: #111;
        font-weight: 600;
    }
</style>

<div class="container py-5">
    <h1 class="h3 mb-4 fw-bold text-dark">Daftar Pesanan Saya</h1>

    <div class="card lux-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No. Order</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="fw-bold text-dark">#{{ $order->order_number }}</td>
                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <span class="lux-badge {{ $order->status }}">
                                    @if($order->status == 'pending') Pending
                                    @elseif($order->status == 'processing') Diproses
                                    @elseif($order->status == 'shipped') Dikirim
                                    @elseif($order->status == 'delivered') Sampai
                                    @elseif($order->status == 'cancelled') Batal
                                    @else {{ ucfirst($order->status) }}
                                    @endif
                                </span>
                            </td>
                            <td class="fw-bold text-dark">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="text-end">
                                <a href="{{ route('orders.show', $order) }}"
                                   class="btn btn-sm btn-lux-outline rounded-pill">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada pesanan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white d-flex justify-content-center">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
