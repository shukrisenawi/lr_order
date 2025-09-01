<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaktuSolat extends Model
{
    protected $fillable = [
        'tarikh',
        'tarikh_hijrah',
        'hari',
        'imsak',
        'subuh',
        'syuruk',
        'zohor',
        'asar',
        'maghrib',
        'isyak',
    ];
}
