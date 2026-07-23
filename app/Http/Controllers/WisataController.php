<?php

namespace App\Http\Controllers;

use App\Models\Wisata;
use Illuminate\Http\Request;

class WisataController extends Controller
{
    // 1. Menampilkan Katalog Wisata (Halaman Utama)
    public function index()
    {
        // Mengambil seluruh data wisata (nanti bisa diganti dengan paginasi jika sudah banyak)
        $wisata = Wisata::all();

        // Mengirim variabel $wisata ke view Blade yang akan dibuat teman Anda
        return view('wisata.index', compact('wisata'));
    }

    // 2. Menampilkan Halaman Detail Spesifik
    public function show($id)
    {
        // Mencari data berdasarkan ID. Jika ID tidak ditemukan, otomatis menampilkan halaman 404
        $wisata = Wisata::findOrFail($id);

        // Mengirim variabel $wisata yang dipilih ke view detail
        return view('wisata.show', compact('wisata'));
    }
}
