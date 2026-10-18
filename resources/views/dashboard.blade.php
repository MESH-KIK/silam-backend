@extends('layouts.app')

@section('title', 'Dashboard')

@section('isikonten')
<h4 class="mb-3">Dashboard</h4>
<div class="row g-3 mb-4">
    @foreach(\App\Models\PesananModel::STATUS_KERJA as $key => $label)
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm"><div class="card-body">
                <div class="text-muted small">{{ $label }}</div>
                <div class="fs-3 fw-bold">{{ $perStatus[$key] ?? 0 }}</div>
            </div></div>
        </div>
    @endforeach
    <div class="col-md-6">
        <div class="card border-0 shadow-sm"><div class="card-body">
            <div class="text-muted small">Nilai pesanan masuk hari ini</div>
            <div class="fs-4 fw-bold">Rp {{ number_format($omzetHariIni, 0, ',', '.') }}</div>
        </div></div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm"><div class="card-body">
            <div class="text-muted small">Pesanan belum lunas</div>
            <div class="fs-4 fw-bold text-danger">{{ $belumLunas }}</div>
        </div></div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-semibold">Pesanan Terbaru</div>
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light"><tr><th>No. Pesanan</th><th>Pelanggan</th><th>Total</th><th>Pembayaran</th><th>Status</th></tr></thead>
            <tbody>
            @forelse($terbaru as $p)
                <tr>
                    <td><a href="{{ route('pesanan.show', $p) }}">{{ $p->nomor_pesanan }}</a></td>
                    <td>{{ $p->pelanggan->nama_pelanggan }}</td>
                    <td>Rp {{ number_format($p->total_tagihan, 0, ',', '.') }}</td>
                    <td><span class="badge bg-{{ $p->status_pembayaran === 'lunas' ? 'success' : 'danger' }}">{{ $p->status_pembayaran === 'lunas' ? 'Lunas' : 'Belum lunas' }}</span></td>
                    <td><span class="badge bg-{{ $p->badge_kerja }}">{{ $p->label_kerja }}</span></td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Belum ada pesanan.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
