<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom od_add & os_add pada table pasien
     */
    public function up(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->string('od_add', 10)->nullable()->after('od_base'); // setelah od_base
            $table->string('os_add', 10)->nullable()->after('os_base'); // setelah os_base
        });
    }

    /**
     * Rollback jika dibutuhkan
     */
    public function down(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->dropColumn(['od_add', 'os_add']);
        });
    }
};
