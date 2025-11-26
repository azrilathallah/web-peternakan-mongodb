<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Kandang extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'kandang';

    protected $fillable = ['lokasi', 'kapasitas', 'jumlah_puyuh'];
}
