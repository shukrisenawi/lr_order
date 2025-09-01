<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajian extends Model
{
    protected $table = 'pengajian';

    protected $fillable = [
        'hari',
        'minggu',
        'masa',
        'pengajar_id',
        'kitab_id',
        'tempat',
    ];

    public function tenagaPengajar()
    {
        return $this->belongsTo(TenagaPengajar::class, 'pengajar_id');
    }

    public function kitabPengajian()
    {
        return $this->belongsTo(KitabPengajian::class, 'kitab_id');
    }
}
