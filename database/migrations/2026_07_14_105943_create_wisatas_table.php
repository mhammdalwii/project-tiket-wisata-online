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
        Schema::create('wisatas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengelola_id')->constrained('users')->cascadeOnDelete();
            $table->string('nama_wisata');
            $table->string('lokasi');
            $table->text('deskripsi');
            $table->decimal('harga_tiket', 10, 2);
            $table->string('jam_operasional');
            $table->integer('kapasitas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wisatas');
    }
};
