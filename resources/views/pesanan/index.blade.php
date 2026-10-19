@extends('layouts.app')

@section('title', 'Pesanan')

@section('isikonten')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Pesanan</h4>
    @if(in_array(auth()->user()->role, ['administrator','kasir']))
        <a href="{{ route('pesanan.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Pesanan Baru</a>
    @endif
</div>

<form class="row g-2 mb-3">
    <div class="col-md-5"><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari no. pesanan / nama pelanggan"></div>
    <div class="col-md-3">
        <select name="status_kerja" class="form-select">
            <option value="">Semua status kerja</option>
            @foreach(\App\Models\PesananModel::STATUS_KERJA as $k => $l)<option value="{{ $k }}" @selected(request('status_kerja') === $k)>{{ $l }}</option>@endforeach
        </select>
    </div>
    <div class="col-md-2">
        <select name="status_pembayaran" class="form-select">
            <option value="">Semua pembayaran</option>
            <option value="belum_lunas" @selected(request('status_pembayaran') === 'belum_lunas')>Belum lunas</option>
            <option value="lunas" @selected(request('status_pembayaran') === 'lunas')>Lunas</option>
        </select>
    </div>
    <div class="col-md-2"><button class="btn btn-outline-secondary w-100">Filter</button></div>
</form>

<div class="card border-0 shadow-sm"><div class="table-responsive">
<table class="table table-hover align-middle mb-0">
    <thead class="table-light"><tr><th>No. Pesanan</th><th>Pelanggan</th><th>Masuk</th><th>Estimasi</th><th>Total</th><th>Pembayaran</th><th>Status</th></tr></thead>
    <tbody>
    @forelse($items as $p)
        <tr>
            <td><a href="{{ route('pesanan.show', $p) }}">{{ $p->nomor_pesanan }}</a></td>
            <td>{{ $p->pelanggan->nama_pelanggan }}</td>
            <td>{{ $p->tanggal_pesanan_dibuat->format('d/m/Y H:i') }}</td>
            <td>{{ $p->tanggal_estimasi_selesai->format('d/m/Y H:i') }}</td>
            <td>Rp {{ number_format($p->total_tagihan, 0, ',', '.') }}</td>
            <td><span class="badge bg-{{ $p->status_pembayaran === 'lunas' ? 'success' : 'danger' }}">{{ $p->status_pembayaran === 'lunas' ? 'Lunas' : 'Belum lunas' }}</span></td>
            <td><span class="badge bg-{{ $p->badge_kerja }}">{{ $p->label_kerja }}</span></td>
        </tr>
    @empty
        <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada pesanan.</td></tr>
    @endforelse
    </tbody>
</table></div></div>
<div class="mt-3">{{ $items->links() }}</div>
@endsection
