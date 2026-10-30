@extends('layouts.app')
@section('title', 'Tambah Laporan')

@section('content')
<div class="card form-card">
    <h2>Tambah Laporan</h2>
    @include('laporan._form', ['action' => route('laporan.store'), 'method' => 'POST', 'submit' => 'Simpan Laporan'])
    <p class="switch"><a href="{{ route('laporan.index') }}">← Kembali ke daftar</a></p>
</div>
@endsection
