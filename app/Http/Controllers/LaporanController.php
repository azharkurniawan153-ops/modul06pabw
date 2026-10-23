<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // Publik: form pelaporan (tanpa login)
    public function create()
    {
        return view('laporan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_pelapor' => ['required', 'string', 'max:100'],
            'no_hp'        => ['required', 'regex:/^[0-9+\-\s]{8,20}$/'],
            'lokasi'       => ['required', 'string', 'max:255'],
            'tinggi_air'   => ['required', 'integer', 'min:1', 'max:1000'],
            'deskripsi'    => ['required', 'string', 'min:10'],
        ], [
            'nama_pelapor.required' => 'Nama pelapor wajib diisi.',
            'no_hp.required'        => 'Nomor HP wajib diisi.',
            'no_hp.regex'           => 'Nomor HP tidak valid (8-20 digit).',
            'lokasi.required'       => 'Lokasi banjir wajib diisi.',
            'tinggi_air.required'   => 'Tinggi air wajib diisi.',
            'tinggi_air.integer'    => 'Tinggi air harus berupa angka (cm).',
            'tinggi_air.min'        => 'Tinggi air minimal 1 cm.',
            'deskripsi.required'    => 'Deskripsi wajib diisi.',
            'deskripsi.min'         => 'Deskripsi minimal 10 karakter.',
        ]);

        Laporan::create($data);

        return redirect()->route('laporan.create')
            ->with('success', 'Laporan terkirim. Terima kasih, petugas akan segera menindaklanjuti.');
    }

    // Wajib login: daftar & pengelolaan
    public function index()
    {
        $laporans = Laporan::latest()->get();
        $stat = [
            'total'    => $laporans->count(),
            'baru'     => $laporans->where('status', 'baru')->count(),
            'diproses' => $laporans->where('status', 'diproses')->count(),
            'selesai'  => $laporans->where('status', 'selesai')->count(),
        ];

        return view('laporan.index', compact('laporans', 'stat'));
    }

    public function updateStatus(Request $request, Laporan $laporan)
    {
        $request->validate(['status' => ['required', 'in:baru,diproses,selesai']]);
        $laporan->update(['status' => $request->status]);

        return back()->with('success', 'Status laporan diperbarui.');
    }

    public function destroy(Laporan $laporan)
    {
        $laporan->delete();

        return back()->with('success', 'Laporan dihapus.');
    }
}
