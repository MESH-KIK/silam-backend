<?php

namespace Database\Seeders;

use App\Models\LayananModel;
use App\Models\PelangganModel;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create(['nama_user' => 'Administrator', 'email' => 'admin@silam.test',  'password' => 'admin123', 'role' => 'administrator']);
        User::create(['nama_user' => 'Kasir Satu',    'email' => 'kasir@silam.test',  'password' => 'kasir123', 'role' => 'kasir']);
        User::create(['nama_user' => 'Pegawai Satu',  'email' => 'pegawai@silam.test', 'password' => 'pegawai123', 'role' => 'pegawai']);

        LayananModel::insert([
            ['nama_layanan' => 'Reguler','satuan' => 'kg', 'kategori' => 'cuci_setrika', 'harga_satuan' => 8000,  'estimasi_selesai' => 72, 'deskripsi' => 'Cuci setrika dengan waktu pengerjaan 3 hari'],
            ['nama_layanan' => 'Express','satuan' => 'kg', 'kategori' => 'cuci_setrika', 'harga_satuan' => 10000, 'estimasi_selesai' => 24, 'deskripsi' => 'Cuci setrika dengan maksimal pengerjaan 1 hari'],
            ['nama_layanan' => 'Kilat',  'satuan' => 'kg', 'kategori' => 'cuci_setrika', 'harga_satuan' => 12000, 'estimasi_selesai' => 12, 'deskripsi' => 'Cuci setrika dengan pengerjaan 12 jam'],
            ['nama_layanan' => 'Setrika','satuan' => 'kg', 'kategori' => 'setrika',      'harga_satuan' => 5000,  'estimasi_selesai' => 72, 'deskripsi' => 'Setrika pakaian dll'],
        ]);

        PelangganModel::create(['nama_pelanggan' => 'Kenneth', 'nomor_telepon' => '081234567890', 'alamat' => 'Bandung']);
    }
}
