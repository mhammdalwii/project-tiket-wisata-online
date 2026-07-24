<?php

namespace App\Http\Controllers;

use App\Models\Wisata;
use Illuminate\Http\Request;

class WisataController extends Controller
{
    // 1. Halaman Beranda (Menampilkan 4 terbaru)
    public function home()
    {
        $wisatas = Wisata::latest()->take(4)->get();
        return view('pages.home', compact('wisatas'));
    }

    // 2. Halaman Katalog dengan Pencarian & Pagination
    public function index(Request $request)
    {
        $query = Wisata::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_wisata', 'like', '%' . $request->search . '%');
        }

        $daftar_wisata = $query->latest()->paginate(8);
        $daftar_wisata->appends($request->all());

        return view('pages.wisata.index', compact('daftar_wisata'));
    }

    // 3. Halaman Detail
    public function show($id)
    {
        $wisata = Wisata::findOrFail($id);
        return view('pages.wisata.detail', compact('wisata'));
    }
}
