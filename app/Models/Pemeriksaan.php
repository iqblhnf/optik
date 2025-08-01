<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemeriksaan extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan';

    protected $fillable = [
        'id_anamnesa',
        'id_user',
        'od_sph',
        'od_cyl',
        'od_axis',
        'od_add',
        'od_prisma',
        'od_base',
        'os_sph',
        'os_cyl',
        'os_axis',
        'os_add',
        'os_prisma',
        'os_base',
        'binoculer_pd',
        'status_kacamata_lama',
        'keterangan_kacamata_lama',
        'waktu_mulai',
        'waktu_selesai'
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];


    public function anamnesa()
    {
        return $this->belongsTo(Anamnesa::class, 'id_anamnesa');
    }

    public function pasien()
    {
        // Bisa akses langsung ke pasien lewat relasi ke anamnesa
        return $this->hasOneThrough(
            Pasien::class,
            Anamnesa::class,
            'id',           // PK Anamnesa
            'id',           // PK Pasien
            'id_anamnesa',  // FK Pemeriksaan ke Anamnesa
            'id_pasien'     // FK Anamnesa ke Pasien
        );
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
