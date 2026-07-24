<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use App\Filament\Resources\TransaksiResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth; // Tambahkan ini untuk memanggil data user login

class TransaksiTerbaru extends BaseWidget
{
    protected static ?string $heading = 'Transaksi Terbaru';

    // Agar tampil setengah layar (bersebelahan dengan grafik)
    protected int | string | array $columnSpan = 1;

    public function table(Table $table): Table
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        // 1. Siapkan query dasar (ambil 5 data terbaru)
        $query = Transaksi::query()->latest()->limit(5);

        // 2. Filter keamanan multi-role
        if ($user && ! $user->hasRole('admin')) {
            $query->whereHas('wisata', function ($q) use ($user) {
                $q->where('pengelola_id', $user->id);
            });
        }

        return $table
            ->query($query) // Masukkan query yang sudah difilter ke dalam tabel
            ->columns([
                Tables\Columns\TextColumn::make('kode_booking')
                    ->label('Kode Booking')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('wisata.nama_wisata')
                    ->label('Destinasi'),
                Tables\Columns\TextColumn::make('status_pembayaran')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'lunas' => 'success',
                        'menunggu_pembayaran', 'menunggu_validasi' => 'warning',
                        'batal', 'dibatalkan' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->paginated(false) // Mematikan pagination karena hanya cuplikan
            ->headerActions([
                // Tombol Lihat Semua Transaksi
                Tables\Actions\Action::make('lihat_semua')
                    ->label('Lihat semua transaksi →')
                    ->url(fn(): string => TransaksiResource::getUrl('index'))
                    ->button()
                    ->outlined(),
            ]);
    }
}
