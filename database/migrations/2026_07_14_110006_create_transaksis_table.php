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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();

            // Kode booking unik (contoh: BK001)
            $table->string('kode_booking')->unique();

            // Relasi ke wisatawan (users)
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            // Relasi ke destinasi wisata (wisatas)
            $table->foreignId('wisata_id')->constrained('wisatas')->cascadeOnDelete();

            $table->date('tanggal_kunjungan');
            $table->time('waktu_kunjungan');
            $table->integer('jumlah_tiket');

            // Decimal dengan 10 digit total, 2 di belakang koma untuk harga
            $table->decimal('total_harga', 10, 2);

            // Enum metode pembayaran (Sesuai dengan UI form checkout)
            $table->enum('metode_pembayaran', ['Tunai', 'Transfer Bank BRI']);

            // Enum status pembayaran dengan default 'menunggu_pembayaran'
            $table->enum('status_pembayaran', [
                'menunggu_pembayaran',
                'menunggu_validasi',
                'lunas',
                'batal'
            ])->default('menunggu_pembayaran');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
