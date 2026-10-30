{{--
  Form bersama (pelaporan warga, tambah & edit oleh petugas).
  Variabel: $action, $method (POST|PUT), $laporan (opsional), $submit, $withStatus (bool)
--}}
@php
    $edit = isset($laporan);
    $val = fn ($k) => old($k, $edit ? $laporan->{$k} : '');
@endphp

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" novalidate>
    @csrf
    @if ($method !== 'POST') @method($method) @endif

    <div class="grid2">
        <div>
            <label for="nama_pelapor">Nama Pelapor</label>
            <input type="text" id="nama_pelapor" name="nama_pelapor" value="{{ $val('nama_pelapor') }}" class="@error('nama_pelapor') is-invalid @enderror">
            @error('nama_pelapor') <small class="err">{{ $message }}</small> @enderror
        </div>
        <div>
            <label for="no_hp">Nomor HP</label>
            <input type="text" id="no_hp" name="no_hp" value="{{ $val('no_hp') }}" placeholder="08xxxxxxxxxx" class="@error('no_hp') is-invalid @enderror">
            @error('no_hp') <small class="err">{{ $message }}</small> @enderror
        </div>
    </div>

    <div class="grid2">
        <div>
            <label for="lokasi">Lokasi Banjir</label>
            <input type="text" id="lokasi" name="lokasi" value="{{ $val('lokasi') }}" placeholder="Jalan, RT/RW, Kelurahan" class="@error('lokasi') is-invalid @enderror">
            @error('lokasi') <small class="err">{{ $message }}</small> @enderror
        </div>
        <div>
            <label for="kecamatan">Kecamatan</label>
            <input type="text" id="kecamatan" name="kecamatan" value="{{ $val('kecamatan') }}" class="@error('kecamatan') is-invalid @enderror">
            @error('kecamatan') <small class="err">{{ $message }}</small> @enderror
        </div>
    </div>

    <label for="tinggi_air">Tinggi Air (cm)</label>
    <input type="number" id="tinggi_air" name="tinggi_air" min="1" value="{{ $val('tinggi_air') }}" class="@error('tinggi_air') is-invalid @enderror">
    @error('tinggi_air') <small class="err">{{ $message }}</small> @enderror

    <label for="keterangan">Keterangan Kejadian</label>
    <textarea id="keterangan" name="keterangan" rows="4" class="@error('keterangan') is-invalid @enderror">{{ $val('keterangan') }}</textarea>
    @error('keterangan') <small class="err">{{ $message }}</small> @enderror

    <label for="foto">Foto Bukti @if($edit)<span class="muted">(kosongkan jika tidak ingin mengganti)</span>@endif</label>
    @if ($edit && $laporan->foto_url)
        <img src="{{ $laporan->foto_url }}" alt="Foto saat ini" class="foto-preview">
    @endif
    <input type="file" id="foto" name="foto" accept=".jpg,.jpeg,.png,image/jpeg,image/png" class="@error('foto') is-invalid @enderror">
    <small class="muted">Format jpg/jpeg/png, maksimal 2 MB.</small>
    @error('foto') <small class="err">{{ $message }}</small> @enderror

    @if (! empty($withStatus))
        <label for="status">Status Penanganan</label>
        <select id="status" name="status" class="@error('status') is-invalid @enderror">
            @foreach (\App\Models\Laporan::STATUS as $s)
                <option value="{{ $s }}" @selected(old('status', $laporan->status ?? 'Menunggu') === $s)>{{ $s }}</option>
            @endforeach
        </select>
        @error('status') <small class="err">{{ $message }}</small> @enderror
    @endif

    <button type="submit" class="btn btn-primary btn-block">{{ $submit }}</button>
</form>
