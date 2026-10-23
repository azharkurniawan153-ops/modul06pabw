<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporans';

    protected $fillable = [
        'nama_pelapor', 'no_hp', 'lokasi', 'tinggi_air', 'deskripsi', 'status',
    ];
}
