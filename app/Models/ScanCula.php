<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScanCula extends Model
{
    protected $table = 'scan_cula';

    protected $fillable = [
        'no_kp',
        'nama_pemilih',
        'alamat',
        'cula',
        'approve'
    ];

    protected $casts = [
        'approve' => 'boolean',
    ];
}
