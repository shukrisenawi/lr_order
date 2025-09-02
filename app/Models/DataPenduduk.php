<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPenduduk extends Model
{
    protected $table = 'data_penduduk';

    protected $fillable = [
        'nama_dm',
        'kod_lokaliti',
        'nama_lokaliti',
        'no_rumah',
        'no_siri',
        'no_kp_baru',
        'no_kp_lama',
        'nama_pemilih',
        'tarikh_lahir',
        'jantina',
        'bangsa',
        'kod_cula',
        'catatan',
        'alamat_kp',
        'alamat_kediaman',
        'tel_rumah',
        'tel_bimbit',
    ];

    protected $casts = [
        'tarikh_lahir' => 'date',
    ];
}
