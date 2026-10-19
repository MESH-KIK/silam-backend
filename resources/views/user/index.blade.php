@extends('layouts.app')

@section('title', 'Pelanggan')

@section('isikonten')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Pelanggan</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formModal"><i class="bi bi-plus-lg"></i> Tambah</button>
</div>
<form class="mb-3"><div class="input-group"><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama / nomor telepon"><button class="btn btn-outline-secondary"><i class="bi bi-search"></i></button></div></form>
<div class="card border-0 shadow-sm"><div class="table-responsive">
<table class="table table-hover align-middle mb-0">
    <thead class="table-light"><tr><th>Nama</th><th>Telepon</th><th>Alamat</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
    <tbody>
    @forelse($items as $i)
        <tr>
            <td>{{ $i->nama_pelanggan }}</td><td>{{ $i->nomor_telpon }}</td><td>{{ $i->alamat }}</td>
            <td><span class="badge bg-{{ $i->status === 'aktif' ? 'success' : 'secondary' }}">{{ $i->status === 'aktif' ? 'Aktif' : 'Non aktif' }}</span></td>
            <td class="text-end text-nowrap">
                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#formModal"
                    data-url="{{ route('pelanggan.update', $i) }}" data-item="{{ json_encode($i) }}"><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('pelanggan.destroy', $i) }}" class="d-inline" data-confirm="Hapus pelanggan ini?">@csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button></form>
            </td>
        </tr>
    @empty
        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada pelanggan.</td></tr>
    @endforelse
    </tbody>
</table></div></div>
<div class="mt-3">{{ $items->links() }}</div>

<div class="modal fade" id="formModal" tabindex="-1"><div class="modal-dialog"><form method="POST" class="modal-content" data-store-url="{{ route('pelanggan.store') }}">
    @csrf <input type="hidden" name="_method" value="POST">
    <div class="modal-header"><h5 class="modal-title"></h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body">
        <div class="mb-3"><label class="form-label">Nama</label><input name="nama_pelanggan" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Nomor Telepon</label><input name="nomor_telpon" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Alamat</label><textarea name="alamat" rows="2" class="form-control"></textarea></div>
        <div class="mb-3"><label class="form-label">Status</label><select name="status" class="form-select"><option value="aktif">Aktif</option><option value="non_aktif">Non aktif</option></select></div>
    </div>
    <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button><button class="btn btn-primary">Simpan</button></div>
</form></div></div>
@endsection
