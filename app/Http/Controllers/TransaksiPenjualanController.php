<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiPenjualan;
use App\Models\TransaksiPenjualanDetail;
use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\Pemeriksaan;
use App\Models\Pasien;

class TransaksiPenjualanController extends Controller
{
    public function index()
    {
        $transaksi = TransaksiPenjualan::with('pasien', 'pemeriksaan', 'user')->latest()->paginate(10);
        return view('transaksi_penjualan.index', compact('transaksi'));
    }

    public function create()
    {
        $pemeriksaan = Pemeriksaan::with('anamnesa.pasien')->get();
        $barangs = Barang::all();
        return view('transaksi_penjualan.create', compact('pemeriksaan', 'barangs'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'id_pemeriksaan' => 'required',
            'id_pasien' => 'required',
            'items' => 'required|array|min:1',
        ]);

        $transaksi = TransaksiPenjualan::create([
            'id_pemeriksaan' => $request->id_pemeriksaan,
            'id_pasien' => $request->id_pasien,
            'user_id' => auth()->id(),
            'tanggal' => now(),
            'total' => $request->total ?? 0,
            'catatan' => $request->catatan,
        ]);

        foreach ($request->items as $item) {
            $detail = TransaksiPenjualanDetail::create([
                'id_transaksi' => $transaksi->id,
                'barang_id' => $item['barang_id'] ?? null,
                'nama_item' => $item['nama_item'],
                'tipe' => $item['tipe'],
                'jumlah' => $item['jumlah'],
                'harga' => $item['harga'],
                'subtotal' => $item['jumlah'] * $item['harga'],
            ]);

            // Jika tipe barang, keluarkan stok
            if ($item['tipe'] === 'barang' && isset($item['barang_id'])) {
                BarangKeluar::create([
                    'barang_id' => $item['barang_id'],
                    'jumlah' => $item['jumlah'],
                    'tujuan' => 'Penjualan #' . $transaksi->id,
                    'tanggal_keluar' => now(),
                    'user_id' => auth()->id()
                ]);

                $barang = Barang::find($item['barang_id']);
                $barang->decrement('stok', $item['jumlah']);
            }
        }

        return redirect()->route('transaksi-penjualan.index')
            ->with('success', 'Transaksi penjualan berhasil disimpan.');
    }
}
