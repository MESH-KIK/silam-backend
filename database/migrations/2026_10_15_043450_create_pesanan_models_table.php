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
        Schema::create('tbl_pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->string('nomor_pesanan')->unique();
            $table->foreignId('id_pelanggan')->constrained('tbl_pelanggan','id_pelanggan');
            $table->foreignId('id_user')->constrained('users','id_user');
            $table->decimal('total_tagihan', 12, 2)->default(0);
            $table->enum('status_pembayaran', ['belum_lunas', 'lunas'])->default('belum_lunas');
            $table->dateTime('tanggal_pesanan_dibuat');
            $table->dateTime('tanggal_estimasi_selesai');
            $table->enum('status_kerja', ['antrian', 'proses', 'siap_ambil', 'selesai'])->default('antrian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_pesanan');
    }
};
