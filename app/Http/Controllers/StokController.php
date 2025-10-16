<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index()
    {
        $barangs = Barang::all()->map(function ($barang) {
            $totalMasuk = BarangMasuk::where('barang_id', $barang->id)->sum('jumlah');
            $totalKeluar = BarangKeluar::where('barang_id', $barang->id)->sum('jumlah');
            $stokAkhir = $totalMasuk - $totalKeluar;

            return [
                'id' => $barang->id,
                'kode' => $barang->kode_barang,
                'nama' => $barang->nama_barang,
                'kategori' => $barang->kategori,
                'satuan' => $barang->satuan,
                'stok_tercatat' => $barang->stok,
                'total_masuk' => $totalMasuk,
                'total_keluar' => $totalKeluar,
                'stok_akhir' => $stokAkhir
            ];
        });

        return view('stok.index', compact('barangs'));
    }
}
