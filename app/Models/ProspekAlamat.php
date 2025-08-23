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
        'nama_penerima',
        'alamat',
        'poskod',
        'no_tel',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function prospek()
    {
        return $this->belongsTo(Prospek::class, 'prospek_id');
    }

    public function purchases()
    {
        return $this->hasMany(ProspekBuy::class, 'prospek_alamat_id');
    }
}
