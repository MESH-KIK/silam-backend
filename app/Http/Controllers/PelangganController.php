<?php

namespace App\Http\Controllers;

use App\Models\PelangganModel;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    private function rules(): array
    {
        return [
            'nama_pelanggan' => 'required|string|max:255',
            'nomor_telpon'   => ['required', 'regex:/^[0-9+\-\s]{8,20}$/'],
            'alamat'         => 'nullable|string',
            'status'         => 'required|in:aktif,non_aktif',
        ];
    }
    public function index(Request $request)
    {
        $items = PelangganModel::when($request->q, fn ($q, $s) => $q->where(fn ($w) => $w
                ->where('nama_pelanggan', 'like', "%$s%")->orWhere('nomor_telpon', 'like', "%$s%")))
            ->orderBy('nama_pelanggan')->paginate(10)->withQueryString();

        return view('pelanggan.index', compact('items'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        PelangganModel::create($request->validate($this->rules()));
        return back()->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, PelangganModel $pelanggan)
    {
        $pelanggan->update($request->validate($this->rules()));
        return back()->with('success', 'Data pelanggan diperbarui.');
    }

    public function destroy(PelangganModel $pelanggan)
    {
        if ($pelanggan->pesanan()->exists()) {
            $pelanggan->update(['status' => 'non_aktif']);
            return back()->with('success', 'Pelanggan punya riwayat pesanan, jadi dinonaktifkan (tidak dihapus).');
        }
        $pelanggan->delete();
        return back()->with('success', 'Pelanggan dihapus.');
    }
}
