@extends('layouts.app')
@section('title', 'Register')

@section('content')
<div class="auth-wrap">
    <div class="auth-hero">
        <h1>Gabung<br>Jadi Petugas </h1>
        <p>Buat akun untuk memantau, menindaklanjuti, dan menyelesaikan laporan banjir di wilayah Anda.</p>
        <a href="{{ route('laporan.create') }}" class="btn btn-light">Lapor tanpa login →</a>
    </div>

    <div class="card auth-card">
        <h2>Daftar Akun</h2>
        <p class="muted">Isi data berikut untuk membuat akun petugas.</p>

        <form action="{{ route('register') }}" method="POST" novalidate>
            @csrf
            <label for="name">Nama Lengkap</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Nama lengkap" class="@error('name') is-invalid @enderror" required autofocus>
            @error('name') <small class="err">{{ $message }}</small> @enderror

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" class="@error('email') is-invalid @enderror" required>
            @error('email') <small class="err">{{ $message }}</small> @enderror

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" class="@error('password') is-invalid @enderror" required>
            @error('password') <small class="err">{{ $message }}</small> @enderror

            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>

            <button type="submit" class="btn btn-primary btn-block">Daftar</button>
        </form>

        <p class="switch">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
    </div>
</div>
@endsection
