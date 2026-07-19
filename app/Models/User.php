<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; // Pastikan ini ditambahkan

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles; // Tambahkan HasRoles di sini

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',     // Tambahan sesuai ERD
        'username',  // Tambahan sesuai ERD
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
}
