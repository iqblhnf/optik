<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Pemeriksaan;
use App\Models\User;
use App\Models\TransaksiPenjualan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Total pasien, pemeriksaan, user
        $totalPasien = Pasien::count();
        $totalPemeriksaan = Pemeriksaan::count();
        $totalUser = User::count();

        // Penjualan hari ini
        $totalPenjualanHariIni = TransaksiPenjualan::whereDate('tanggal', Carbon::today())->sum('total');
        $jumlahTransaksiHariIni = TransaksiPenjualan::whereDate('tanggal', Carbon::today())->count();

        // Total pendapatan keseluruhan
        $totalPendapatan = TransaksiPenjualan::sum('total');

        // Data untuk grafik pemeriksaan 7 hari terakhir
        $chartLabelsPemeriksaan = [];
        $chartDataPemeriksaan = [];

        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);
            $chartLabelsPemeriksaan[] = $tanggal->format('d M');
            $chartDataPemeriksaan[] = Pemeriksaan::whereDate('created_at', $tanggal)->count();
        }

        // Data untuk grafik penjualan 7 hari terakhir
        $chartLabelsPenjualan = [];
        $chartDataPenjualan = [];

        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);
            $chartLabelsPenjualan[] = $tanggal->format('d M');
            $chartDataPenjualan[] = TransaksiPenjualan::whereDate('tanggal', $tanggal)->sum('total');
        }

        return view('dashboard.index', compact(
            'totalPasien',
            'totalPemeriksaan',
            'totalUser',
            'totalPendapatan',
            'totalPenjualanHariIni',
            'jumlahTransaksiHariIni',
            'chartLabelsPemeriksaan',
            'chartDataPemeriksaan',
            'chartLabelsPenjualan',
            'chartDataPenjualan'
        ));
    }
}
