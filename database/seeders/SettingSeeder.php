<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'nama_optik' => 'Optik Woka Vision',
            'alamat_optik' => 'Jl. Sudirman No.12, Metro – Lampung',
            'logo' => 'default-logo.png',
            'background' => 'default-bg.jpg'
        ]);
    }
}
