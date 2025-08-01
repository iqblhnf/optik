@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <!-- Card: Total Pasien -->
            <div class="col-lg-4 col-6">
                <div class="small-box text-bg-primary">
                    <div class="inner">
                        <h3>{{ $totalPasien }}</h3>
                        <p>Total Pasien</p>
                    </div>
                    <i class="bi bi-person-lines-fill small-box-icon"></i>
                    <a href="{{ route('pasien.index') }}" class="small-box-footer link-light link-underline-opacity-0">
                        Lihat Detail <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            <!-- Card: Total Pemeriksaan -->
            <div class="col-lg-4 col-6">
                <div class="small-box text-bg-warning">
                    <div class="inner">
                        <h3>{{ $totalPemeriksaan }}</h3>
                        <p>Total Pemeriksaan</p>
                    </div>
                    <i class="bi bi-eyeglasses small-box-icon"></i>
                    <a href="{{ route('pemeriksaan.index') }}" class="small-box-footer link-dark link-underline-opacity-0">
                        Lihat Detail <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            <!-- Card: Total User -->
            <div class="col-lg-4 col-6">
                <div class="small-box text-bg-danger">
                    <div class="inner">
                        <h3>{{ $totalUser }}</h3>
                        <p>Pengguna Sistem</p>
                    </div>
                    <i class="bi bi-people-fill small-box-icon"></i>
                    <a href="{{ route('petugas.index') }}" class="small-box-footer link-light link-underline-opacity-0">
                        Lihat Detail <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Grafik Pemeriksaan 7 Hari Terakhir</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="pemeriksaanChart" height="100"></canvas>
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
    const ctx = document.getElementById('pemeriksaanChart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(54, 162, 235, 0.9)');
    gradient.addColorStop(1, 'rgba(54, 162, 235, 0.1)');

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels ?? []) !!},
            datasets: [{
                label: 'Jumlah Pemeriksaan',
                data: {!! json_encode($chartData ?? []) !!},
                fill: true,
                backgroundColor: gradient,
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                tension: 0.4,
                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>
@endsection