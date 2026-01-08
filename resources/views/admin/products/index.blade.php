@extends('layouts.admin')

@section('title', 'Daftar Produk')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 text-gray-800">Daftar Produk</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Produk
    </a>
</div>

{{-- FILTER --}}
<form method="GET" class="row g-2 mb-4">
    <div class="col-md-4">
        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Cari produk..."
            value="{{ request('search') }}"
        >
    </div>

    <div class="col-md-4">
        <select name="category" class="form-select">
            <option value="">Semua Kategori</option>
            @foreach($categories as $category)
                <option
                    value="{{ $category->id }}"
                    {{ request('category') == $category->id ? 'selected' : '' }}
                >
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2">
        <button class="btn btn-outline-secondary w-100">
            <i class="bi bi-funnel"></i> Filter
        </button>
    </div>
</form>

<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th width="80">Gambar</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($products as $product)
                <tr>
                    {{-- GAMBAR (FIX FINAL) --}}
                    <td>
                        <img
                            src="{{ $product->primaryImage
                                ? $product->primaryImage->image_url
                                : asset('img/no-image.png') }}"
                            width="60"
                            height="60"
                            class="rounded border"
                            style="object-fit: cover;"
                        >
                    </td>

                    <td>{{ $product->name }}</td>

                    <td>{{ $product->category->name ?? '-' }}</td>

                    <td>
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </td>

                    <td>{{ $product->stock }}</td>

                    <td>
                        <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                            {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>

                    {{-- AKSI --}}
                    <td>
                        <div class="d-flex gap-1">
                            <a
                                href="{{ route('admin.products.show', $product) }}"
                                class="btn btn-sm btn-info text-white"
                            >
                                <i class="bi bi-eye"></i>
                            </a>

                            <a
                                href="{{ route('admin.products.edit', $product) }}"
                                class="btn btn-sm btn-warning text-white"
                            >
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form
                                action="{{ route('admin.products.destroy', $product) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin hapus produk ini?')"
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        Data produk kosong
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $products->links('pagination::bootstrap-5') }}
</div>

@endsection
