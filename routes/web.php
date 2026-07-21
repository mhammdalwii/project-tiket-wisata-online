<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CetakTiketController;

Route::get('/', function () {
    return view('pages.test');
});

Route::get('/cetak-tiket/{id}', [CetakTiketController::class, 'cetak'])->name('cetak.tiket');
