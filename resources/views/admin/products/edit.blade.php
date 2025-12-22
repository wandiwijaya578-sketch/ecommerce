@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-12">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 fw-bold text-warning">
                <i class="bi bi-pencil-square me-1"></i> Edit Produk
            </h2>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- INFORMASI --}}
            <div class="card mb-4">
                <div class="card-body">

                    <div class="mb-3">
                        <label>Nama Produk</label>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name', $product->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Kategori</label>
                        <select name="category_id" class="form-select" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Deskripsi Produk</label>
                        <textarea name="description" rows="4" class="form-control">{{ old('description', $product->description) }}</textarea>
                    </div>

                </div>
            </div>

            {{-- HARGA --}}
            <div class="card mb-4">
                <div class="card-body row">
                    <div class="col-md-4">
                        <label>Harga</label>
                        <input type="number" name="price" class="form-control"
                               value="{{ old('price', $product->price) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label>Stok</label>
                        <input type="number" name="stock" class="form-control"
                               value="{{ old('stock', $product->stock) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label>Berat (gram)</label>
                        <input type="number" name="weight" class="form-control"
                               value="{{ old('weight', $product->weight) }}" required>
                    </div>
                </div>
            </div>

            {{-- GAMBAR --}}
            <div class="card mb-4">
                <div class="card-body">
                    <label>Tambah Gambar Baru</label>
                    <input type="file" name="images[]" class="form-control" multiple>
                    <small class="text-muted">Kosongkan jika tidak ingin menambah gambar</small>
                </div>
            </div>

            {{-- STATUS --}}
            <div class="card mb-4">
                <div class="card-body">
                    <input type="hidden" name="is_active" value="0">
                    <input type="hidden" name="is_featured" value="0">

                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1"
                               {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label">Aktif</label>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1"
                               {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                        <label class="form-check-label">Produk Unggulan</label>
                    </div>
                </div>
            </div>

            <button class="btn btn-warning text-white btn-lg">
                <i class="bi bi-save"></i> Update Produk
            </button>

        </form>
    </div>
</div>
@endsection
