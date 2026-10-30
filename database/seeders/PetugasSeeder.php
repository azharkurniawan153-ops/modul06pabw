<?php

namespace Database\Seeders;

use App\Models\Laporan;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PetugasSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1 akun admin BPBD (email & password tetap)
        User::updateOrCreate(
            ['email' => 'admin@bpbd.go.id'],
            ['name' => 'Admin BPBD', 'password' => Hash::make('Admin#12345')]
        );

        // 6 akun petugas dummy (password: password123)
        for ($i = 0; $i < 6; $i++) {
            User::create([
                'name'     => $faker->name(),
                'email'    => $faker->unique()->safeEmail(),
                'password' => Hash::make('password123'),
            ]);
        }

        // Contoh laporan banjir dummy (dengan foto placeholder agar thumbnail tampil)
        $kecamatan = ['Sukun', 'Lowokwaru', 'Klojen', 'Blimbing', 'Kedungkandang'];
        Storage::disk('public')->makeDirectory('laporan');

        for ($i = 1; $i <= 12; $i++) {
            $foto = null;
            if (function_exists('imagecreatetruecolor')) {
                $img = imagecreatetruecolor(640, 400);
                imagefill($img, 0, 0, imagecolorallocate($img, 30 + $i * 8, 110 + $i * 5, 190));
                imagestring($img, 5, 20, 20, 'Contoh foto banjir #' . $i, imagecolorallocate($img, 255, 255, 255));
                $foto = 'laporan/dummy-' . $i . '.jpg';
                imagejpeg($img, Storage::disk('public')->path($foto), 85);
                imagedestroy($img);
            }

            Laporan::create([
                'nama_pelapor' => $faker->name(),
                'no_hp'        => '08' . $faker->numerify('##########'),
                'lokasi'       => $faker->streetAddress(),
                'kecamatan'    => $faker->randomElement($kecamatan),
                'tinggi_air'   => $faker->numberBetween(10, 150),
                'keterangan'   => 'Air meluap setelah hujan deras, mohon bantuan evakuasi dan pemantauan.',
                'foto'         => $foto,
                'status'       => $faker->randomElement(Laporan::STATUS),
            ]);
        }
    }
}
