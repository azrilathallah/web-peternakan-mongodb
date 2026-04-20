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
                'kapasitas' => 6000,
                'jumlah_puyuh' => 5851,
            ]);

            Kandang::create([
                'lokasi' => 'Kandang Bawah',
                'kapasitas' => 6000,
                'jumlah_puyuh' => 5642,
            ]);
        }
    }
}
