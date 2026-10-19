@extends('layouts.app')

@section('title', $pesanan->nomor_pesanan)

@section('isikonten')
<div class="d-flex justify-content-between align-items-center mb-3 d-print-none">
    <h4 class="mb-0">{{ $pesanan->nomor_pesanan }}</h4>
    <div>
        <button class="btn btn-outline-secondary" onclick="window.print()"><i class="bi bi-printer"></i> Cetak Nota</button>
        <a href="{{ route('pesanan.index') }}" class="btn btn-light">Kembali</a>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm mb-3"><div class="card-body">
            <div class="d-none d-print-block text-center mb-3"><h4 class="mb-0">SILAM Laundry</h4><small>Nota Pesanan</small></div>
            <div class="row mb-3">
                <div class="col-sm-6">
                    <div class="text-muted small">Pelanggan</div>
                    <div class="fw-semibold">{{ $pesanan->pelanggan->nama_pelanggan }}</div>
                    <div>{{ $pesanan->pelanggan->nomor_telpon }}</div>
                </div>
                <div class="col-sm-6">
                    <div class="text-muted small">Masuk</div><div>{{ $pesanan->tanggal_pesanan_dibuat->format('d/m/Y H:i') }}</div>
                    <div class="text-muted small mt-2">Estimasi selesai</div><div>{{ $pesanan->tanggal_estimasi_selesai->format('d/m/Y H:i') }}</div>
                </div>
            </div>
            <table class="table table-sm">
                <thead><tr><th>Layanan</th><th class="text-end">Jumlah</th><th class="text-end">Harga</th><th class="text-end">Subtotal</th></tr></thead>
                <tbody>
                @foreach($pesanan->detail as $d)
                    <tr>
                        <td>{{ $d->layanan->nama_layanan }}</td>
                        <td class="text-end">{{ rtrim(rtrim(number_format($d->jumlah_berat, 2, ',', '.'), '0'), ',') }} {{ $d->layanan->satuan }}</td>
                        <td class="text-end">{{ number_format($d->layanan->harga_satuan, 0, ',', '.') }}</td>
                        <td class="text-end">{{ number_format($d->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot><tr><th colspan="3" class="text-end">Total</th><th class="text-end">Rp {{ number_format($pesanan->total_tagihan, 0, ',', '.') }}</th></tr></tfoot>
            </table>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="badge bg-{{ $pesanan->status_pembayaran === 'lunas' ? 'success' : 'danger' }} fs-6">{{ $pesanan->status_pembayaran === 'lunas' ? 'LUNAS' : 'BELUM LUNAS' }}</span>
                    <span class="badge bg-{{ $pesanan->badge_kerja }} fs-6">{{ $pesanan->label_kerja }}</span>
                </div>
                <small class="text-muted">Kasir: {{ $pesanan->kasir->nama_user }}</small>
            </div>

            @if($pesanan->status_pembayaran === 'belum_lunas' && in_array(auth()->user()->role, ['administrator','kasir']))
                <form method="POST" action="{{ route('pesanan.bayar', $pesanan) }}" class="mt-3 d-print-none" data-confirm="Tandai pesanan ini sebagai LUNAS?">@csrf @method('PATCH')
                    <button class="btn btn-success"><i class="bi bi-cash-coin"></i> Tandai Lunas</button>
                </form>
            @endif
        </div></div>

        <div class="card border-0 shadow-sm d-print-none"><div class="card-header bg-white fw-semibold">Update Status Pengerjaan</div><div class="card-body">
            <form method="POST" action="{{ route('pesanan.status', $pesanan) }}">@csrf @method('PATCH')
                <div class="row g-2">
                    <div class="col-md-5"><label class="form-label">Status kerja</label>
                        <select name="status_kerja" class="form-select" required>
                            @foreach(\App\Models\PesananModel::STATUS_KERJA as $k => $l)<option value="{{ $k }}" @selected($pesanan->status_kerja === $k)>{{ $l }}</option>@endforeach
                        </select></div>
                    <div class="col-md-7"><label class="form-label">Detail tracking</label>
                        <input name="status_detail" class="form-control" list="detailList" placeholder="mis. Sedang dicuci">
                        <datalist id="detailList"><option>Sedang dicuci</option><option>Sedang dikeringkan</option><option>Sedang disetrika</option><option>Sedang dikemas</option><option>Siap diambil di outlet</option></datalist></div>
                    <div class="col-12"><label class="form-label">Keterangan (opsional)</label><input name="keterangan" class="form-control"></div>
                </div>
                <button class="btn btn-primary mt-3">Simpan Status</button>
            </form>
        </div></div>
    </div>

    <div class="col-lg-5 d-print-none">
        <div class="card border-0 shadow-sm"><div class="card-header bg-white fw-semibold">Riwayat Tracking</div><div class="card-body">
            @foreach($pesanan->riwayat as $r)
                <div class="d-flex mb-3">
                    <div class="me-3 text-primary"><i class="bi bi-circle-fill small"></i></div>
                    <div>
                        <div class="fw-semibold">{{ $r->status_detail }}</div>
                        @if($r->keterangan)<div class="small">{{ $r->keterangan }}</div>@endif
                        <div class="small text-muted">{{ $r->waktu_update->format('d/m/Y H:i') }} &middot; {{ $r->petugas->nama_user ?? '-' }}</div>
                    </div>
                </div>
            @endforeach
        </div></div>
    </div>
</div>
@endsection
