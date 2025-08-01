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
            
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');

            $table->string('od_sph')->nullable();
            $table->string('od_cyl')->nullable();
            $table->string('od_axis')->nullable();
            $table->string('od_add')->nullable();
            $table->string('od_prisma')->nullable();
            $table->string('od_base')->nullable();

            $table->string('os_sph')->nullable();
            $table->string('os_cyl')->nullable();
            $table->string('os_axis')->nullable();
            $table->string('os_add')->nullable();
            $table->string('os_prisma')->nullable();
            $table->string('os_base')->nullable();
            
            $table->string('binoculer_pd');
            $table->string('status_kacamata_lama');
            $table->string('keterangan_kacamata_lama')->nullable();
            
            $table->datetime('waktu_mulai');
            $table->datetime('waktu_selesai');
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
