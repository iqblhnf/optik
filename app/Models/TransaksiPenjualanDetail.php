<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiPenjualanDetail extends Model
{
    //
    protected $table = 'transaksi_penjualan_detail';
    protected $fillable = [
        'id_transaksi', 'barang_id', 'nama_item', 'tipe', 'jumlah', 'harga', 'subtotal'
    ];

    public function transaksi()
    {
        return $this->belongsTo(TransaksiPenjualan::class, 'id_transaksi');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
