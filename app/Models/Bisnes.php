<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bisnes extends Model
{
    use HasFactory;

    protected $table = 'bisnes';

    protected $fillable = [
        'user_id',
        'nama_bines',
        'exp_date',
        'nama_syarikat',
        'no_pendaftaran',
        'jenis_bisnes',
        'gambar',
        'alamat',
        'poskod',
        'no_tel',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prospeks()
    {
        return $this->hasMany(Prospek::class, 'bisnes_id');
    }
}
