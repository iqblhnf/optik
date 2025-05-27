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
        Schema::create('anamnesa', function (Blueprint $table) {
            $table->id();

            // Foreign key ke tabel pasien
            $table->unsignedBigInteger('id_pasien');
            $table->foreign('id_pasien')->references('id')->on('pasien')->onDelete('cascade');

            $table->enum('jauh', ['Buram', 'Berbayang', 'Jelas']);
            $table->enum('dekat', ['Buram', 'Berbayang', 'Jelas']);
            $table->enum('gen', ['Pengguna Kacamata', 'Tidak']);
            $table->enum('riwayat', ['Hipertensi', 'Diabetes', 'Vertigo']);
            $table->text('lainnya')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anamnesas');
    }
};
