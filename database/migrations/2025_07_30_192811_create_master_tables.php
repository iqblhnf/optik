<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel jauh
        Schema::create('jauh', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // contoh: Buram, Berbayang, Jelas
            $table->timestamps();
        });

        // Tabel dekat
        Schema::create('dekat', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // contoh: Buram, Berbayang, Jelas
            $table->timestamps();
        });

        // Tabel genetik
        Schema::create('genetik', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // contoh: Pengguna Kacamata, Tidak
            $table->timestamps();
        });

        // Tabel status_kacamata_lama
        Schema::create('status_kacamata_lama', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // contoh: tidak dibawa, rusak, hilang, sudah tidak enak
            $table->timestamps();
        });

        // Tabel penyakit
        Schema::create('penyakit', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jauh');
        Schema::dropIfExists('dekat');
        Schema::dropIfExists('genetik');
        Schema::dropIfExists('status_kacamata_lama');
    }
};
