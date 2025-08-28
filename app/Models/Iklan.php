<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iklan extends Model
{
    use HasFactory;

    protected $table = 'Iklan';

    protected $fillable = [
        'bisnes_id',
        'nama_iklan',
        'keterangan',
        'hari',
        'on'
    ];


    public function bisnes()
    {
        return $this->belongsTo(Bisnes::class, 'bisnes_id');
    }
}
