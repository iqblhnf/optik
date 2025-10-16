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
        // Tambah harga ke tabel barangs
        Schema::table('barangs', function (Blueprint $table) {
            if (!Schema::hasColumn('barangs', 'harga_beli')) {
                $table->decimal('harga_beli', 15, 2)->default(0)->after('stok');
                $table->decimal('harga_jual', 15, 2)->default(0)->after('harga_beli');
            }
        });

        // Header transaksi penjualan
        Schema::create('transaksi_penjualan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pemeriksaan')->constrained('pemeriksaan')->onDelete('cascade');
            $table->foreignId('id_pasien')->constrained('pasien')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal');
            $table->decimal('total', 15, 2)->default(0);
            $table->string('catatan')->nullable();
            $table->timestamps();
        });

        // Detail item transaksi
        Schema::create('transaksi_penjualan_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_transaksi')->constrained('transaksi_penjualan')->onDelete('cascade');
            $table->unsignedBigInteger('barang_id')->nullable(); // null kalau jasa
            $table->string('nama_item');
            $table->enum('tipe', ['barang', 'jasa']);
            $table->integer('jumlah')->default(1);
            $table->decimal('harga', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_penjualan_detail');
        Schema::dropIfExists('transaksi_penjualan');

        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn(['harga_beli', 'harga_jual']);
        });
    }
};
