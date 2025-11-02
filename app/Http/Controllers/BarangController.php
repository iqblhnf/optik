<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::latest()->get();

        $kategoriList = Barang::select('kategori')
                            ->distinct()
                            ->orderBy('kategori')
                            ->pluck('kategori')
                            ->filter()
                            ->toArray();

        $satuanList = Barang::select('satuan')
                            ->distinct()
                            ->orderBy('satuan')
                            ->pluck('satuan')
                            ->filter()
                            ->toArray();

        return view('barang.index', compact('barangs','kategoriList','satuanList'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:barangs',
            'nama_barang' => 'required',
        ]);

        Barang::create($request->all());
        return back()->with('success', 'Barang berhasil ditambahkan.');
    }

    public function update(Request $request, Barang $barang)
    {
        $barang->update($request->all());
        return back()->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();
        return back()->with('success', 'Barang berhasil dihapus.');
    }
}
