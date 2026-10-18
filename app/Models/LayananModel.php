<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LayananModel extends Model
{
    protected $table = 'tbl_layanan';
    protected $primaryKey = 'id_layanan';
    public $timestamps = false;

    protected $fillable =[
                            'nama_layanan',
                            'satuan',
                            'kategori',
                            'harga_satuan',
                            'estimasi_selesai',
                            'deskripsi'
                        ];
}
