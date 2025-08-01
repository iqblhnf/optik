<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Jauh & Dekat
        foreach (['Buram', 'Berbayang', 'Jelas'] as $val) {
            DB::table('jauh')->insert(['nama' => $val]);
            DB::table('dekat')->insert(['nama' => $val]);
        }

        // Genetik
        foreach (['Pengguna Kacamata', 'Tidak'] as $val) {
            DB::table('genetik')->insert(['nama' => $val]);
        }

        // Status kacamata lama
        foreach (['tidak dibawa', 'rusak', 'hilang', 'sudah tidak enak'] as $val) {
            DB::table('status_kacamata_lama')->insert(['nama' => $val]);
        }
    }
}
