<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bisnes extends Model
{
    use HasFactory;

    protected $table = 'bisnes';

    public function getRouteKeyName()
    {
        return 'id';
    }

    protected $fillable = [
        'user_id',
        'nama_bisnes',
        'type_id',
        'exp_date',
        'nama_syarikat',
        'no_pendaftaran',
        'on',
        'gambar',
        'alamat',
        'poskod',
        'no_tel',
        'system_message',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prospeks()
    {
        return $this->hasMany(Prospek::class, 'bisnes_id');
    }

    public function bisnesType()
    {
        return $this->hasOne(BisnesType::class, 'type_id');
    }
}
