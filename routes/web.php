<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\WisataController;

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/wisata', [WisataController::class, 'index'])->name('wisata.index');

// Menambahkan route untuk form pemesanan
Route::get('/pesan/{id?}', [WisataController::class, 'create'])->name('wisata.pesan');
Route::get('/pembayaran', [WisataController::class, 'pembayaran'])->name('wisata.pembayaran');
Route::get('/e-ticket', [WisataController::class, 'eticket'])->name('wisata.eticket');

// Route untuk Auth Wisatawan
Route::get('/login', function () {
    return view('pages.auth.login');
})->name('login');

Route::get('/register', function () {
    // Placeholder untuk halaman registrasi selanjutnya
    return view('pages.auth.register'); 
})->name('register');

// Route untuk halaman "Tiket Saya"
Route::get('/tiket-saya', [WisataController::class, 'tiketSaya'])->name('wisata.tiket-saya');

// Route untuk halaman "Profil"
Route::get('/profil', [WisataController::class, 'profil'])->name('wisata.profil');

// Route Katalog Wisata
Route::get('/wisata', [WisataController::class, 'index'])->name('wisata.index');

// Route Detail Wisata
Route::get('/wisata/{id}', [WisataController::class, 'show'])->name('wisata.show');

// Route Form Pemesanan
Route::get('/pesan/{id?}', [WisataController::class, 'create'])->name('wisata.pesan');