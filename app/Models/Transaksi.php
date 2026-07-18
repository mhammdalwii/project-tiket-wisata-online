<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Transaksi extends Model implements HasMedia
{
    // Tambahkan InteractsWithMedia agar bisa menggunakan fungsi attach media (upload bukti transfer)
    use InteractsWithMedia;

    // Membuka mass-assignment selain ID
    protected $guarded = ['id'];

    // Relasi ke User (Wisatawan yang memesan)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Wisata (Destinasi yang dipesan)
    public function wisata()
    {
        return $this->belongsTo(Wisata::class, 'wisata_id');
    }
}
