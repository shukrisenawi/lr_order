<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoice';

    public function getRouteKeyName()
    {
        return 'id';
    }

    protected $fillable = [
        'bisnes_id',
        'invoice_no',
        'nama_penerima',
        'alamat',
        'poskod',
        'no_tel',
        'jumlah',
        'status',
        'kurier',
        'catatan'
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {
            if (empty($invoice->invoice_no)) {
                $invoice->invoice_no = self::generateInvoiceNumber();
            }
        });
    }

    public static function generateInvoiceNumber()
    {
        $lastInvoice = self::orderBy('id', 'desc')->first();
        $nextNumber = $lastInvoice ? (int)substr($lastInvoice->invoice_no, 3) + 1 : 1;
        return 'INV' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }

    public function bisnes()
    {
        return $this->belongsTo(Bisnes::class, 'bisnes_id');
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    // Calculate total from items
    public function calculateTotal()
    {
        return $this->items->sum(function ($item) {
            return $item->kuantiti * $item->harga;
        });
    }

    // Update the jumlah field based on items
    public function updateTotal()
    {
        $this->jumlah = $this->calculateTotal();
        $this->save();
    }

    // Get formatted invoice number
    public function getFormattedInvoiceNoAttribute()
    {
        return $this->invoice_no;
    }
}
