@extends('layouts.app')
@section('title', 'Daftar Laporan')

@section('content')
<div class="title-row">
    <h2 class="page-title">Daftar Laporan Banjir</h2>
    <a href="{{ route('laporan.create') }}" class="btn btn-light">+ Tambah Laporan</a>
</div>

<div class="stats">
    <div class="stat"><span>{{ $stat['total'] }}</span>Total</div>
    <div class="stat s-baru"><span>{{ $stat['menunggu'] }}</span>Menunggu</div>
    <div class="stat s-proses"><span>{{ $stat['diproses'] }}</span>Diproses</div>
    <div class="stat s-selesai"><span>{{ $stat['selesai'] }}</span>Selesai</div>
</div>

<div class="card table-card">
    <table>
        <thead>
            <tr><th>#</th><th>Foto</th><th>Pelapor</th><th>Lokasi</th><th>Tinggi Air</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
        @forelse ($laporans as $l)
            <tr>
                <td>{{ $laporans->firstItem() + $loop->index }}</td>
                <td>
                    @if ($l->foto_url)
                        <img src="{{ $l->foto_url }}" alt="Foto laporan {{ $l->id }}" class="thumb">
                    @else
                        <span class="thumb thumb-empty">-</span>
                    @endif
                </td>
                <td><strong>{{ $l->nama_pelapor }}</strong><br><small class="muted">{{ $l->no_hp }}</small></td>
                <td>{{ $l->lokasi }}<br><small class="muted">Kec. {{ $l->kecamatan }}</small></td>
                <td>{{ $l->tinggi_air }} cm</td>
                <td><span class="badge b-{{ strtolower($l->status) }}">{{ $l->status }}</span></td>
                <td class="aksi">
                    <a href="{{ route('laporan.show', $l) }}" class="btn-sm">Detail</a>
                    <a href="{{ route('laporan.edit', $l) }}" class="btn-sm">Edit</a>
                    <form action="{{ route('laporan.destroy', $l) }}" method="POST" class="inline" onsubmit="return confirm('Hapus laporan ini beserta fotonya?')">
                        @csrf @method('DELETE')
                        <button class="btn-del" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="empty">Belum ada laporan.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

{{ $laporans->links() }}
@endsection
