<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TransaksiChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Transaksi (6 Bulan Terakhir)';

    // Agar tampil setengah layar (bersebelahan dengan tabel)
    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        // Looping 6 bulan ke belakang
        for ($i = 5; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            $labels[] = $bulan->translatedFormat('M'); // Menghasilkan Jan, Feb, dst

            // Siapkan query dasar berdasarkan bulan dan tahun
            $query = Transaksi::query()
                ->whereMonth('created_at', $bulan->month)
                ->whereYear('created_at', $bulan->year);

            // Filter keamanan: Jika yang login Pengelola, tampilkan grafiknya masing-masing
            if ($user && ! $user->hasRole('admin')) {
                $query->whereHas('wisata', function ($q) use ($user) {
                    $q->where('pengelola_id', $user->id);
                });
            }

            // Hitung jumlah transaksi yang sudah difilter
            $data[] = $query->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Transaksi',
                    'data' => $data,
                    'borderColor' => '#3b82f6', // Warna garis biru
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)', // Warna latar biru transparan
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
