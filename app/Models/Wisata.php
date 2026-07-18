<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Wisata extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = ['id']; // Membuka mass-assignment selain ID

    // Relasi ke User (Pengelola)
    public function pengelola()
    {
        return $this->belongsTo(User::class, 'pengelola_id');
    }

    // Relasi ke Fasilitas
    public function fasilitas()
    {
        return $this->hasMany(Fasilitas::class);
    }
}
