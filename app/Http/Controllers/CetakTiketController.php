<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CetakTiketController extends Controller
{
    public function cetak($id)
    {
        // Panggil data transaksi beserta relasi user dan wisata
        $transaksi = Transaksi::with(['user', 'wisata'])->findOrFail($id);

        // Keamanan: Pastikan hanya tiket lunas yang bisa dicetak
        if ($transaksi->status_pembayaran !== 'lunas') {
            abort(403, 'E-Ticket belum dapat dicetak karena pembayaran belum lunas.');
        }

        // Load view blade untuk PDF
        $pdf = Pdf::loadView('pdf.tiket', compact('transaksi'));

        // Unduh PDF dengan nama file dinamis
        return $pdf->download('E-Ticket-' . $transaksi->kode_booking . '.pdf');

        // Catatan: Jika ingin tiket terbuka di tab browser (tidak langsung download), 
        // ganti ->download(...) menjadi ->stream(...)
    }
}
