<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';

    public function getRouteKeyName()
    {
        return 'id';
    }

    protected $fillable = [
        'nama',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function bisnes()
    {
        return $this->belongsTo(Bisnes::class, 'bisnes_id');
    }

    public function alamat()
    {
        return $this->hasMany(CustomerAlamat::class, 'customer_id');
    }

    public function purchases()
    {
        return $this->hasManyThrough(CustomerBuy::class, CustomerAlamat::class, 'customer_id', 'customer_alamat_id');
    }
}
