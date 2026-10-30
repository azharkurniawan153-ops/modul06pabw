# LaporBanjir – Sistem Pelaporan Banjir (Laravel, autentikasi manual)

Warga melapor banjir lewat form publik (dengan foto bukti); petugas yang sudah login mengelola laporan (lihat, ubah, ganti foto, ubah status, hapus).

## Cara menjalankan
1. Buat database **`db_laporbanjir`** di phpMyAdmin (collation `utf8mb4_unicode_ci`).
2. `.env` sudah terisi:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_laporbanjir
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   (Jika dari awal, salin `.env.example` ke `.env`, lalu `php artisan key:generate`.)
3. Jalankan:
   ```
   composer install            # bila folder vendor tidak ikut / PHP berbeda
   php artisan migrate:fresh --seed
   php artisan storage:link    # WAJIB agar foto tampil (public/storage -> storage/app/public)
   php artisan serve
   ```
4. Buka http://127.0.0.1:8000

> Memakai `migrate:fresh` karena struktur tabel `laporans` berubah (kolom `kecamatan`, `keterangan`, `foto`, status `Menunggu/Diproses/Selesai`).
> Batas upload PHP (`upload_max_filesize` & `post_max_size` di php.ini) harus ≥ 2 MB; XAMPP default 2 MB.

## Akun hasil seeder
- Admin BPBD : `admin@bpbd.go.id` / `Admin#12345`
- 6 petugas dummy (email acak, lihat tabel `users`) : `password123`
- 12 laporan contoh + foto placeholder.

## Pemetaan ke soal
| Poin | Implementasi |
|---|---|
| a | Project `laporbanjir`, DB `db_laporbanjir`, koneksi di `.env` |
| b | `app/Models/Laporan.php` + `database/migrations/2026_10_23_000000_create_laporans_table.php` (nama_pelapor, no_hp, lokasi, kecamatan, tinggi_air, keterangan, foto, status default `Menunggu`) |
| c | Form publik `/lapor` (`PelaporanController`), `enctype="multipart/form-data"`, validasi `image|mimes:jpg,jpeg,png|max:2048` di `LaporanRequest`, disimpan `->store('laporan','public')`, `php artisan storage:link` |
| d | `Route::resource('laporan', LaporanController::class)` di dalam `Route::middleware('auth')`: index (thumbnail + `paginate(10)`), show, edit/update (ganti foto + status), destroy; create/store juga tersedia untuk petugas |
| e | `update()`: foto baru disimpan lalu foto lama dihapus (`Storage::disk('public')->delete`). Hapus laporan: event `deleting` pada model menghapus file foto |
| f | Flash `success` untuk tambah/ubah/hapus (`layouts/app.blade.php`); galat validasi `@error` tepat di bawah tiap input; pesan berbahasa Indonesia |
| g | Lihat di bawah |

## Bukti proteksi halaman
- Tanpa login, buka `/laporan` → diarahkan ke `/login` (`curl -I http://127.0.0.1:8000/laporan` → `302`).
- Form pelaporan `/lapor` tetap bisa dibuka tanpa login.

## Alasan memilih autentikasi manual (bukan Breeze)
1. **Kebutuhan sederhana.** Sistem hanya butuh register, login, logout, dan proteksi halaman. Breeze menambah banyak file yang tidak dipakai (reset password, verifikasi email, edit profil, komponen Tailwind/Vite, Node.js).
2. **Alur lebih terlihat dan mudah dijelaskan.** Dengan cara manual, `Hash::make()`, `Auth::attempt()`, `Auth::logout()`, regenerasi sesi, dan middleware `auth`/`guest` tertulis jelas di `LoginController` dan `RegisterController`, sehingga mudah dipahami dan dipertanggungjawabkan.
3. **Tampilan konsisten.** Seluruh halaman memakai satu tema CSS sendiri; tidak perlu membangun ulang Tailwind/Node hanya untuk login.
4. **Fokus tugas.** Inti tugas adalah upload foto, CRUD, dan pengelolaan file; kode otentikasi yang ringkas membuat bagian itu lebih mudah dibaca.
Konsekuensinya fitur seperti reset password harus dibuat sendiri bila kelak diperlukan.

## Pengujian
`php artisan test` menjalankan `tests/Feature/LaporanTest.php` (validasi foto, ganti foto menghapus foto lama, hapus laporan menghapus foto, proteksi login, pagination). Butuh PHP 8.4 sesuai dependensi di `vendor`.
