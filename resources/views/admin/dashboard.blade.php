@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

{{-- =======================
   1. STAT CARDS
======================= --}}
<div class="row g-4 mb-4">

   <div>
    <a href="{{ route('admin.reports.sales.export', request()->all()) }}"
   class="btn btn-success">
   Export Excel
</a>

   </div>

    {{-- Total Revenue --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-4 border-success h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted text-uppercase fw-semibold">Total Pendapatan</small>
                    <h4 class="fw-bold text-success mb-0">
                        Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
                    </h4>
                </div>
                <i class="bi bi-wallet2 text-success fs-2"></i>
            </div>
        </div>
    </div>

    {{-- Pending Orders --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-4 border-warning h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted text-uppercase fw-semibold">Perlu Diproses</small>
                    <h4 class="fw-bold text-warning mb-0">
                        {{ $stats['pending_orders'] }}
                    </h4>
                </div>
                <i class="bi bi-box-seam text-warning fs-2"></i>
            </div>
        </div>
    </div>

    {{-- Low Stock --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-4 border-danger h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted text-uppercase fw-semibold">Stok Menipis</small>
                    <h4 class="fw-bold text-danger mb-0">
                        {{ $stats['low_stock'] }}
                    </h4>
                </div>
                <i class="bi bi-exclamation-triangle text-danger fs-2"></i>
            </div>
        </div>
    </div>

    {{-- Total Products --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-4 border-primary h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted text-uppercase fw-semibold">Total Produk</small>
                    <h4 class="fw-bold text-primary mb-0">
                        {{ $stats['total_products'] }}
                    </h4>
                </div>
                <i class="bi bi-tags text-primary fs-2"></i>
            </div>
        </div>
    </div>
</div>

{{-- =======================
   2. CHART & RECENT ORDERS
======================= --}}
<div class="row g-4">

    {{-- Revenue Chart --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold">
                Grafik Penjualan (7 Hari Terakhir)
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="120"></canvas>
            </div>
        </div>
    </div>

    {{-- Recent Orders --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold">
                Pesanan Terbaru
            </div>

            <div class="list-group list-group-flush">
                @forelse($recentOrders as $order)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold">#{{ $order->order_number }}</div>
                            <small class="text-muted">{{ $order->user->name }}</small>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </div>

                            {{-- STATUS BADGE --}}
                            <span class="badge rounded-pill
                                @if($order->status === 'pending') bg-warning
                                @elseif($order->status === 'processing') bg-info
                                @elseif($order->status === 'completed') bg-success
                                @else bg-secondary @endif
                            ">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">
                        Belum ada pesanan
                    </div>
                @endforelse
            </div>

            <div class="card-footer bg-white text-center">
                <a href="{{ route('admin.orders.index') }}" class="fw-bold text-decoration-none">
                    Lihat Semua Pesanan →
                </a>
            </div>
        </div>
    </div>
</div>

{{-- =======================
   3. TOP PRODUCTS
======================= --}}
<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-white fw-bold">
        Produk Terlaris
    </div>

    <div class="card-body">
        <div class="row g-4">
            @forelse($topProducts as $product)
                <div class="col-6 col-md-2 text-center">
                    <img
                        src="{{ $product->image_url }}"
                        class="img-fluid rounded mb-2"
                        style="height: 90px; object-fit: cover;"
                    >
                    <div class="fw-semibold text-truncate">
                        {{ $product->name }}
                    </div>
                    <small class="text-muted">{{ $product->sold }} terjual</small>
                </div>
            @empty
                <div class="text-center text-muted py-4">
                    Belum ada produk terjual
                </div>
            @endforelse
        </div>
    </div>
</div>

{{-- =======================
   CHART.JS
======================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($revenueChart->pluck('date')) !!},
            datasets: [{
                data: {!! json_encode($revenueChart->pluck('total')) !!},
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    ticks: {
                        callback: value =>
                            'Rp ' + new Intl.NumberFormat('id-ID', { notation: 'compact' }).format(value)
                    }
                }
            }
        }
    });
</script>

@endsection
