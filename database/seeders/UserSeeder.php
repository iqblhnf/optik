<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 🔹 Role: Admin (akses penuh)
        User::create([
            'name' => 'Admin Optik',
            'username' => 'adminoptik',
            'kode_user' => 'AO',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 🔹 Role: Pemeriksaan (hanya input pasien & pemeriksaan)
        User::create([
            'name' => 'Petugas Pemeriksaan',
            'username' => 'pemeriksaan',
            'kode_user' => 'PM',
            'password' => Hash::make('password123'),
            'role' => 'pemeriksaan',
        ]);

        // 🔹 Role: Penjualan (akses penjualan & stok)
        User::create([
            'name' => 'Petugas Penjualan',
            'username' => 'penjualan',
            'kode_user' => 'PJ',
            'password' => Hash::make('password123'),
            'role' => 'penjualan',
        ]);
    }
}
