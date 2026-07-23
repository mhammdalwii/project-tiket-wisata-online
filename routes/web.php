<?php

use Illuminate\Support\Facades\Route;

// --- Controller Backend (Logika Buatan Anda) ---
use App\Http\Controllers\CetakTiketController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WisataController;
use App\Http\Controllers\TransaksiController;

// --- Controller Sementara Frontend (Buatan Teman Anda) ---
// Kita alias-kan menjadi FrontWisataController agar namanya tidak bentrok dengan WisataController Anda
use App\Http\Controllers\Front\WisataController as FrontWisataController;

/*
|--------------------------------------------------------------------------
| Web Routes (Frontend / Halaman Pengunjung)
|--------------------------------------------------------------------------
*/

// === RUTE PUBLIK (BISA DIAKSES SIAPA SAJA) ===
// Menggunakan Controller Anda, tapi mengadopsi URL teman Anda
Route::get('/', [WisataController::class, 'index'])->name('home');
Route::get('/wisata', [WisataController::class, 'index'])->name('wisata.index');
Route::get('/wisata/{id}', [WisataController::class, 'show'])->name('wisata.show');

// === RUTE GUEST (HANYA BISA DIAKSES JIKA BELUM LOGIN) ===
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

// === RUTE PROTECTED (WAJIB LOGIN) ===
Route::middleware('auth')->group(function () {

    // Proses Logout (Fungsi Anda)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Alur Pemesanan (Menggabungkan URL Frontend dengan Logic Backend Anda)
    // Front menggunakan /pesan/{id?}, kita hubungkan ke TransaksiController
    Route::get('/pesan/{wisata_id}', [TransaksiController::class, 'create'])->name('wisata.pesan');
    Route::post('/pesan/{wisata_id}', [TransaksiController::class, 'store'])->name('checkout.process');

    // Menu User / Riwayat (Menggabungkan URL tiket-saya dengan Logic Anda)
    Route::get('/tiket-saya', [TransaksiController::class, 'index'])->name('wisata.tiket-saya');

    // Cetak E-Tiket PDF (Fungsi Anda)
    Route::get('/cetak-tiket/{id}', [CetakTiketController::class, 'cetak'])->name('cetak.tiket');


    // ==========================================================
    // RUTE KHUSUS TAMPILAN FRONTEND (Belum dibuat logic backend-nya)
    // Tetap menggunakan controller teman Anda agar UI-nya tidak error
    // ==========================================================
    Route::get('/profil', [FrontWisataController::class, 'profil'])->name('wisata.profil');
    Route::put('/profil/update', [FrontWisataController::class, 'updateProfil'])->name('wisata.profil.update');
    Route::get('/pembayaran', [FrontWisataController::class, 'pembayaran'])->name('wisata.pembayaran');
    Route::get('/e-ticket', [FrontWisataController::class, 'eticket'])->name('wisata.eticket');
});
