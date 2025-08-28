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
        'session_id',
        'gelaran',
        'status',
        'on',
        'bisnes_id',
    ];

    public function bisnes()
    {
        return $this->belongsTo(Bisnes::class, 'bisnes_id');
    }
}
