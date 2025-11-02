<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $data = BarangKeluar::with('barang', 'user')->latest()->paginate(10);
        $barangs = Barang::all();
        return view('barang_keluar.index', compact('data', 'barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required',
            'jumlah' => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $barang = Barang::find($request->barang_id);
        if ($barang->stok < $request->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        $namaFile = null;
        if ($request->hasFile('gambar')) {
            $namaFile = time() . '_' . $request->gambar->getClientOriginalName();
            $request->gambar->storeAs('barang_keluar', $namaFile, 'public');
        }

        BarangKeluar::create([
            ...$request->all(),
            'gambar' => $namaFile,
            'user_id' => auth()->id()
        ]);

        $barang->decrement('stok', $request->jumlah);

        return back()->with('success', 'Barang keluar berhasil dicatat.');
    }

    public function destroy(BarangKeluar $barangKeluar)
    {
        // rollback stok
        $barangKeluar->barang->increment('stok', $barangKeluar->jumlah);
        $barangKeluar->delete();

        return back()->with('success', 'Data barang keluar dihapus.');
    }
}
