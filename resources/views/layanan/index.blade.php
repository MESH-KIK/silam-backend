@extends('layouts.app')

@section('title_menu', 'Beranda')

@section('isikonten')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Jenis Layanan</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formModal"><i class="bi bi-plus-lg"></i> Tambah</button>
</div>
<div class="card border-0 shadow-sm"><div class="table-responsive">
<table class="table table-hover align-middle mb-0">
    <thead class="table-light"><tr><th>Nama</th><th>Kategori</th><th>Satuan</th><th>Harga</th><th>Estimasi</th><th class="text-end">Aksi</th></tr></thead>
    <tbody>
    @forelse($items as $i)
        <tr>
            <td>{{ $i->nama_layanan }}<div class="small text-muted">{{ $i->deskripsi }}</div></td>
            <td>{{ ucwords(str_replace('_', ' + ', $i->kategori)) }}</td>
            <td>{{ $i->satuan }}</td>
            <td>Rp {{ number_format($i->harga_satuan, 0, ',', '.') }}</td>
            <td>{{ $i->estimasi_selesai }} jam</td>
            <td class="text-end text-nowrap">
                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#formModal"
                    data-url="{{ route('layanan.update', $i) }}" data-item="{{ json_encode($i) }}"><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('layanan.destroy', $i) }}" class="d-inline" data-confirm="Hapus layanan ini?">@csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button></form>
            </td>
        </tr>
    @empty
        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada layanan.</td></tr>
    @endforelse
    </tbody>
</table></div></div>
<div class="mt-3">{{ $items->links() }}</div>

<div class="modal fade" id="formModal" tabindex="-1"><div class="modal-dialog"><form method="POST" class="modal-content" data-store-url="{{ route('layanan.store') }}">
    @csrf <input type="hidden" name="_method" value="POST">
    <div class="modal-header"><h5 class="modal-title"></h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body">
        <div class="mb-3"><label class="form-label">Nama Layanan</label><input name="nama_layanan" class="form-control" required></div>
        <div class="row">
            <div class="col-6 mb-3"><label class="form-label">Kategori</label>
                <select name="kategori" class="form-select" required>
                    <option value="cuci">Cuci</option><option value="setrika">Setrika</option><option value="cuci_setrika">Cuci + Setrika</option>
                </select></div>
            <div class="col-6 mb-3"><label class="form-label">Satuan</label>
                <select name="satuan" class="form-select" required><option value="kg">kg</option><option value="meter">meter</option></select></div>
            <div class="col-6 mb-3"><label class="form-label">Harga per Satuan (Rp)</label><input type="number" min="0" step="100" name="harga_satuan" class="form-control" required></div>
            <div class="col-6 mb-3"><label class="form-label">Estimasi (jam)</label><input type="number" min="1" name="estimasi_selesai" class="form-control" required></div>
        </div>
        <div class="mb-3"><label class="form-label">Deskripsi</label><textarea name="deskripsi" rows="2" class="form-control"></textarea></div>
    </div>
    <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button><button class="btn btn-primary">Simpan</button></div>
</form></div></div>

@endsection
