<?php

namespace App\Http\Controllers;

use App\Http\Requests\LaporanRequest;
use App\Models\Laporan;

/** Resource controller pengelolaan laporan oleh petugas (di dalam middleware auth). */
class LaporanController extends Controller
{
    public function index()
    {
        $laporans = Laporan::latest()->paginate(10);

        $stat = [
            'total'    => Laporan::count(),
            'menunggu' => Laporan::where('status', 'Menunggu')->count(),
            'diproses' => Laporan::where('status', 'Diproses')->count(),
            'selesai'  => Laporan::where('status', 'Selesai')->count(),
        ];

        return view('laporan.index', compact('laporans', 'stat'));
    }

    public function create()
    {
        return view('laporan.create');
    }

    public function store(LaporanRequest $request)
    {
        $data = $request->validated();
        $data['foto'] = $request->file('foto')->store('laporan', 'public');
        $data['status'] = 'Menunggu';

        Laporan::create($data);

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil ditambahkan.');
    }

    public function show(Laporan $laporan)
    {
        return view('laporan.show', compact('laporan'));
    }

    public function edit(Laporan $laporan)
    {
        return view('laporan.edit', compact('laporan'));
    }

    public function update(LaporanRequest $request, Laporan $laporan)
    {
        $data = $request->validated();
        unset($data['foto']);

        if ($request->hasFile('foto')) {
            // Simpan foto baru dulu, baru hapus foto lama agar tidak kehilangan data bila gagal.
            $fotoBaru = $request->file('foto')->store('laporan', 'public');
            $laporan->hapusFoto();
            $data['foto'] = $fotoBaru;
        }

        $laporan->update($data);

        return redirect()->route('laporan.show', $laporan)->with('success', 'Laporan berhasil diubah.');
    }

    public function destroy(Laporan $laporan)
    {
        $laporan->delete(); // foto ikut terhapus lewat event deleting pada model

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }
}
