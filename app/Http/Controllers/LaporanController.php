<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiPenjualan;
use Carbon\Carbon;

class LaporanController extends Controller
{
    //
    public function penjualan(Request $request)
    {
        $tanggal_awal = $request->tanggal_awal ?? Carbon::now()->startOfMonth()->toDateString();
        $tanggal_akhir = $request->tanggal_akhir ?? Carbon::now()->endOfMonth()->toDateString();

        $data = TransaksiPenjualan::with(['pasien', 'user', 'detail'])
            ->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir])
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('laporan.penjualan', compact('data', 'tanggal_awal', 'tanggal_akhir'));
    }
    public function cetakPenjualan(Request $request)
    {
        $tanggal_awal = $request->tanggal_awal ?? Carbon::now()->startOfMonth()->toDateString();
        $tanggal_akhir = $request->tanggal_akhir ?? Carbon::now()->endOfMonth()->toDateString();

        $data = TransaksiPenjualan::with(['pasien', 'user', 'detail'])
            ->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir])
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('laporan.penjualan_cetak', compact('data', 'tanggal_awal', 'tanggal_akhir'));
    }
}
