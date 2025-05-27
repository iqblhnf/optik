<?php

namespace App\Http\Controllers;

use App\Models\Anamnesa;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        // Jumlah total
        $totalPasien = Pasien::count();
        $totalPemeriksaan = Pemeriksaan::count();
        $totalUser = User::count();

        // Data untuk grafik 7 hari terakhir
        $chartLabels = [];
        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);
            $chartLabels[] = $tanggal->format('d M');
            $chartData[] = Pemeriksaan::whereDate('created_at', $tanggal)->count();
        }

        return view('dashboard.index', compact(
            'totalPasien',
            'totalPemeriksaan',
            'totalUser',
            'chartLabels',
            'chartData'
        ));
    }
}
