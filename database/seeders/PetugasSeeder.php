<?php

namespace Database\Seeders;

use App\Models\Laporan;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        // Contoh laporan banjir dummy
        for ($i = 0; $i < 8; $i++) {
            Laporan::create([
                'nama_pelapor' => $faker->name(),
                'no_hp'        => $faker->phoneNumber(),
                'lokasi'       => $faker->streetAddress() . ', ' . $faker->city(),
                'tinggi_air'   => $faker->numberBetween(10, 150),
                'deskripsi'    => 'Air meluap setelah hujan deras, mohon bantuan evakuasi dan pemantauan.',
                'status'       => $faker->randomElement(['baru', 'diproses', 'selesai']),
            ]);
        }
    }
}
