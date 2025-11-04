<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';

    protected $guarded = [];

    // public function anamnesas()
    // {
    //     return $this->hasMany(Anamnesa::class, 'id_pasien');
    // }

    public function anamnesa()
    {
        return $this->hasOne(Anamnesa::class, 'id_pasien');  // (foreign key, local key)
    }


    public function pemeriksaans()
    {
        return $this->hasManyThrough(
            Pemeriksaan::class,
            Anamnesa::class,
            'id_pasien',    // FK di Anamnesa
            'id_anamnesa',  // FK di Pemeriksaan
            'id',           // PK di Pasien
            'id'            // PK di Anamnesa
        );
    }
}
