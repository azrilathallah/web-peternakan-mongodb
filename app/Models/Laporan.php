<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Laporan extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'laporan';

    protected $fillable = [
        'periode',
        'data_laporan',
    ];

    protected $casts = [
        'data_laporan' => 'array',
    ];
}
