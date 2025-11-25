<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class ProduksiTelur extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'produksi_telur';

    protected $fillable = [
        'tanggal',
        'telur_ok',
        'telur_bs',
        'total_telur',
        'berat',
        'rata_rata',
        'kandang_id',
    ];
}
