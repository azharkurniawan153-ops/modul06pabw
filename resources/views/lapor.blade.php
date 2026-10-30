@extends('layouts.app')
@section('title', 'Lapor Banjir')

@section('content')
<div class="card form-card">
    <h2>Form Pelaporan Banjir</h2>
    <p class="muted">Halaman ini terbuka untuk umum, tidak perlu login.</p>
    @include('laporan._form', ['action' => route('lapor.store'), 'method' => 'POST', 'submit' => 'Kirim Laporan'])
</div>
@endsection
