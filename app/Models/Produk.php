<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'nama',
        'bisnes_id',
        'harga',
        'stok',
        'gambar_id',
        'info',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'stok' => 'integer',
    ];

    public function gambar()
    {
        return $this->belongsTo(Gambar::class, 'gambar_id');
    }


    public function bisnes()
    {
        return $this->belongsTo(Bisnes::class, 'bisnes_id');
    }
}
