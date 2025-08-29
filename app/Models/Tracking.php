<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{

    protected $table = 'tracking';

    protected $fillable = [
        'invoice_id',
        'bisnes_id',
        'kurier',
        'nama_penerima',
        'alamat',
        'poskod',
        'no_tel',
        'kandungan_parcel',
        'jenis_parcel',
        'berat',
        'panjang',
        'lebar',
        'tinggi',
    ];

    public function bisnes()
    {
        return $this->belongsTo(Bisnes::class, 'bisnes_id');
    }
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
