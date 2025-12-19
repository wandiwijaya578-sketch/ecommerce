@extends('layouts.admin')

@section('title', 'Dashboard')
@section('content')
  <!-- Row Stats Cards -->
  <div class="row">
    <div class="col-lg-3 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="me-4">
              <div class="round-48 round bg-primary-subtle d-flex align-items-center justify-content-center">
                <i class="ti ti-currency-dollar fs-7 text-primary"></i>
              </div>
            </div>
            <div>
              <h4 class="mb-0 fw-semibold">Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}</h4>
              <p class="mb-0 text-muted">Total Pendapatan</p>
              <small class="text-success fw-medium"><i class="ti ti-trending-up"></i> +12.5%</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="me-4">
              <div class="round-48 round bg-info-subtle d-flex align-items-center justify-content-center">
                <i class="ti ti-shopping-cart fs-7 text-info"></i>
              </div>
            </div>
            <div>
              <h4 class="mb-0 fw-semibold">{{ $stats['total_orders'] ?? 0 }}</h4>
              <p class="mb-0 text-muted">Total Pesanan</p>
              <small class="text-info fw-medium"><i class="ti ti-arrow-up-right"></i> +8.3%</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="me-4">
              <div class="round-48 round bg-warning-subtle d-flex align-items-center justify-content-center">
                <i class="ti ti-clock-hour-3 fs-7 text-warning"></i>
              </div>
            </div>
            <div>
              <h4 class="mb-0 fw-semibold">{{ $stats['pending_orders'] ?? 0 }}</h4>
              <p class="mb-0 text-muted">Menunggu Diproses</p>
              <small class="text-warning fw-medium">Perlu perhatian</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="me-4">
              <div class="round-48 round bg-danger-subtle d-flex align-items-center justify-content-center">
                <i class="ti ti-alert-triangle fs-7 text-danger"></i>
              </div>
            </div>
            <div>
              <h4 class="mb-0 fw-semibold">{{ $stats['low_stock'] ?? 0 }}</h4>
              <p class="mb-0 text-muted">Stok Menipis</p>
              <small class="text-danger fw-medium">Segera restock</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Row Chart & Quick Actions -->
  <div class="row mt-4">
    <!-- Sales Overview Chart -->
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <h5 class="card-title fw-semibold mb-0">Ringkasan Penjualan</h5>
              <p class="mb-0 text-muted">Performa penjualan tahun ini</p>
            </div>
            <select class="form-select w-auto">
              <option>2025</option>
              <option>2024</option>
            </select>
          </div>
          <div id="sales-overview" class="mt-4" style="height: 350px;"></div>
        </div>
      </div>
    </div>

    <!-- Quick Actions & Welcome -->
    <div class="col-lg-4">
      <!-- Quick Actions -->
      <div class="card mb-4">
        <div class="card-body">
          <h5 class="card-title fw-semibold mb-4">Aksi Cepat</h5>
          <div class="d-grid gap-3">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary py-3">
              <i class="ti ti-plus fs-6 me-2"></i> Tambah Produk Baru
            </a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-info py-3">
              <i class="ti ti-receipt fs-6 me-2"></i> Lihat Pesanan Baru
            </a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary py-3">
              <i class="ti ti-category fs-6 me-2"></i> Kelola Kategori
            </a>
          </div>
        </div>
      </div>

      <!-- Welcome Card -->
      <div class="card bg-primary text-white">
        <div class="card-body text-center py-5">
          <i class="ti ti-user-check fs-1 mb-3"></i>
          <h4>Selamat Datang Kembali!</h4>
          <p class="mb-1">Halo, <strong>{{ auth()->user()->name }}</strong> 👋</p>
          <small>Semoga hari ini produktif mengelola toko Anda.</small>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Orders Table -->
  <div class="row mt-4">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-4">
            <h5 class="card-title fw-semibold mb-0">Pesanan Terbaru</h5>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary btn-sm">
              Lihat Semua Pesanan
            </a>
          </div>
          <div class="table-responsive">
            <table class="table text-nowrap mb-0 align-middle">
              <thead class="text-dark fs-4">
                <tr>
                  <th><h6 class="fw-semibold mb-0">No. Order</h6></th>
                  <th><h6 class="fw-semibold mb-0">Customer</h6></th>
                  <th><h6 class="fw-semibold mb-0">Total</h6></th>
                  <th><h6 class="fw-semibold mb-0">Status</h6></th>
                  <th><h6 class="fw-semibold mb-0">Tanggal</h6></th>
                </tr>
              </thead>
              <tbody>
                @forelse($recentOrders as $order)
                  <tr>
                    <td>
                      <a href="{{ route('admin.orders.show', $order) }}" class="fw-semibold text-primary">
                        #{{ $order->order_number ?? 'ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                      </a>
                    </td>
                    <td>
                      <div class="d-flex align-items-center">
                        <div class="me-3">
                          <div class="round-40 round bg-light d-flex align-items-center justify-content-center">
                            <span class="text-primary fw-bold">{{ Str::upper(Str::limit($order->user->name, 1, '')) }}</span>
                          </div>
                        </div>
                        <div>
                          <h6 class="mb-0 fw-medium">{{ $order->user->name }}</h6>
                          <small class="text-muted">{{ $order->user->email }}</small>
                        </div>
                      </div>
                    </td>
                    <td class="fw-semibold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td>
                      <span class="badge bg-{{ $order->status_color ?? 'secondary' }}-subtle text-{{ $order->status_color ?? 'secondary' }} rounded-pill">
                        {{ ucfirst($order->status) }}
                      </span>
                    </td>
                    <td class="text-muted">{{ $order->created_at->format('d M Y') }}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                      <i class="ti ti-package-off fs-1 mb-3 d-block"></i>
                      Belum ada pesanan
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <!-- ApexCharts for Sales Overview -->
  <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
  <script>
    var options = {
      chart: { height: 350, type: "area", fontFamily: "inherit", foreColor: "#a1aab2" },
      series: [
        { name: "Penjualan Bulan Ini", data: [31, 40, 28, 51, 42, 109, 100] },
        { name: "Bulan Lalu", data: [11, 32, 45, 32, 34, 52, 41] }
      ],
      xaxis: { categories: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul"] },
      colors: ["#0d6efd", "#6c757d"],
      fill: { opacity: [0.1, 0.05] },
      grid: { borderColor: "#e9ecef" },
      tooltip: { theme: "dark" }
    };
    var chart = new ApexCharts(document.querySelector("#sales-overview"), options);
    chart.render();
  </script>
@endpush