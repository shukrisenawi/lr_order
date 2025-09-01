<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TenagaPengajar;

class KitabPengajian extends Model
{
    protected $table = 'kitab_pengajian';

    protected $fillable = [
        'tenaga_pengajar_id',
        'gambar_kitab_rumi',
        'gambar_kitab_jawi',
        'nama_kitab',
        'link_kitab_rumi',
        'link_kitab_jawi',
        'catatan',
    ];

    public function tenagaPengajar()
    {
        return $this->belongsTo(TenagaPengajar::class);
    }

    public function pengajian()
    {
        return $this->hasMany(Pengajian::class, 'kitab_id');
    }
}
