<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_optik')->nullable();
            $table->string('alamat_optik')->nullable();
            $table->string('logo')->nullable();       // simpan nama file logo
            $table->string('background')->nullable(); // simpan file bg login
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
