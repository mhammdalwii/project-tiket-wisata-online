<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser; // <-- 1. Tambahan Impor FilamentUser
use Filament\Panel;                         // <-- 1. Tambahan Impor Panel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

// 2. Tambahkan "implements FilamentUser" di sini
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',     // Menggunakan field Anda yang benar
        'username',  // Menggunakan field Anda yang benar
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi: Jika user ini berperan sebagai "Pengelola" wisata
    public function wisatas()
    {
        return $this->hasMany(Wisata::class, 'pengelola_id');
    }

    // Relasi: Jika user ini berperan sebagai "Wisatawan" yang memesan tiket
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'user_id');
    }

    // 3. FUNGSI PENJAGA GERBANG (GATEKEEPER)
    public function canAccessPanel(Panel $panel): bool
    {
        // Hanya role 'admin' dan 'pengelola' yang boleh login ke /admin
        return $this->hasRole(['admin', 'pengelola']);
    }
}
