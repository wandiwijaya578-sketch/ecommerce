@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container max-w-7xl mx-auto px-4 py-8">
    <h1 class="h2 mb-5 fw-bold">Profil Saya</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- Sidebar Menu --}}
        <div class="col-md-3">
            <div class="list-group shadow-sm">
                <a href="{{ route('profile.index') }}" class="list-group-item list-group-item-action active">
                    <i class="bi bi-person-circle me-2"></i> Profil Saya
                </a>
                <a href="{{ route('orders.index') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-bag me-2"></i> Pesanan Saya
                </a>
                <a href="{{ route('wishlist.index') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-heart me-2"></i> Wishlist
                </a>
                <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-gear me-2"></i> Pengaturan Akun
                </a>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="col-md-9">
            <div class="row g-4">
                {{-- Avatar --}}
                <div class="col-md-4">
                    <div class="card shadow-sm text-center border-0">
                        <div class="card-body">
                            <div class="position-relative mb-3">
                                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=ddd&color=555' }}"
                                     class="rounded-circle img-fluid border border-3 border-light shadow-sm"
                                     style="width: 150px; height: 150px; object-fit: cover;" alt="Avatar">
                            </div>
                            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                            <p class="text-muted mb-3">{{ $user->email }}</p>

                            <div class="d-grid gap-2">
                                @if($user->avatar)
                                <form action="{{ route('profile.deleteAvatar') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        Hapus Foto
                                    </button>
                                </form>
                                @endif
                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updateAvatarModal">
                                    Ubah Foto
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Info Profil --}}
                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Informasi Profil</h5>

                            <div class="row mb-3">
                                <div class="col-sm-4 fw-bold text-muted">Nama</div>
                                <div class="col-sm-8">{{ $user->name }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 fw-bold text-muted">Email</div>
                                <div class="col-sm-8">{{ $user->email }}</div>
                            </div>

                            <div class="d-flex flex-wrap gap-2 mt-3">
                                <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm flex-grow-1">
                                    Edit Profil
                                </a>
                                <button class="btn btn-warning btn-sm flex-grow-1" data-bs-toggle="modal" data-bs-target="#updatePasswordModal">
                                    Ganti Password
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bisa tambah ringkasan pesanan terakhir / stats --}}
            <div class="mt-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Ringkasan Pesanan</h5>
                        <p class="text-muted">Anda memiliki {{ $user->orders->count() ?? 0 }} pesanan aktif.</p>
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua Pesanan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Update Avatar --}}
<div class="modal fade" id="updateAvatarModal" tabindex="-1" aria-labelledby="updateAvatarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('profile.updateAvatar') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="updateAvatarModalLabel">Ubah Foto Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="file" name="avatar" class="form-control" accept="image/*" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Update Password --}}
<div class="modal fade" id="updatePasswordModal" tabindex="-1" aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('profile.updatePassword') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="updatePasswordModalLabel">Ganti Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="current_password" class="form-label">Password Saat Ini</label>
                    <input type="password" name="current_password" id="current_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-warning">Simpan Password</button>
            </div>
        </form>
    </div>
</div>

@endsection
