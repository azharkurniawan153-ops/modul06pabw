<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PelaporanController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;

// Halaman awal: tamu -> login, petugas -> daftar laporan
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('laporan.index')
        : redirect()->route('login');
});

// Halaman PUBLIK: form pelaporan warga (tanpa login)
Route::get('/lapor', [PelaporanController::class, 'create'])->name('lapor.create');
Route::post('/lapor', [PelaporanController::class, 'store'])->name('lapor.store');

// Hanya untuk TAMU (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Seluruh halaman pengelolaan: hanya untuk petugas yang SUDAH LOGIN
Route::middleware('auth')->group(function () {
    Route::resource('laporan', LaporanController::class);
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
