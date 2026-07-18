<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Catatan: Laravel biasanya membuat bentuk jamak bahasa Inggris. 
        // Jika file Anda menggunakan nama tabel 'fasilitas', gunakan 'fasilitas'.
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel wisatas, cascade on delete agar data fasilitas ikut terhapus jika wisata dihapus
            $table->foreignId('wisata_id')->constrained('wisatas')->cascadeOnDelete();

            $table->string('nama_fasilitas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fasilitas');
    }
};
