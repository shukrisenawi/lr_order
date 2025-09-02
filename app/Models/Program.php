<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'program';

    protected $fillable = [
        'gambar_banner',
        'tajuk',
        'keterangan',
        'tarikh_masa_program',
    ];

    protected $casts = [
        'tarikh_masa_program' => 'datetime',
    ];
}
