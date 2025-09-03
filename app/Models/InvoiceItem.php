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
        'harga_seunit',
    ];

    protected $casts = [
        'kuantiti' => 'integer',
        'harga' => 'decimal:2',
        'harga_seunit' => 'decimal:2',
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

    // Mutator for kuantiti - auto calculate harga when quantity changes
    public function setKuantitiAttribute($value)
    {
        $this->attributes['kuantiti'] = $value;

        // Auto calculate harga if harga_seunit is set
        if (isset($this->attributes['harga_seunit']) && $this->attributes['harga_seunit'] > 0) {
            $this->attributes['harga'] = $value * $this->attributes['harga_seunit'];
        }
    }

    // Mutator for harga_seunit - auto calculate harga when unit price changes
    public function setHargaSeunitAttribute($value)
    {
        $this->attributes['harga_seunit'] = $value;

        // Auto calculate harga if kuantiti is set
        if (isset($this->attributes['kuantiti']) && $this->attributes['kuantiti'] > 0) {
            $this->attributes['harga'] = $this->attributes['kuantiti'] * $value;
        }
    }

    // Mutator for harga - auto calculate harga_seunit when total price changes
    public function setHargaAttribute($value)
    {
        $this->attributes['harga'] = $value;

        // Auto calculate harga_seunit if kuantiti is set and not zero
        if (isset($this->attributes['kuantiti']) && $this->attributes['kuantiti'] > 0) {
            $this->attributes['harga_seunit'] = $value / $this->attributes['kuantiti'];
        }
    }
}
