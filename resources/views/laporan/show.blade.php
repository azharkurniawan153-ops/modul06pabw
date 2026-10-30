@extends('layouts.app')
@section('title', 'Detail Laporan')

@section('content')
<div class="card form-card">
    <h2>Detail Laporan #{{ $laporan->id }}
        <span class="badge b-{{ strtolower($laporan->status) }}">{{ $laporan->status }}</span>
    </h2>

    @if ($laporan->foto_url)
        <a href="{{ $laporan->foto_url }}" target="_blank"><img src="{{ $laporan->foto_url }}" alt="Foto bukti" class="foto-detail"></a>
    @else
        <p class="muted">Tidak ada foto bukti.</p>
    @endif

    <dl class="detail">
        <dt>Pelapor</dt><dd>{{ $laporan->nama_pelapor }}</dd>
        <dt>No. HP</dt><dd>{{ $laporan->no_hp }}</dd>
        <dt>Lokasi</dt><dd>{{ $laporan->lokasi }}</dd>
        <dt>Kecamatan</dt><dd>{{ $laporan->kecamatan }}</dd>
        <dt>Tinggi air</dt><dd>{{ $laporan->tinggi_air }} cm</dd>
        <dt>Keterangan</dt><dd>{!! nl2br(e($laporan->keterangan)) !!}</dd>
        <dt>Dilaporkan</dt><dd>{{ $laporan->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }} WIB</dd>
    </dl>

    <div class="actions">
        <a href="{{ route('laporan.index') }}" class="btn btn-ghost">← Daftar</a>
        <a href="{{ route('laporan.edit', $laporan) }}" class="btn btn-primary">Edit</a>
        <form action="{{ route('laporan.destroy', $laporan) }}" method="POST" class="inline" onsubmit="return confirm('Hapus laporan ini beserta fotonya?')">
            @csrf @method('DELETE')
            <button class="btn-del" type="submit">Hapus</button>
        </form>
    </div>
</div>
@endsection
