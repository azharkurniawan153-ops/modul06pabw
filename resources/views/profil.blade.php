@extends('layouts.app')
@section('title', 'Profil Petugas')

@section('content')
<div class="card profile-card">
    <div class="avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
    <h2>{{ $user->name }}</h2>
    <p class="muted">Petugas SiagaBanjir</p>

    <dl>
        <dt>Nama</dt><dd>{{ $user->name }}</dd>
        <dt>Email</dt><dd>{{ $user->email }}</dd>
        <dt>Akun dibuat</dt><dd>{{ $user->created_at->timezone('Asia/Jakarta')->locale('id')->translatedFormat('l, d F Y \p\u\k\u\l H:i') }} WIB</dd>
    </dl>
</div>
@endsection
