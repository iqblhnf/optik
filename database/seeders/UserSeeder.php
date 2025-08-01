<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Optik',
            'username' => 'adminoptik',
            'kode_user' => 'AO',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);
    }
}
