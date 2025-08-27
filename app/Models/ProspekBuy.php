<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProspekBuy extends Model
{
    use HasFactory;

    protected $table = 'customer_buy';

    protected $fillable = [
        'customer_alamat_id',
        'produk_id',
        'kuantiti',
        'harga',
        'status',
    ];

    protected $casts = [
        'kuantiti' => 'integer',
        'harga' => 'decimal:2',
    ];

    public function prospekAlamat()
    {
        return $this->belongsTo(CustomerAlamat::class, 'customer_alamat_id');
    }

    public function prospek()
    {
        return $this->hasOneThrough(Customer::class, CustomerAlamat::class, 'id', 'id', 'customer_alamat_id', 'customer_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}