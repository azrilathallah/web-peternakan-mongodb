<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Pakan extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'pakan';

    protected $fillable = [
        'tanggal',
        'konsumsi_pakan',
        'pemberian_pakan',
        'sisa_pakan',
        'kandang_id',
    ];
}
