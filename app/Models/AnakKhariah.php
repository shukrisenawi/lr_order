<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnakKhariah extends Model
{
    use HasFactory;

    protected $table = 'anak_khariah';

    protected $fillable = [
        'nama',
        'gelaran',
        'alamat',
        'tarikh_lahir',
        'no_tel',
        'gambar',
        'bisnes_id',
        'on',
    ];

    protected $casts = [
        'tarikh_lahir' => 'date',
        'on' => 'boolean',
    ];

    public function bisnes()
    {
        return $this->belongsTo(Bisnes::class, 'bisnes_id');
    }

    public function kumpulans()
    {
        return $this->belongsToMany(Kumpulan::class, 'anak_khariah_kumpulan');
    }
}
