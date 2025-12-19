@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Wishlist Saya</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tampilkan daftar wishlist di sini -->
    <p>Kamu belum memiliki item di wishlist.</p>
</div>
@endsection