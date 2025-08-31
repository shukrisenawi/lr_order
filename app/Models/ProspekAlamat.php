<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProspekAlamat extends Model
{
    use HasFactory;

    protected $table = 'prospek_alamat';

    protected $fillable = [
        'prospek_id',
        'nama',
        'alamat',
        // Add other fields as needed
    ];

    public function prospek()
    {
        return $this->belongsTo(Prospek::class, 'prospek_id');
    }

    public function prospekBuy()
    {
        return $this->hasMany(ProspekBuy::class, 'prospek_alamat_id');
    }
}