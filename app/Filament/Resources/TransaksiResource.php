<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiResource\Pages;
use App\Models\Transaksi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'Data Transaksi';
    protected static ?string $navigationGroup = 'Manajemen Transaksi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Pemesanan')
                    ->description('Informasi pesanan dari wisatawan (Hanya Baca).')
                    ->schema([
                        Forms\Components\TextInput::make('kode_booking')
                            ->disabled()
                            ->columnSpanFull(),

                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->label('Wisatawan')
                            ->disabled(),

                        Forms\Components\Select::make('wisata_id')
                            ->relationship('wisata', 'nama_wisata')
                            ->label('Destinasi Wisata')
                            ->disabled(),

                        Forms\Components\DatePicker::make('tanggal_kunjungan')
                            ->disabled(),

                        Forms\Components\TextInput::make('jumlah_tiket')
                            ->numeric()
                            ->disabled(),

                        Forms\Components\TextInput::make('total_harga')
                            ->prefix('Rp')
                            ->numeric()
                            ->disabled(),

                        Forms\Components\TextInput::make('metode_pembayaran')
                            ->disabled(),
                    ])->columns(2),

                Forms\Components\Section::make('Validasi & Bukti Pembayaran')
                    ->schema([
                        Forms\Components\SpatieMediaLibraryFileUpload::make('bukti_transfer')
                            ->collection('bukti_transfer')
                            ->label('Foto Bukti Transfer')
                            ->disabled() // Admin hanya bisa melihat, tidak bisa mengganti bukti bayar
                            ->columnSpanFull(),

                        Forms\Components\Select::make('status_pembayaran')
                            ->options([
                                'menunggu_pembayaran' => 'Menunggu Pembayaran',
                                'menunggu_validasi' => 'Menunggu Validasi',
                                'lunas' => 'Lunas',
                                'batal' => 'Batal',
                            ])
                            ->required()
                            ->native(false),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_booking')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Wisatawan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('wisata.nama_wisata')
                    ->label('Wisata')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tanggal_kunjungan')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('jumlah_tiket')
                    ->label('Jumlah Tiket')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_harga')
                    ->money('IDR', locale: 'id')
                    ->sortable(),

                // Menampilkan status dengan warna yang intuitif
                Tables\Columns\TextColumn::make('status_pembayaran')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'menunggu_pembayaran' => 'gray',
                        'menunggu_validasi' => 'warning',
                        'lunas' => 'success',
                        'batal' => 'danger',
                    })
                    ->formatStateUsing(fn(string $state): string => ucwords(str_replace('_', ' ', $state))),
            ])
            ->defaultSort('created_at', 'desc') // Mengurutkan dari transaksi terbaru
            ->filters([
                // Filter berdasarkan status untuk memudahkan admin
                Tables\Filters\SelectFilter::make('status_pembayaran')
                    ->options([
                        'menunggu_pembayaran' => 'Menunggu Pembayaran',
                        'menunggu_validasi' => 'Menunggu Validasi',
                        'lunas' => 'Lunas',
                        'batal' => 'Batal',
                    ]),
            ])
            ->headerActions([
                ExportAction::make()
                    ->label('Export Excel')
                    ->color('success')
                    ->icon('heroicon-o-document-arrow-down')
                    ->exports([
                        ExcelExport::make()
                            ->fromTable() // Otomatis membaca kolom dari tabel Filament
                            ->withFilename('Laporan_Transaksi_' . date('Y-m-d'))
                    ]),
            ])
            ->actions([
                // Tombol Validasi Cepat langsung dari tabel
                Tables\Actions\Action::make('validasi')
                    ->label('Validasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Validasi Pembayaran')
                    ->modalDescription('Apakah Anda yakin pembayaran ini valid dan tiket siap diterbitkan?')
                    ->visible(fn(Transaksi $record): bool => $record->status_pembayaran === 'menunggu_validasi')
                    ->action(function (Transaksi $record) {
                        $record->update(['status_pembayaran' => 'lunas']);
                    }),

                Tables\Actions\EditAction::make()->label('Detail/Edit'),

                Tables\Actions\Action::make('cetak_tiket')
                    ->label('Download Tiket')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('primary')
                    ->url(fn(Transaksi $record) => route('cetak.tiket', $record->id))
                    ->openUrlInNewTab() // Buka tab baru agar admin tidak keluar dari dashboard
                    ->visible(fn(Transaksi $record): bool => $record->status_pembayaran === 'lunas'), // HANYA MUNCUL JIKA LUNAS
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        /** @var \App\Models\User|null $user */
        $user = Auth::user(); // <-- Ganti bagian ini

        // Jika user BUKAN admin, tampilkan transaksi HANYA untuk wisata miliknya
        if ($user && ! $user->hasRole('admin')) {
            $query->whereHas('wisata', function (Builder $query) use ($user) {
                $query->where('pengelola_id', $user->id);
            });
        }

        return $query;
    }
}
