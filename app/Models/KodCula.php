<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodCula extends Model
{
    use HasFactory;

    protected $table = 'kod_cula';

    protected $fillable = [
        'kod_cula',
        'nama_cula',
    ];


    /**
     * Get the display name attribute
     */
    public function getDisplayNameAttribute()
    {
        return $this->kod_cula . ' - ' . $this->nama_cula;
    }
}
