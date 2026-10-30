<?php

namespace App\Http\Requests;

use App\Models\Laporan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LaporanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Saat ubah (PUT/PATCH) foto boleh dikosongkan = pakai foto lama.
        $foto = $this->isMethod('POST')
            ? ['required', 'file', 'image', 'mimes:jpg,jpeg,png', 'max:2048']
            : ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png', 'max:2048'];

        $rules = [
            'nama_pelapor' => ['required', 'string', 'max:100'],
            'no_hp'        => ['required', 'regex:/^[0-9+\-\s]{8,20}$/'],
            'lokasi'       => ['required', 'string', 'max:255'],
            'kecamatan'    => ['required', 'string', 'max:100'],
            'tinggi_air'   => ['required', 'integer', 'min:1', 'max:1000'],
            'keterangan'   => ['required', 'string', 'min:10'],
            'foto'         => $foto,
        ];

        // Status hanya diubah petugas lewat form edit.
        if (! $this->isMethod('POST')) {
            $rules['status'] = ['required', Rule::in(Laporan::STATUS)];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'nama_pelapor.required' => 'Nama pelapor wajib diisi.',
            'nama_pelapor.max'      => 'Nama pelapor maksimal 100 karakter.',
            'no_hp.required'        => 'Nomor HP wajib diisi.',
            'no_hp.regex'           => 'Nomor HP tidak valid (8-20 digit angka).',
            'lokasi.required'       => 'Lokasi banjir wajib diisi.',
            'kecamatan.required'    => 'Kecamatan wajib diisi.',
            'tinggi_air.required'   => 'Tinggi air wajib diisi.',
            'tinggi_air.integer'    => 'Tinggi air harus berupa angka bulat (cm).',
            'tinggi_air.min'        => 'Tinggi air minimal 1 cm.',
            'tinggi_air.max'        => 'Tinggi air maksimal 1000 cm.',
            'keterangan.required'   => 'Keterangan wajib diisi.',
            'keterangan.min'        => 'Keterangan minimal 10 karakter.',
            'foto.required'         => 'Foto bukti wajib diunggah.',
            'foto.uploaded'         => 'Foto gagal diunggah (ukuran melebihi batas server, maks. 2 MB).',
            'foto.file'             => 'Foto harus berupa berkas yang valid.',
            'foto.image'            => 'Foto harus berupa gambar.',
            'foto.mimes'            => 'Foto harus berformat jpg, jpeg, atau png.',
            'foto.max'              => 'Ukuran foto maksimal 2 MB.',
            'status.required'       => 'Status penanganan wajib dipilih.',
            'status.in'             => 'Status harus Menunggu, Diproses, atau Selesai.',
        ];
    }
}
