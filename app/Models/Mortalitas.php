<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Mortalitas extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'mortalitas';

    protected $fillable = ['tanggal', 'jumlah_mati', 'penyebab', 'kandang_id'];

    public function kandang()
    {
        return $this->belongsTo(Kandang::class, 'kandang_id', '_id');
    }

    protected static function booted()
    {
        static::created(function ($mortalitas) {
            $kandang = Kandang::find($mortalitas->kandang_id);

            if ($kandang) {
                $kandang->jumlah_puyuh = max(0, $kandang->jumlah_puyuh - $mortalitas->jumlah_mati);
                $kandang->save();
            }
        });

        static::updated(function ($mortalitas) {
            $kandang = Kandang::find($mortalitas->kandang_id);

            if ($kandang) {
                $difference = $mortalitas->jumlah_mati - $mortalitas->getOriginal('jumlah_mati');

                $kandang->jumlah_puyuh = max(0, $kandang->jumlah_puyuh - $difference);
                $kandang->save();
            }
        });

        static::deleted(function ($mortalitas) {
            $kandang = Kandang::find($mortalitas->kandang_id);

            if ($kandang) {
                $kandang->jumlah_puyuh += $mortalitas->jumlah_mati;
                $kandang->save();
            }
        });
    }
}
