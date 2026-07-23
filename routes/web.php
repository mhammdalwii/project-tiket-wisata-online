<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CetakTiketController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WisataController;
use App\Http\Controllers\TransaksiController; // <-- Controller untuk checkout & riwayat

/*
|--------------------------------------------------------------------------
| Web Routes (Frontend / Halaman Pengunjung)
|--------------------------------------------------------------------------
*/

// 1. Katalog & Detail Wisata
Route::get('/', [WisataController::class, 'index'])->name('home');
Route::get('/wisata/{id}', [WisataController::class, 'show'])->name('wisata.detail');

// 2. Autentikasi Pengunjung (Tamu)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

// 3. Autentikasi Pengunjung (Sudah Login)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// 4. Fitur Transaksi & E-Tiket (Hanya bisa diakses jika sudah login sebagai wisatawan)
Route::middleware('auth')->group(function () {
    // Checkout Form & Proses Pesanan
    Route::get('/checkout/{wisata_id}', [TransaksiController::class, 'create'])->name('checkout.form');
    Route::post('/checkout/{wisata_id}', [TransaksiController::class, 'store'])->name('checkout.process');

    // Dasbor / Riwayat Pesanan Wisatawan
    Route::get('/riwayat-pesanan', [TransaksiController::class, 'index'])->name('riwayat.index');

    // Cetak E-Tiket PDF
    Route::get('/cetak-tiket/{id}', [CetakTiketController::class, 'cetak'])->name('cetak.tiket');
});
