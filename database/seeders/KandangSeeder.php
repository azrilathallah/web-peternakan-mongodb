<?php

namespace Database\Seeders;

use App\Models\Kandang;
use Illuminate\Database\Seeder;

class KandangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Kandang::count() == 0) {
            Kandang::create([
                'lokasi' => 'Kandang Atas',
                'kapasitas' => 0,
                'jumlah_puyuh' => 0,
            ]);

            Kandang::create([
                'lokasi' => 'Kandang Bawah',
                'kapasitas' => 0,
                'jumlah_puyuh' => 0,
            ]);
        }
    }
}
