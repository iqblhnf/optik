<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Anamnesa extends Model
{
    use HasFactory;

    protected $table = 'anamnesa';

    protected $fillable = [
        'id_pasien',
        'jauh',
        'dekat',
        'gen',
        'riwayat',
        'lainnya'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien');
    }

    public function pemeriksaan()
    {
        return $this->hasOne(Pemeriksaan::class, 'id_anamnesa');
    }
}
