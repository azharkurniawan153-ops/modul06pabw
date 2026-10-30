<?php

namespace Tests\Feature;

use App\Models\Laporan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LaporanTest extends TestCase
{
    use RefreshDatabase;

    private function data(array $o = []): array
    {
        return array_merge([
            'nama_pelapor' => 'Budi', 'no_hp' => '081234567890', 'lokasi' => 'Jl. Mawar 1',
            'kecamatan' => 'Sukun', 'tinggi_air' => 40, 'keterangan' => 'Air masuk rumah warga.',
            'foto' => UploadedFile::fake()->image('a.jpg'),
        ], $o);
    }

    public function test_warga_bisa_lapor_dengan_foto(): void
    {
        Storage::fake('public');
        $this->post('/lapor', $this->data())->assertRedirect('/lapor')->assertSessionHas('success');
        $l = Laporan::first();
        $this->assertSame('Menunggu', $l->status);
        Storage::disk('public')->assertExists($l->foto);
    }

    public function test_validasi_foto(): void
    {
        Storage::fake('public');
        $this->post('/lapor', $this->data(['foto' => UploadedFile::fake()->create('a.pdf', 10, 'application/pdf')]))->assertSessionHasErrors('foto');
        $this->post('/lapor', $this->data(['foto' => UploadedFile::fake()->image('a.gif')]))->assertSessionHasErrors('foto');
        $this->post('/lapor', $this->data(['foto' => UploadedFile::fake()->image('a.jpg')->size(2049)]))->assertSessionHasErrors('foto');
        $this->post('/lapor', $this->data(['foto' => UploadedFile::fake()->image('a.png')->size(2048)]))->assertSessionHasNoErrors();
        $this->post('/lapor', $this->data(['foto' => null]))->assertSessionHasErrors('foto');
    }

    public function test_halaman_kelola_wajib_login(): void
    {
        $this->get('/laporan')->assertRedirect('/login');
        $this->get('/laporan/1/edit')->assertRedirect('/login');
        $this->delete('/laporan/1')->assertRedirect('/login');
    }

    public function test_ganti_foto_menghapus_foto_lama_dan_ubah_status(): void
    {
        Storage::fake('public');
        $this->post('/lapor', $this->data());
        $l = Laporan::first();
        $lama = $l->foto;

        $this->actingAs(User::factory()->create())
            ->put("/laporan/{$l->id}", $this->data(['status' => 'Diproses', 'foto' => UploadedFile::fake()->image('b.png')]))
            ->assertRedirect()->assertSessionHas('success');

        $l->refresh();
        $this->assertSame('Diproses', $l->status);
        $this->assertNotSame($lama, $l->foto);
        Storage::disk('public')->assertMissing($lama);
        Storage::disk('public')->assertExists($l->foto);
    }

    public function test_update_tanpa_foto_mempertahankan_foto_lama(): void
    {
        Storage::fake('public');
        $this->post('/lapor', $this->data());
        $l = Laporan::first();

        $this->actingAs(User::factory()->create())
            ->put("/laporan/{$l->id}", $this->data(['status' => 'Selesai', 'foto' => null]))->assertSessionHasNoErrors();

        $this->assertSame($l->foto, $l->fresh()->foto);
        Storage::disk('public')->assertExists($l->foto);
    }

    public function test_hapus_laporan_menghapus_foto(): void
    {
        Storage::fake('public');
        $this->post('/lapor', $this->data());
        $l = Laporan::first();

        $this->actingAs(User::factory()->create())->delete("/laporan/{$l->id}")->assertRedirect('/laporan')->assertSessionHas('success');
        $this->assertModelMissing($l);
        Storage::disk('public')->assertMissing($l->foto);
    }

    public function test_index_show_edit_dan_pagination(): void
    {
        Storage::fake('public');
        for ($i = 0; $i < 12; $i++) { $this->post('/lapor', $this->data()); }
        $u = User::factory()->create();
        $this->actingAs($u)->get('/laporan')->assertOk()->assertSee('class="thumb"', false)->assertSee('page=2', false);
        $this->actingAs($u)->get('/laporan?page=2')->assertOk();
        $id = Laporan::first()->id;
        $this->actingAs($u)->get("/laporan/$id")->assertOk()->assertSee('Budi');
        $this->actingAs($u)->get("/laporan/$id/edit")->assertOk()->assertSee('Diproses');
    }

    public function test_pesan_galat_di_bawah_input(): void
    {
        $this->from('/lapor')->post('/lapor', [])->assertSessionHasErrors(['nama_pelapor', 'kecamatan', 'foto', 'keterangan']);
        $this->get('/lapor')->assertOk();
    }
}
