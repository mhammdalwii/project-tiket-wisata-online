<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\WisataController;
use App\Http\Controllers\Front\AuthController;

// === RUTE PUBLIK (BISA DIAKSES SIAPA SAJA) ===
Route::get('/', [WisataController::class, 'home'])->name('home');
Route::get('/wisata', [WisataController::class, 'index'])->name('wisata.index');
Route::get('/wisata/{id}', [WisataController::class, 'show'])->name('wisata.show');

// === RUTE GUEST (HANYA BISA DIAKSES JIKA BELUM LOGIN) ===
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.process');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'store'])->name('register.process');
});

// === RUTE PROTECTED (WAJIB LOGIN) ===
Route::middleware('auth')->group(function () {

    // Halaman Profil User
    Route::put('/profil/update', [WisataController::class, 'updateProfil'])->name('wisata.profil.update');

    // Proses Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Alur Pemesanan (Akan diarahkan ke login jika belum masuk)
    Route::get('/pesan/{id?}', [WisataController::class, 'create'])->name('wisata.pesan');
    Route::get('/pembayaran', [WisataController::class, 'pembayaran'])->name('wisata.pembayaran');
    Route::get('/e-ticket', [WisataController::class, 'eticket'])->name('wisata.eticket');

    // Menu User
    Route::get('/tiket-saya', [WisataController::class, 'tiketSaya'])->name('wisata.tiket-saya');
    Route::get('/profil', [WisataController::class, 'profil'])->name('wisata.profil');
});
