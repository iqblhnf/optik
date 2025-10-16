@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <!-- Card: Total Pasien -->
            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-primary">
                    <div class="inner">
                        <h3>{{ $totalPasien }}</h3>
                        <p>Total Pasien</p>
                    </div>
                    <i class="bi bi-person-lines-fill small-box-icon"></i>
                    <a href="{{ route('pasien.index') }}" class="small-box-footer link-light">Lihat Detail <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>

            <!-- Card: Total Pemeriksaan -->
            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-warning">
                    <div class="inner">
                        <h3>{{ $totalPemeriksaan }}</h3>
                        <p>Total Pemeriksaan</p>
                    </div>
                    <i class="bi bi-eyeglasses small-box-icon"></i>
                    <a href="{{ route('pemeriksaan.index') }}" class="small-box-footer link-dark">Lihat Detail <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>

            <!-- Card: Total Pengguna -->
            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-danger">
                    <div class="inner">
                        <h3>{{ $totalUser }}</h3>
                        <p>Pengguna Sistem</p>
                    </div>
                    <i class="bi bi-people-fill small-box-icon"></i>
                    <a href="{{ route('petugas.index') }}" class="small-box-footer link-light">Lihat Detail <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>

            <!-- Card: Penjualan Hari Ini -->
            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-success">
                    <div class="inner">
                        <h3>Rp {{ number_format($totalPenjualanHariIni, 0, ',', '.') }}</h3>
                        <p>Penjualan Hari Ini ({{ $jumlahTransaksiHariIni }} Transaksi)</p>
                    </div>
                    <i class="bi bi-cash-coin small-box-icon"></i>
                    <a href="{{ route('transaksi-penjualan.index') }}" class="small-box-footer link-light">Lihat Detail <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="row mt-4">
            <!-- Grafik Pemeriksaan -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Grafik Pemeriksaan 7 Hari Terakhir</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="pemeriksaanChart" height="100"></canvas>
                    </div>
                </div>
            </div>

            <!-- Grafik Penjualan -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Grafik Penjualan 7 Hari Terakhir</h5>
                        <small>Total Pendapatan: <b>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</b></small>
                    </div>
                    <div class="card-body">
                        <canvas id="penjualanChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // === Grafik Pemeriksaan ===
    const ctx1 = document.getElementById('pemeriksaanChart').getContext('2d');
    const gradient1 = ctx1.createLinearGradient(0, 0, 0, 400);
    gradient1.addColorStop(0, 'rgba(255, 193, 7, 0.9)');
    gradient1.addColorStop(1, 'rgba(255, 193, 7, 0.1)');

    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabelsPemeriksaan ?? []) !!},
            datasets: [{
                label: 'Jumlah Pemeriksaan',
                data: {!! json_encode($chartDataPemeriksaan ?? []) !!},
                fill: true,
                backgroundColor: gradient1,
                borderColor: 'rgba(255, 193, 7, 1)',
                borderWidth: 2,
                tension: 0.4,
                pointBackgroundColor: 'rgba(255, 193, 7, 1)',
                pointRadius: 4
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } }
    });

    // === Grafik Penjualan ===
    const ctx2 = document.getElementById('penjualanChart').getContext('2d');
    const gradient2 = ctx2.createLinearGradient(0, 0, 0, 400);
    gradient2.addColorStop(0, 'rgba(40, 167, 69, 0.9)');
    gradient2.addColorStop(1, 'rgba(40, 167, 69, 0.1)');

    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabelsPenjualan ?? []) !!},
            datasets: [{
                label: 'Total Penjualan (Rp)',
                data: {!! json_encode($chartDataPenjualan ?? []) !!},
                backgroundColor: gradient2,
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
