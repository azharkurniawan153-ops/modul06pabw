# SiagaBanjir - Website Laporan Banjir (Laravel, Auth Manual)

Zip ini berisi file aplikasi (overlay) untuk dimasukkan ke proyek Laravel 11/12 baru.

## Cara pasang
1. Buat proyek baru:
   composer create-project laravel/laravel laporan-banjir
2. Salin SEMUA isi folder zip ini ke dalam folder `laporan-banjir` (timpa file bila diminta:
   routes/web.php dan database/seeders/DatabaseSeeder.php).
3. Buat database `laporan_banjir` di phpMyAdmin, lalu atur `.env`:
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laporan_banjir
   DB_USERNAME=root
   DB_PASSWORD=
   APP_TIMEZONE=Asia/Jakarta   (opsional, di config/app.php: 'timezone')
4. Jalankan:
   php artisan migrate
   php artisan db:seed
   php artisan serve
5. Buka http://127.0.0.1:8000

## Akun hasil seeder
- Admin BPBD : admin@bpbd.go.id / Admin#12345
- 6 petugas dummy (email acak, lihat tabel users) : password123

## Bukti proteksi halaman
- Tanpa login buka http://127.0.0.1:8000/laporan -> otomatis diarahkan ke /login.
- Via terminal: curl -I http://127.0.0.1:8000/laporan  -> "302 Found", Location: .../login
- Form pelaporan http://127.0.0.1:8000/lapor tetap bisa dibuka tanpa login.

## Bukti hash password (phpMyAdmin)
Buka database laporan_banjir > tabel users > Browse. Kolom password berawalan `$2y$12$...` (bcrypt).

## Alasan memilih autentikasi manual (untuk laporan)
Dipilih cara manual karena (1) alur register/login/logout terlihat jelas sehingga memahami
Hash::make(), Auth::attempt(), Auth::logout(); (2) kebutuhan sistem sederhana (tanpa reset password/verifikasi email)
sehingga Breeze menambah banyak file yang tidak dipakai; (3) tampilan bisa dikustomisasi penuh tanpa terikat Tailwind.
