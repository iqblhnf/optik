<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


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
            'gambar' => 'nullable|image|max:2048'
        ]);

        $path = null;
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('barang-masuk', 'public');
        }

        $masuk = BarangMasuk::create([
            ...$request->all(),
            'gambar' => $path,
            'user_id' => auth()->id()
        ]);

        Barang::find($request->barang_id)->increment('stok', $request->jumlah);

        return back()->with('success', 'Barang masuk berhasil dicatat.');
    }

    public function destroy(BarangMasuk $barangMasuk)
    {
        if ($barangMasuk->gambar) {
            Storage::disk('public')->delete($barangMasuk->gambar);
        }

        $barangMasuk->barang->decrement('stok', $barangMasuk->jumlah);
        $barangMasuk->delete();

        return back()->with('success', 'Data barang masuk dihapus.');
    }

}
