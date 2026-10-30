@extends('layouts.app')
@section('title', 'Edit Laporan')

@section('content')
<div class="card form-card">
    <h2>Edit Laporan #{{ $laporan->id }}</h2>
    @include('laporan._form', [
        'action' => route('laporan.update', $laporan), 'method' => 'PUT',
        'laporan' => $laporan, 'submit' => 'Simpan Perubahan', 'withStatus' => true,
    ])
    <p class="switch"><a href="{{ route('laporan.show', $laporan) }}">← Kembali ke detail</a></p>
</div>
@endsection
