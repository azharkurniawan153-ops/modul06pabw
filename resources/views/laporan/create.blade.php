@extends('layouts.app')
@section('title', 'Lapor Banjir')

@section('content')
<div class="card form-card">
    <h2> Form Pelaporan Banjir</h2>
    <p class="muted">Halaman ini terbuka untuk umum, tidak perlu login.</p>

    <form action="{{ route('laporan.store') }}" method="POST" novalidate>
        @csrf
        <div class="grid2">
            <div>
                <label for="nama_pelapor">Nama Pelapor</label>
                <input type="text" id="nama_pelapor" name="nama_pelapor" value="{{ old('nama_pelapor') }}" class="@error('nama_pelapor') is-invalid @enderror">
                @error('nama_pelapor') <small class="err">{{ $message }}</small> @enderror
            </div>
            <div>
                <label for="no_hp">Nomor HP</label>
                <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx" class="@error('no_hp') is-invalid @enderror">
                @error('no_hp') <small class="err">{{ $message }}</small> @enderror
            </div>
        </div>

        <label for="lokasi">Lokasi Banjir</label>
        <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi') }}" placeholder="Jalan, RT/RW, Kelurahan" class="@error('lokasi') is-invalid @enderror">
        @error('lokasi') <small class="err">{{ $message }}</small> @enderror

        <label for="tinggi_air">Tinggi Air (cm)</label>
        <input type="number" id="tinggi_air" name="tinggi_air" value="{{ old('tinggi_air') }}" class="@error('tinggi_air') is-invalid @enderror">
        @error('tinggi_air') <small class="err">{{ $message }}</small> @enderror

        <label for="deskripsi">Deskripsi Kejadian</label>
        <textarea id="deskripsi" name="deskripsi" rows="4" class="@error('deskripsi') is-invalid @enderror">{{ old('deskripsi') }}</textarea>
        @error('deskripsi') <small class="err">{{ $message }}</small> @enderror

        <button type="submit" class="btn btn-primary btn-block">Kirim Laporan</button>
    </form>
</div>
@endsection
