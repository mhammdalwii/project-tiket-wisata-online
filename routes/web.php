<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WisataController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\CetakTiketController;

// === RUTE PUBLIK ===
Route::get('/', [WisataController::class, 'home'])->name('home');
Route::get('/wisata', [WisataController::class, 'index'])->name('wisata.index');
Route::get('/wisata/{id}', [WisataController::class, 'show'])->name('wisata.show');

// === RUTE GUEST (BELUM LOGIN) ===
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

// === RUTE WAJIB LOGIN ===
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Alur Pemesanan 2 Tahap
    Route::get('/pesan/{wisata_id}', [TransaksiController::class, 'create'])->name('wisata.pesan');
    Route::post('/pesan/{wisata_id}', [TransaksiController::class, 'storePesan'])->name('wisata.pesan.store');

    Route::get('/pembayaran/{kode_booking}', [TransaksiController::class, 'pembayaran'])->name('wisata.pembayaran');
    Route::post('/pembayaran', [TransaksiController::class, 'storePembayaran'])->name('wisata.pembayaran.store');

    // Riwayat & Tiket
    Route::get('/tiket-saya', [TransaksiController::class, 'index'])->name('wisata.tiket-saya');
    Route::get('/e-ticket/{kode_booking}', [TransaksiController::class, 'eticket'])->name('wisata.eticket');
    Route::get('/cetak-tiket/{id}', [CetakTiketController::class, 'cetak'])->name('cetak.tiket');

    // Kelola Profil
    Route::get('/profil', [AuthController::class, 'profil'])->name('wisata.profil');
    Route::put('/profil/update', [AuthController::class, 'updateProfil'])->name('wisata.profil.update');
});
