<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenagaPengajar extends Model
{
    protected $fillable = [
        'gambar',
        'nama',
        'no_tel',
        'alamat',
        'status',
    ];

    public function kitabPengajian()
    {
        return $this->hasMany(KitabPengajian::class);
    }

    public function pengajian()
    {
        return $this->hasMany(Pengajian::class, 'pengajar_id');
    }
}
