<?php

// use App\Http\Controllers\AnamnesaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PemeriksaanController;
use App\Http\Controllers\PetugasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\TransaksiPenjualanController;
use App\Http\Controllers\LaporanController;



Route::middleware(['guest'])->group(function () {

    Route::get('/', [AuthController::class, 'formLogin'])->name('login');
    Route::post('/', [AuthController::class, 'prosesLogin'])->name('login.proses');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['role:admin'])->group(function () {

        Route::resource('petugas', PetugasController::class);
        Route::resource('pasien', PasienController::class);
        // Route::resource('anamnesa', AnamnesaController::class);
        Route::resource('pemeriksaan', PemeriksaanController::class);

        // Route::get('/pemeriksaan/riwayat/{id_pasien}', [PemeriksaanController::class, 'riwayat'])->name('pemeriksaan.riwayat');
        Route::get('/laporan', [PemeriksaanController::class, 'laporan'])->name('laporan');
        Route::get('/pemeriksaan/{id}/print', [PemeriksaanController::class, 'print'])->name('pemeriksaan.print');
        Route::resource('barang', BarangController::class);
        Route::resource('barang-masuk', BarangMasukController::class)->only(['index', 'store', 'destroy']);
        Route::resource('barang-keluar', BarangKeluarController::class)->only(['index', 'store', 'destroy']);
        Route::get('/stok', [StokController::class, 'index'])->name('stok.index');
        Route::resource('transaksi-penjualan', TransaksiPenjualanController::class);

        Route::get('laporan/penjualan', [LaporanController::class, 'penjualan'])->name('laporan.penjualan');
        Route::get('laporan/penjualan/cetak', [LaporanController::class, 'cetakPenjualan'])->name('laporan.penjualan.cetak');
    });

    Route::middleware(['role:pemeriksaan'])->group(function () {
        Route::resource('pasien', PasienController::class);
        // Route::resource('anamnesa', AnamnesaController::class);
        Route::resource('pemeriksaan', PemeriksaanController::class);
    });

    Route::middleware(['role:penjualan'])->group(function () {
        Route::get('/stok', [StokController::class, 'index'])->name('stok.index');
        Route::resource('transaksi-penjualan', TransaksiPenjualanController::class);
    });
});
