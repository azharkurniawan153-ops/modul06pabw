<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Laporan extends Model
{
    public const STATUS = ['Menunggu', 'Diproses', 'Selesai'];

    protected $table = 'laporans';

    protected $fillable = [
        'nama_pelapor', 'no_hp', 'lokasi', 'kecamatan',
        'tinggi_air', 'keterangan', 'foto', 'status',
    ];

    protected $attributes = [
        'status' => 'Menunggu',
    ];

    /** URL foto (null jika tidak ada). Memakai asset() agar ikut host yang sedang dipakai. */
    protected function fotoUrl(): Attribute
    {
        return Attribute::get(fn () => $this->foto ? asset('storage/' . $this->foto) : null);
    }

    /** Hapus file foto dari storage (aman dipanggil bila foto kosong / file tidak ada). */
    public function hapusFoto(): void
    {
        if ($this->foto) {
            Storage::disk('public')->delete($this->foto);
        }
    }

    protected static function booted(): void
    {
        // Foto ikut terhapus saat laporan dihapus.
        static::deleting(fn (Laporan $laporan) => $laporan->hapusFoto());
    }
}
