<?php

namespace App\Http\Controllers;

use App\Models\LayananModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    private function rules(): array
    {
        return [
            'nama_layanan'     => 'required|string|max:255',
            'satuan'           => 'required|in:kg,meter',
            'kategori'         => 'required|in:cuci,setrika,cuci_setrika',
            'harga_satuan'     => 'required|numeric|min:0',
            'estimasi_selesai' => 'required|integer|min:1',
            'deskripsi'        => 'nullable|string'
        ];
    }

    public function index()
    {
        $items = LayananModel::orderBy('nama_layanan')->paginate(10);
        return view('layanan.index', compact('items'));
    }

    public function create()
    {
        return view('layanan.create');
    }

    public function store(Request $request)
    {
        LayananModel::create($request->validate($this->rules()));
        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(LayananModel $layanan)
    {
        return view('layanan.edit', compact('layanan'));
    }

    public function update(Request $request, LayananModel $layanan)
    {
        $layanan->update($request->validate($this->rules()));
        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(LayananModel $layanan)
    {
        try {
            $layanan->delete();
            return redirect()->route('layanan.index')->with('success', 'Layanan berhasil dihapus.');
        } catch (QueryException $e) {
            return redirect()->route('layanan.index')->with('error', 'Layanan tidak bisa dihapus karena masih dipakai di pesanan.');
        }
    }
}
