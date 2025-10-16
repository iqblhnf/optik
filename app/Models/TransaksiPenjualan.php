<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiPenjualan extends Model
{
    //
    protected $table = 'transaksi_penjualan';
    protected $fillable = [
        'id_pemeriksaan', 'id_pasien', 'user_id', 'tanggal', 'total', 'catatan'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien');
    }

    public function pemeriksaan()
    {
        return $this->belongsTo(Pemeriksaan::class, 'id_pemeriksaan');
    }

    public function detail()
    {
        return $this->hasMany(TransaksiPenjualanDetail::class, 'id_transaksi');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
