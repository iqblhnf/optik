<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            // OD (Mata Kanan)
            $table->string('od_sph', 10)->nullable()->after('no_telp');
            $table->string('od_cyl', 10)->nullable()->after('od_sph');
            $table->string('od_axis', 10)->nullable()->after('od_cyl');
            $table->string('od_prisma', 10)->nullable()->after('od_axis');
            $table->string('od_base', 10)->nullable()->after('od_prisma');

            // OS (Mata Kiri)
            $table->string('os_sph', 10)->nullable()->after('od_base');
            $table->string('os_cyl', 10)->nullable()->after('os_sph');
            $table->string('os_axis', 10)->nullable()->after('os_cyl');
            $table->string('os_prisma', 10)->nullable()->after('os_axis');
            $table->string('os_base', 10)->nullable()->after('os_prisma');
        });
    }

    public function down(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->dropColumn([
                'od_sph', 'od_cyl', 'od_axis', 'od_prisma', 'od_base',
                'os_sph', 'os_cyl', 'os_axis', 'os_prisma', 'os_base',
            ]);
        });
    }
};
