<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prospek extends Model
{
    use HasFactory;

    protected $table = 'prospek';

    protected $fillable = [
        'no_tel',
        'gelaran',
        'status',
        'bisnes_id',
    ];

    public function bisnes()
    {
        return $this->belongsTo(Bisnes::class, 'bisnes_id');
    }

    public function alamat()
    {
        return $this->hasMany(ProspekAlamat::class, 'prospek_id');
    }

    public function purchases()
    {
        return $this->hasManyThrough(ProspekBuy::class, ProspekAlamat::class, 'prospek_id', 'prospek_alamat_id');
    }
}
