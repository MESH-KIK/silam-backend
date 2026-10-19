<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesananModel extends Model
{
    protected $table = 'tbl_detail_pesanan';
    protected $primaryKey = 'id_detail_pesanan';
    public $timestamps = false;

    protected $fillable = ['id_pesanan', 'id_layanan', 'jumlah_berat', 'subtotal'];

    public function pesanan() { return $this->belongsTo(PesananModel::class, 'id_pesanan', 'id_pesanan'); }
    public function layanan() { return $this->belongsTo(LayananModel::class, 'id_layanan', 'id_layanan'); }
}
