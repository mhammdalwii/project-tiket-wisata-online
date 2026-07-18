<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    // Force Laravel untuk menggunakan tabel bernama 'fasilitas'
    protected $table = 'fasilitas';

    // Membuka mass-assignment selain ID
    protected $guarded = ['id'];

    // Relasi balik ke tabel Wisata
    public function wisata()
    {
        return $this->belongsTo(Wisata::class, 'wisata_id');
    }
}
