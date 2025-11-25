<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Mortalitas extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'mortalitas';

    protected $fillable = [
        'tanggal',
        'jumlah_mati',
        'penyebab',
        'kandang_id',
    ];
}
