<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kumpulan extends Model
{
    use HasFactory;

    protected $table = 'kumpulan';

    protected $fillable = [
        'nama',
        'description',
        'bisnes_id',
        'on',
    ];

    protected $casts = [
        'on' => 'boolean',
    ];

    public function bisnes()
    {
        return $this->belongsTo(Bisnes::class, 'bisnes_id');
    }

    public function anakKhariahs()
    {
        return $this->hasMany(AnakKhariah::class, 'kumpulan_id');
    }
}
