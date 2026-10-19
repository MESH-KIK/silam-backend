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
        Schema::create('tbl_detail_pesanan', function (Blueprint $table) {
            $table->id('id_detail_pesanan');
            $table->foreignId('id_pesanan')->constrained('tbl_pesanan', 'id_pesanan')->cascadeOnDelete();
            $table->foreignId('id_layanan')->constrained('tbl_layanan', 'id_layanan');
            $table->decimal('jumlah_berat', 10, 2);
            $table->decimal('subtotal', 12, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_detail_pesanan');
    }
};
