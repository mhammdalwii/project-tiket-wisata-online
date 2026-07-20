<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WisataResource\Pages;
use App\Models\Wisata;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class WisataResource extends Resource
{
    protected static ?string $model = Wisata::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static ?string $navigationLabel = 'Data Wisata';
    protected static ?string $navigationGroup = 'Manajemen Wisata';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Bagian 1: Informasi Utama
                Forms\Components\Section::make('Informasi Utama')
                    ->schema([
                        Forms\Components\Select::make('pengelola_id')
                            ->relationship('pengelola', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Pengelola (User)'),

                        Forms\Components\TextInput::make('nama_wisata')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('lokasi')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('jam_operasional')
                            ->required()
                            ->placeholder('Contoh: 08:00 - 17:00 WITA')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('harga_tiket')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->minValue(0),

                        Forms\Components\TextInput::make('kapasitas')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->label('Kapasitas Tiket/Hari'),

                        Forms\Components\Textarea::make('deskripsi')
                            ->required()
                            ->columnSpanFull()
                            ->rows(4),
                    ])->columns(2),

                // Bagian 2: Unggah Foto (Spatie Media Library)
                Forms\Components\Section::make('Galeri Wisata')
                    ->schema([
                        Forms\Components\SpatieMediaLibraryFileUpload::make('wisata_images')
                            ->collection('wisata_images')
                            ->multiple() // Mengizinkan upload lebih dari 1 foto
                            ->reorderable()
                            ->image()
                            ->maxFiles(5)
                            ->label('Foto Objek Wisata (Max 5)'),
                    ]),

                // Bagian 3: Fasilitas (Repeater)
                Forms\Components\Section::make('Fasilitas Pendukung')
                    ->description('Tambahkan fasilitas yang tersedia di lokasi wisata ini.')
                    ->schema([
                        Forms\Components\Repeater::make('fasilitas')
                            ->relationship() // Otomatis membaca relasi hasMany() di Model
                            ->schema([
                                Forms\Components\TextInput::make('nama_fasilitas')
                                    ->required()
                                    ->placeholder('Contoh: Toilet Bersih, Gazebo, dll.')
                                    ->label('Nama Fasilitas'),
                            ])
                            ->addActionLabel('Tambah Fasilitas')
                            ->columns(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('wisata_images')
                    ->collection('wisata_images')
                    ->label('Foto')
                    ->circular()
                    ->limit(1), // Menampilkan 1 foto utama saja di tabel

                Tables\Columns\TextColumn::make('nama_wisata')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('pengelola.name')
                    ->label('Pengelola')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('harga_tiket')
                    ->money('IDR', locale: 'id') // Format Rupiah otomatis
                    ->sortable(),

                Tables\Columns\TextColumn::make('kapasitas')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListWisatas::route('/'),
            'create' => Pages\CreateWisata::route('/create'),
            'edit' => Pages\EditWisata::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        /** @var \App\Models\User|null $user */
        $user = Auth::user(); // <-- Ganti bagian ini

        // Jika user yang login BUKAN admin, tampilkan HANYA wisata miliknya
        if ($user && ! $user->hasRole('admin')) {
            $query->where('pengelola_id', $user->id);
        }

        return $query;
    }
}
