<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAlamat extends Model
{
    use HasFactory;

    protected $table = 'customer_alamat';

    protected $fillable = [
        'customer_id',
        'nama_penerima',
        'alamat',
        'bandar',
        'negeri',
        'poskod',
        'no_tel',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function purchases()
    {
        return $this->hasMany(CustomerBuy::class, 'customer_alamat_id');
    }
}
