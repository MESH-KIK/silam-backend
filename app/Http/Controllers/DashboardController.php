<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\PesananModel;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $perStatus = PesananModel::selectRaw('status_kerja, COUNT(*) as total')->groupBy('status_kerja')->pluck('total', 'status_kerja');

        return view('dashboard', [
            'perStatus'    => $perStatus,
            'belumLunas'   => PesananModel::where('status_pembayaran', 'belum_lunas')->count(),
            'omzetHariIni' => PesananModel::whereDate('tanggal_pesanan_dibuat', today())->sum('total_tagihan'),
            'terbaru'      => PesananModel::with('pelanggan')->latest('id_pesanan')->limit(8)->get(),
        ]);
    }
}
