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
        'catatan'
    ];


    public function bisnes()
    {
        return $this->belongsTo(Bisnes::class, 'bisnes_id');
    }
}
