<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelangganModel extends Model
{
    protected $table = 'tbl_pelanggan';
    protected $primaryKey = 'id_pelanggan';
    protected $fillable =[
                            'nama_pelanggan',
                            'nomor_telepon',
                            'alamat'
                        ];
}
