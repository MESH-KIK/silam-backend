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
        Schema::create('tbl_riwayat_status', function (Blueprint $table) {
            $table->id('id_riwayat');
            $table->foreignId('id_pesanan')->constrained('tbl_pesanan', 'id_pesanan')->cascadeOnDelete();
            $table->foreignId('id_user')->constrained('users', 'id_user'); // petugas yang update
            $table->string('status_detail');
            $table->text('keterangan')->nullable();
            $table->dateTime('waktu_update');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_riwayat_status');
    }
};
