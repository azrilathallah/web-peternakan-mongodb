<?php

namespace Database\Seeders;

use App\Models\Kandang;
use App\Models\Pakan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Faker\Factory as Faker;

class PakanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil semua kandang (ObjectId)
        $kandangs = Kandang::all();

        if ($kandangs->count() < 2) {
            $this->command->error('Minimal harus ada 2 data kandang');
            return;
        }

        // Bersihkan data lama (opsional)
        // Pakan::truncate();

        $totalHari = 250; // 250 hari × 2 kandang = 500 data

        for ($i = 0; $i < $totalHari; $i++) {

            $tanggal = Carbon::today()->addDays($i);

            foreach ($kandangs as $kandang) {

                $pemberian = 1000;
                $sisa = $faker->numberBetween(200, 600);

                $jumlahPuyuh = $kandang->jumlah_puyuh ?? 1;

                $konsumsi = ($pemberian - $sisa) / $jumlahPuyuh;

                Pakan::create([
                    'tanggal'          => $tanggal,
                    'kandang_id'       => $kandang->_id,
                    'pemberian_pakan'  => $pemberian,
                    'sisa_pakan'       => $sisa,
                    'konsumsi_pakan'   => round($konsumsi, 3),
                ]);
            }
        }
    }
}
