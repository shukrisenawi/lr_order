<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gambar extends Model
{
    use HasFactory;

    protected $table = 'gambar';

    protected $fillable = [
        'bisnes_id',
        'nama',
        'path',
    ];

    public function produk()
    {
        return $this->hasOne(Produk::class, 'gambar_id');
    }
}
