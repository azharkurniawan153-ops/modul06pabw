@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="auth-wrap">
    <div class="auth-hero">
        <h1>Lapor<br>Banjir</h1>
        <p>Platform pelaporan banjir cepat dan transparan. Masyarakat melapor, petugas bergerak.</p>
        <a href="{{ route('laporan.create') }}" class="btn btn-light">Lapor tanpa login →</a>
    </div>

    <div class="card auth-card">
        <h2>Login Petugas</h2>
        <p class="muted">Masuk untuk mengelola laporan banjir.</p>

        <form action="{{ route('login') }}" method="POST" novalidate>
            @csrf
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="petugas@bpbd.go.id" class="@error('email') is-invalid @enderror" required autofocus>
            @error('email') <small class="err">{{ $message }}</small> @enderror

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="••••••••" class="@error('password') is-invalid @enderror" required>
            @error('password') <small class="err">{{ $message }}</small> @enderror

            <label class="check"><input type="checkbox" name="remember"> Ingat saya</label>

            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
        </form>

        <p class="switch">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
    </div>
</div>
@endsection
