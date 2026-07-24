<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use App\Models\Wisata;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends BaseWidget
{
    // Tambahkan fungsi ini agar layoutnya menjadi 4 kolom sejajar (menyamping)
    protected function getColumns(): int
    {
        return 4;
    }

    protected function getStats(): array
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        // 1. Siapkan query dasar
        $queryTransaksi = Transaksi::query();
        $queryWisata = Wisata::query();

        // 2. Filter data jika yang login adalah Pengelola (bukan admin)
        if ($user && ! $user->hasRole('admin')) {
            $queryTransaksi->whereHas('wisata', function ($query) use ($user) {
                $query->where('pengelola_id', $user->id);
            });

            $queryWisata->where('pengelola_id', $user->id);
        }

        // 3. Eksekusi perhitungan angka
        // (BARU) Menghitung jumlah pengunjung dari tiket yang lunas
        $totalPengunjung = $queryTransaksi->clone()->where('status_pembayaran', 'lunas')->sum('jumlah_tiket');

        $totalPendapatan = $queryTransaksi->clone()->where('status_pembayaran', 'lunas')->sum('total_harga');
        $jumlahTransaksi = $queryTransaksi->clone()->where('status_pembayaran', 'lunas')->count();
        $jumlahWisata = $queryWisata->count();

        // 4. Tampilkan ke dalam bentuk kotak/widget
        return [
            Stat::make('Total Pengunjung', $totalPengunjung)
                ->description('Total pengunjung tiket lunas')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'), // Warna biru/ungu

            Stat::make('Jumlah Transaksi', $jumlahTransaksi)
                ->description('Total transaksi berhasil')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('danger'), // Warna merah sesuai referensi gambar

            Stat::make('Total Pendapatan', 'Rp ' . number_format($totalPendapatan, 0, ',', '.'))
                ->description('Dari tiket yang sudah lunas')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'), // Warna hijau

            Stat::make('Destinasi Wisata', $jumlahWisata)
                ->description('Wisata yang dikelola')
                ->descriptionIcon('heroicon-m-map')
                ->color('warning'), // Warna oranye/kuning
        ];
    }
}
