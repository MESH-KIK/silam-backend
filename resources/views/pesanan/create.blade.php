@extends('layouts.app')

@section('title', 'Pesanan Baru')

@section('isikonten')
<h4 class="mb-3">Pesanan Baru</h4>
<form method="POST" action="{{ route('pesanan.store') }}">@csrf
    <div class="card border-0 shadow-sm mb-3"><div class="card-body">
        <label class="form-label">Pelanggan</label>
        <select name="id_pelanggan" class="form-select" required>
            <option value="">-- pilih pelanggan --</option>
            @foreach($pelanggan as $p)
                <option value="{{ $p->id_pelanggan }}" @selected(old('id_pelanggan') == $p->id_pelanggan)>{{ $p->nama_pelanggan }} ({{ $p->nomor_telpon }})</option>
            @endforeach
        </select>
        <div class="form-text">Pelanggan belum terdaftar? <a href="{{ route('pelanggan.index') }}">Tambah dulu di menu Pelanggan</a>.</div>
    </div></div>

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <span class="fw-semibold">Item Layanan</span>
            <button type="button" id="addRow" class="btn btn-sm btn-outline-primary"><i class="bi bi-plus"></i> Tambah item</button>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light"><tr><th style="width:40%">Layanan</th><th style="width:20%">Jumlah</th><th>Satuan</th><th class="text-end">Subtotal</th><th></th></tr></thead>
                <tbody id="items"></tbody>
                <tfoot><tr><th colspan="3" class="text-end">Total Tagihan</th><th class="text-end fs-5" id="total">Rp 0</th><th></th></tr></tfoot>
            </table>
        </div>
    </div>

    <button class="btn btn-primary"><i class="bi bi-check-lg"></i> Simpan Pesanan</button>
    <a href="{{ route('pesanan.index') }}" class="btn btn-light">Batal</a>
</form>

<template id="rowTpl">
    <tr>
        <td>
            <select name="items[__i__][id_layanan]" class="form-select layanan" required>
                <option value="">-- pilih layanan --</option>
                @foreach($layanan as $l)
                    <option value="{{ $l->id_layanan }}" data-harga="{{ $l->harga_satuan }}" data-satuan="{{ $l->satuan }}">{{ $l->nama_layanan }} (Rp {{ number_format($l->harga_satuan, 0, ',', '.') }}/{{ $l->satuan }})</option>
                @endforeach
            </select>
        </td>
        <td><input type="number" name="items[__i__][jumlah]" class="form-control jumlah" min="0.01" step="0.01" required></td>
        <td class="satuan text-muted">-</td>
        <td class="subtotal text-end">Rp 0</td>
        <td class="text-end"><button type="button" class="btn btn-sm btn-outline-danger btn-del"><i class="bi bi-x-lg"></i></button></td>
    </tr>
</template>
@endsection

@push('scripts')
<script>
(() => {
    const body = document.getElementById('items');
    const tpl = document.getElementById('rowTpl').innerHTML;
    const rupiah = n => 'Rp ' + Math.round(n).toLocaleString('id-ID');
    let idx = 0;

    function hitung() {
        let total = 0;
        body.querySelectorAll('tr').forEach(tr => {
            const opt = tr.querySelector('.layanan').selectedOptions[0];
            const harga = parseFloat(opt?.dataset.harga || 0);
            const jml = parseFloat(tr.querySelector('.jumlah').value || 0);
            const sub = harga * jml;
            tr.querySelector('.satuan').textContent = opt?.dataset.satuan || '-';
            tr.querySelector('.subtotal').textContent = rupiah(sub);
            total += sub;
        });
        document.getElementById('total').textContent = rupiah(total);
    }

    function tambah() {
        body.insertAdjacentHTML('beforeend', tpl.replaceAll('__i__', idx++));
    }

    document.getElementById('addRow').addEventListener('click', tambah);
    body.addEventListener('input', hitung);
    body.addEventListener('change', hitung);
    body.addEventListener('click', e => {
        const btn = e.target.closest('.btn-del');
        if (btn && body.children.length > 1) { btn.closest('tr').remove(); hitung(); }
    });
    tambah();
})();
</script>
@endpush
