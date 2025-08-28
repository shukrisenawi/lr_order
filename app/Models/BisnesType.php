<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BisnesType extends Model
{
    use HasFactory;

    protected $table = 'bisnes_type';

    public function getRouteKeyName()
    {
        return 'id';
    }

    protected $fillable = [
        'type'
    ];
}
