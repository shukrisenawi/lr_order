<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProspekBuy extends Model
{
    use HasFactory;

    protected $table = 'prospek_buy';

    protected $fillable = [
        'prospek_alamat_id',
        'harga',
        'user_id', // From logs, there was user_id column
        // Add other fields as needed
    ];

    public function prospekAlamat()
    {
        return $this->belongsTo(ProspekAlamat::class, 'prospek_alamat_id');
    }

    public function prospek()
    {
        return $this->hasOneThrough(Prospek::class, ProspekAlamat::class, 'id', 'id', 'prospek_alamat_id', 'prospek_id');
    }

}