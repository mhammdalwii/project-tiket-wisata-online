<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use App\Models\Wisata;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends BaseWidget
{
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
        $totalPendapatan = $queryTransaksi->clone()->where('status_pembayaran', 'lunas')->sum('total_harga');
        $jumlahTransaksi = $queryTransaksi->clone()->where('status_pembayaran', 'lunas')->count();
        $jumlahWisata = $queryWisata->count();

        // 4. Tampilkan ke dalam bentuk kotak/widget
        return [
            Stat::make('Total Pendapatan', 'Rp ' . number_format($totalPendapatan, 0, ',', '.'))
                ->description('Dari tiket yang sudah lunas')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Tiket Terjual (Transaksi)', $jumlahTransaksi)
                ->description('Total transaksi berhasil')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('primary'),

            Stat::make('Destinasi Wisata', $jumlahWisata)
                ->description('Wisata yang dikelola')
                ->descriptionIcon('heroicon-m-map')
                ->color('warning'),
        ];
    }
}
