<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelapor', 100);
            $table->string('no_hp', 20);
            $table->string('lokasi');
            $table->string('kecamatan', 100);
            $table->unsignedInteger('tinggi_air');      // dalam cm
            $table->text('keterangan');
            $table->string('foto')->nullable();          // path relatif di disk "public"
            $table->string('status', 20)->default('Menunggu'); // Menunggu | Diproses | Selesai
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
