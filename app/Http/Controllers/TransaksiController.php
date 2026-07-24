<?php

namespace App\Http\Controllers;

use App\Models\Wisata;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransaksiController extends Controller
{
    // 1. Tampilkan form pilih jumlah tiket
    public function create($wisata_id)
    {
        $wisata = Wisata::findOrFail($wisata_id);
        return view('pages.wisata.pesan', compact('wisata'));
    }

    // 2. Simpan pesanan & arahkan ke halaman pembayaran
    public function storePesan(Request $request, $wisata_id)
    {
        $request->validate([
            'tanggal_kunjungan' => ['required', 'date'],
            'jumlah_tiket'      => ['required', 'integer', 'min:1'],
        ]);

        $wisata = Wisata::findOrFail($wisata_id);
        $kode_booking = 'BK' . strtoupper(Str::random(6));

        Transaksi::create([
            'user_id'           => Auth::id(),
            'wisata_id'         => $wisata->id,
            'kode_booking'      => $kode_booking,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'jumlah_tiket'      => $request->jumlah_tiket,
            'total_harga'       => $request->jumlah_tiket * $wisata->harga_tiket,
            'status'            => 'menunggu_pembayaran', // Status awal
        ]);

        return redirect()->route('wisata.pembayaran', $kode_booking);
    }

    // 3. Tampilkan halaman upload bukti transfer
    public function pembayaran($kode_booking)
    {
        $pesanan = Transaksi::where('kode_booking', $kode_booking)->firstOrFail();
        return view('pages.wisata.pembayaran', compact('pesanan'));
    }

    // 4. Simpan foto bukti transfer
    public function storePembayaran(Request $request)
    {
        $pesanan = Transaksi::where('kode_booking', $request->kode_booking)->firstOrFail();

        if ($request->hasFile('bukti_transfer')) {
            $pathBukti = $request->file('bukti_transfer')->store('bukti_transfer', 'public');

            $pesanan->update([
                'bukti_transfer' => $pathBukti,
                'status'         => 'menunggu_validasi' // Berubah status
            ]);
        }

        return redirect()->route('wisata.tiket-saya')->with('success', 'Pembayaran berhasil dikirim!');
    }

    // 5. Tampilkan Riwayat
    public function index()
    {
        $riwayat_tiket = Transaksi::with('wisata')->where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('pages.wisata.tiket-saya', compact('riwayat_tiket'));
    }

    // 6. Tampilkan E-Ticket HTML (Jika Lunas)
    public function eticket($kode_booking)
    {
        $tiket = Transaksi::with(['wisata', 'user'])->where('kode_booking', $kode_booking)->firstOrFail();
        return view('pages.wisata.eticket', compact('tiket'));
    }
}
