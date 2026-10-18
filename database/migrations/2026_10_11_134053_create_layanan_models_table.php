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
        Schema::create('tbl_layanan', function (Blueprint $table) {
            $table->id('id_layanan');
            $table->string('nama_layanan');
            $table->enum('satuan', ['kg', 'meter']);
            $table->enum('kategori', ['cuci', 'setrika', 'cuci_setrika']);
            $table->decimal('harga_satuan', 12, 2);
            $table->unsignedInteger('estimasi_selesai');
            $table->text('deskripsi')->nullable();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_layanan');
    }
};
