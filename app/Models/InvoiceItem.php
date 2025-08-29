<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $table = 'invoice_item';

    protected $fillable = [
        'invoice_id',
        'produk_id',
        'produk_custom',
        'kuantiti',
        'harga',
    ];

    protected $casts = [
        'kuantiti' => 'integer',
        'harga' => 'decimal:2',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    // Calculate total for this item
    public function getTotalAttribute()
    {
        return $this->kuantiti * $this->harga;
    }

    // Get product name (either from produk or custom)
    public function getProductNameAttribute()
    {
        if ($this->produk_custom) {
            return $this->produk_custom;
        }

        return $this->produk ? $this->produk->nama : 'Unknown Product';
    }
}
