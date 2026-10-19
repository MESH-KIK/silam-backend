<?php

namespace App\Http\Controllers;

use App\Models\PelangganModel;
use App\Models\PesananModel;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->q);
        $dicari = $q !== '';
        $order = null;
        $daftar = collect();
        $with = ['pelanggan', 'detail.layanan', 'riwayat'];

        if ($dicari) {
            // 1) Cocokkan sebagai nomor pesanan
            $order = PesananModel::with($with)->where('nomor_pesanan', strtoupper($q))->first();

            // 2) Kalau bukan nomor pesanan dan bentuknya seperti nomor HP, cari lewat pelanggan
            if (! $order && preg_match('/^[0-9+\-\s]{8,20}$/', $q)) {
                $pelanggan = PelangganModel::where('nomor_telepon', $this->normalisasiTelepon($q))->first();

                if ($pelanggan) {
                    $daftar = PesananModel::where('id_pelanggan', $pelanggan->id_pelanggan)
                        ->orderByDesc('id_pesanan')->limit(5)->get();

                    if ($daftar->isNotEmpty()) {
                        $order = PesananModel::with($with)->find($daftar->first()->id_pesanan);
                    }
                }
            }
        }

        $info = $order ? $this->ringkas($order) : [];

        return view('status', compact('order', 'daftar', 'dicari', 'info'));
    }

    // Data siap tampil untuk satu pesanan
    private function ringkas(PesananModel $order): array
    {
        // "Budi Santoso" -> "Budi S."
        $bagian = preg_split('/\s+/', trim($order->pelanggan->nama_pelanggan));
        $depan = array_shift($bagian);
        $inisial = collect($bagian)->map(fn ($b) => mb_substr($b, 0, 1) . '.')->implode(' ');

        // "4,2 kg + 2 meter"
        $berat = $order->detail
            ->groupBy(fn ($d) => $d->layanan->satuan)
            ->map(fn ($g, $satuan) => rtrim(rtrim(number_format($g->sum('jumlah_berat'), 2, ',', '.'), '0'), ',') . ' ' . $satuan)
            ->implode(' + ');

        return [
            'nama'  => trim($depan . ' ' . $inisial),
            'paket' => $order->detail->pluck('layanan.nama_layanan')->unique()->implode(', '),
            'berat' => $berat,
            'tahap' => array_search($order->status_kerja, array_keys(PesananModel::STATUS_KERJA)) + 1, // 1-4
        ];
    }

    // 0812-3456-7890 / +62812... -> 0812...
    private function normalisasiTelepon(string $no): string
    {
        $no = preg_replace('/[^0-9]/', '', $no);
        return str_starts_with($no, '62') ? '0' . substr($no, 2) : $no;
    }
}
