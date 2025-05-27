<?php

use App\Http\Controllers\AnamnesaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PemeriksaanController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {

    Route::get('/', [AuthController::class, 'formLogin'])->name('login');
    Route::post('/', [AuthController::class, 'prosesLogin'])->name('login.proses');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('pasien', PasienController::class);
    // Route::resource('anamnesa', AnamnesaController::class);
    Route::resource('pemeriksaan', PemeriksaanController::class);

    Route::get('/pemeriksaan/riwayat/{id_pasien}', [PemeriksaanController::class, 'riwayat'])->name('pemeriksaan.riwayat');
    Route::get('/laporan', [PemeriksaanController::class, 'laporan'])->name('laporan');
    Route::get('/pemeriksaan/{id}/print', [PemeriksaanController::class, 'print'])->name('pemeriksaan.print');
});
