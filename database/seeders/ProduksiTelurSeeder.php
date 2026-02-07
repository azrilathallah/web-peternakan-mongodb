<?php

namespace Database\Seeders;

use App\Models\Kandang;
use App\Models\ProduksiTelur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Faker\Factory as Faker;

class ProduksiTelurSeeder extends Seeder
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

        $totalHari = 250; // 250 hari × 2 kandang = 500 data

        for ($i = 0; $i < $totalHari; $i++) {

            $tanggal = Carbon::today()->addDays($i);

            foreach ($kandangs as $kandang) {

                $telurOk = $faker->numberBetween(2000, 4000);
                $telurBs = $faker->numberBetween(50, 250);
                $berat = $faker->randomFloat(2, 20, 70);

                ProduksiTelur::create([
                    'tanggal'          => $tanggal,
                    'kandang_id'       => $kandang->_id,
                    'telur_ok'         => $telurOk,
                    'telur_bs'         => $telurBs,
                    'berat'            => $berat,
                ]);
            }
        }
    }
}
