<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadualPengajian extends Model
{
    protected $fillable = [
        'hari',
        'minggu',
        'masa',
        'penceramah_program',
        'topik_kitab',
        'tempat',
    ];
}
