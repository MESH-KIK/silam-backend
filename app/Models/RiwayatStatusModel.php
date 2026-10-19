<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatStatusModel extends Model
{
     protected $table = 'tbl_riwayat_status';
    protected $primaryKey = 'id_riwayat';
    public $timestamps = false;

    protected $fillable = ['id_pesanan', 'id_user', 'status_detail', 'keterangan', 'waktu_update'];
    protected $casts = ['waktu_update' => 'datetime'];

    public function petugas() { return $this->belongsTo(User::class, 'id_user', 'id_user'); }

}
