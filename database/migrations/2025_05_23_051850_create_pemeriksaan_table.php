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
        Schema::create('pemeriksaan', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('id_anamnesa');
            $table->foreign('id_anamnesa')->references('id')->on('anamnesa')->onDelete('cascade');

            $table->string('od_sph');
            $table->string('od_cyl');
            $table->string('od_axis');
            $table->string('od_add');
            $table->string('od_prisma');
            $table->string('od_base');

            $table->string('os_sph');
            $table->string('os_cyl');
            $table->string('os_axis');
            $table->string('os_add');
            $table->string('os_prisma');
            $table->string('os_base');
            
            $table->string('binoculer_pd');
            $table->enum('status_kacamata_lama', ['tidak dibawa', 'rusak', 'hilang', 'sudah tidak enak']);
            $table->string('keterangan_kacamata_lama');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaans');
    }
};
