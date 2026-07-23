<?php

namespace App\Http\Controllers;

use App\Models\Wisata;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransaksiController extends Controller
{
    // 1. Menampilkan Form Checkout
    public function create($wisata_id)
    {
        // Pastikan wisata yang akan dipesan itu ada
        $wisata = Wisata::findOrFail($wisata_id);

        // Tampilkan view form checkout ke wisatawan
        return view('transaksi.checkout', compact('wisata'));
    }

    // 2. Memproses Data Checkout & Bukti Transfer
    public function store(Request $request, $wisata_id)
    {
        // Validasi input dari wisatawan
        $request->validate([
            'tanggal_kunjungan' => ['required', 'date', 'after_or_equal:today'],
            'jumlah_tiket'      => ['required', 'integer', 'min:1'],
            'bukti_transfer'    => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // Maksimal 2MB
        ]);

        $wisata = Wisata::findOrFail($wisata_id);

        // Hitung total harga otomatis (Jumlah Tiket x Harga Satuan)
        $total_harga = $wisata->harga_tiket * $request->jumlah_tiket;

        // Simpan foto bukti transfer ke folder public/storage/bukti_transfer
        $pathBukti = $request->file('bukti_transfer')->store('bukti_transfer', 'public');

        // Buat kode booking unik (Contoh: TRX-A1B2C3D4)
        $kode_booking = 'TRX-' . strtoupper(Str::random(8));

        // Simpan data transaksi ke database
        Transaksi::create([
            'user_id'           => Auth::id(),
            'wisata_id'         => $wisata->id,
            'kode_booking'      => $kode_booking,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'jumlah_tiket'      => $request->jumlah_tiket,
            'total_harga'       => $total_harga,
            'bukti_transfer'    => $pathBukti,
            'status'            => 'menunggu_validasi', // Status default
        ]);

        // Arahkan wisatawan ke halaman riwayat pesanan dengan pesan sukses
        return redirect()->route('riwayat.index')->with('success', 'Pemesanan berhasil! Silakan tunggu validasi dari Admin.');
    }

    // 3. Menampilkan Dasbor Wisatawan (Riwayat Pesanan)
    public function index()
    {
        // Mengambil transaksi HANYA milik user yang sedang login
        // with('wisata') digunakan agar kita bisa memunculkan nama wisata di halaman riwayat
        $transaksis = Transaksi::with('wisata')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('transaksi.riwayat', compact('transaksis'));
    }
}
