<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pemeriksaan', function (Blueprint $table) {

            // OD Petugas
            $table->string('pt_od_sph')->nullable()->after('os_base');
            $table->string('pt_od_cyl')->nullable();
            $table->string('pt_od_axis')->nullable();
            $table->string('pt_od_prisma')->nullable();
            $table->string('pt_od_base')->nullable();
            $table->string('pt_od_add')->nullable();

            // OS Petugas
            $table->string('pt_os_sph')->nullable();
            $table->string('pt_os_cyl')->nullable();
            $table->string('pt_os_axis')->nullable();
            $table->string('pt_os_prisma')->nullable();
            $table->string('pt_os_base')->nullable();
            $table->string('pt_os_add')->nullable();
        });
    }

    public function down()
    {
        Schema::table('pemeriksaan', function (Blueprint $table) {
            $table->dropColumn([
                'pt_od_sph', 'pt_od_cyl', 'pt_od_axis', 'pt_od_prisma', 'pt_od_base', 'pt_od_add',
                'pt_os_sph', 'pt_os_cyl', 'pt_os_axis', 'pt_os_prisma', 'pt_os_base', 'pt_os_add',
            ]);
        });
    }
};
