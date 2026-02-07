<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;
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
