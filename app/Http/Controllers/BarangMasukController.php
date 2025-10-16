<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    public function index()
    {
        $data = BarangMasuk::with('barang', 'user')->latest()->paginate(10);
        $barangs = Barang::all();
        return view('barang_masuk.index', compact('data', 'barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
        ]);

        $masuk = BarangMasuk::create([
            ...$request->all(),
            'user_id' => auth()->id()
        ]);

        // Update stok
        $barang = Barang::find($request->barang_id);
        $barang->increment('stok', $request->jumlah);

        return back()->with('success', 'Barang masuk berhasil dicatat.');
    }

    public function destroy(BarangMasuk $barangMasuk)
    {
        // rollback stok
        $barangMasuk->barang->decrement('stok', $barangMasuk->jumlah);
        $barangMasuk->delete();

        return back()->with('success', 'Data barang masuk dihapus.');
    }
}
