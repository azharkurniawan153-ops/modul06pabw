<?php

namespace App\Http\Controllers;

use App\Http\Requests\LaporanRequest;
use App\Models\Laporan;

/** Form pelaporan PUBLIK untuk warga (tanpa login). */
class PelaporanController extends Controller
{
    public function create()
    {
        return view('lapor');
    }

    public function store(LaporanRequest $request)
    {
        $data = $request->validated();
        $data['foto'] = $request->file('foto')->store('laporan', 'public');
        $data['status'] = 'Menunggu';

        Laporan::create($data);

        return redirect()->route('lapor.create')
            ->with('success', 'Laporan berhasil dikirim. Terima kasih, petugas akan segera menindaklanjuti.');
    }
}
