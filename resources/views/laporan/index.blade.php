@extends('layouts.app')
@section('title', 'Daftar Laporan')

@section('content')
<h2 class="page-title">Daftar Laporan Banjir</h2>

<div class="stats">
    <div class="stat"><span>{{ $stat['total'] }}</span>Total</div>
    <div class="stat s-baru"><span>{{ $stat['baru'] }}</span>Baru</div>
    <div class="stat s-proses"><span>{{ $stat['diproses'] }}</span>Diproses</div>
    <div class="stat s-selesai"><span>{{ $stat['selesai'] }}</span>Selesai</div>
</div>

<div class="card table-card">
    <table>
        <thead>
            <tr><th>#</th><th>Pelapor</th><th>Lokasi</th><th>Tinggi Air</th><th>Deskripsi</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
        @forelse ($laporans as $i => $l)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td><strong>{{ $l->nama_pelapor }}</strong><br><small class="muted">{{ $l->no_hp }}</small></td>
                <td>{{ $l->lokasi }}</td>
                <td>{{ $l->tinggi_air }} cm</td>
                <td class="desc">{{ $l->deskripsi }}</td>
                <td>
                    <form action="{{ route('laporan.status', $l) }}" method="POST" class="inline">
                        @csrf @method('PATCH')
                        <select name="status" onchange="this.form.submit()" class="badge b-{{ $l->status }}">
                            @foreach (['baru', 'diproses', 'selesai'] as $s)
                                <option value="{{ $s }}" @selected($l->status === $s)>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </form>
                </td>
                <td>
                    <form action="{{ route('laporan.destroy', $l) }}" method="POST" class="inline" onsubmit="return confirm('Hapus laporan ini?')">
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
@endsection
