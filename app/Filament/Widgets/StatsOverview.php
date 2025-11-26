<?php

namespace App\Filament\Widgets;

use App\Models\Kandang;
use App\Models\Mortalitas;
use App\Models\Pakan;
use App\Models\ProduksiTelur;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $today = Carbon::today()->toDateString();
        $yesterday = Carbon::yesterday()->toDateString();
        $weekStart = Carbon::now()->startOfWeek()->toDateString();
        $monthStart = Carbon::now()->startOfMonth()->toDateString();

        // Data Kandang
        $totalPuyuh = Kandang::sum('jumlah_puyuh');
        $totalKandang = Kandang::count();

        // Data Produksi Telur
        $produksiHari = ProduksiTelur::where('tanggal', $today)->sum('total_telur');
        $produksiKemarin = ProduksiTelur::where('tanggal', $yesterday)->sum('total_telur');
        $produksiMinggu = ProduksiTelur::where('tanggal', '>=', $weekStart)->sum('total_telur');
        $produksiBulan = ProduksiTelur::where('tanggal', '>=', $monthStart)->sum('total_telur');

        // Persentase perubahan produksi harian
        $persentaseProduksi = $produksiKemarin > 0
            ? (($produksiHari - $produksiKemarin) / $produksiKemarin) * 100
            : 0;

        // Data Mortalitas
        $matiHari = Mortalitas::where('tanggal', $today)->sum('jumlah_mati');
        $matiKemarin = Mortalitas::where('tanggal', $yesterday)->sum('jumlah_mati');
        $matiMinggu = Mortalitas::where('tanggal', '>=', $weekStart)->sum('jumlah_mati');
        $matiBulan = Mortalitas::where('tanggal', '>=', $monthStart)->sum('jumlah_mati');

        // Rasio mortalitas harian
        $rasioMortalitasHari = $totalPuyuh > 0 ? ($matiHari / $totalPuyuh) * 100 : 0;

        // Data Pakan
        $pakanHari = Pakan::where('tanggal', $today)->sum('konsumsi_pakan');
        $pakanKemarin = Pakan::where('tanggal', $yesterday)->sum('konsumsi_pakan');
        $pakanMinggu = Pakan::where('tanggal', '>=', $weekStart)->sum('konsumsi_pakan');
        $pakanBulan = Pakan::where('tanggal', '>=', $monthStart)->sum('konsumsi_pakan');

        // Konsumsi pakan per ekor
        $pakanPerEkor = $totalPuyuh > 0 ? $pakanHari / $totalPuyuh : 0;

        return [
            Stat::make('Total Populasi', Number::format($totalPuyuh))
                ->description("{$totalKandang} kandang aktif")
                ->descriptionIcon('heroicon-o-users')
                ->color('warning')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),

            Stat::make('Produksi Telur Hari Ini', Number::format($produksiHari))
                ->description(
                    $persentaseProduksi >= 0
                        ? "↑ " . Number::format($persentaseProduksi, 1) . "% dari kemarin"
                        : "↓ " . Number::format(abs($persentaseProduksi), 1) . "% dari kemarin"
                )
                ->descriptionIcon($persentaseProduksi >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($persentaseProduksi >= 0 ? 'success' : 'danger')
                ->chart($this->getWeeklyProduksiTelurData())
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),

            Stat::make('Mortalitas Hari Ini', Number::format($matiHari))
                ->description(Number::format($rasioMortalitasHari, 3) . "% dari total populasi")
                ->descriptionIcon($rasioMortalitasHari > 0.1 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-shield-check')
                ->color($rasioMortalitasHari > 0.1 ? 'danger' : 'gray')
                ->chart($this->getWeeklyMortalitasData())
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),

            Stat::make('Konsumsi Pakan Hari Ini', Number::format($pakanHari, 3) . ' gr')
                ->description(Number::format($pakanPerEkor, 4) . ' gr/ekor ')
                ->descriptionIcon('heroicon-o-cube')
                ->color('info')
                ->chart($this->getWeeklyPakanData())
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),
        ];
    }

    private function getWeeklyProduksiTelurData(): array
    {
        $start = Carbon::now()->subDays(7)->toDateString();

        $result = ProduksiTelur::raw(function ($collection) use ($start) {
            return $collection->aggregate([
                ['$match' => ['tanggal' => ['$gte' => $start]]],
                ['$group' => [
                    '_id' => '$tanggal',
                    'total' => ['$sum' => '$total_telur']
                ]],
                ['$sort' => ['_id' => 1]],
            ]);
        });

        return collect($result)->pluck('total')->toArray();
    }

    private function getWeeklyMortalitasData(): array
    {
        $start = Carbon::now()->subDays(7)->toDateString();

        $result = Mortalitas::raw(function ($collection) use ($start) {
            return $collection->aggregate([
                ['$match' => ['tanggal' => ['$gte' => $start]]],
                ['$group' => [
                    '_id' => '$tanggal',
                    'total' => ['$sum' => '$jumlah_mati']
                ]],
                ['$sort' => ['_id' => 1]],
            ]);
        });

        return collect($result)->pluck('total')->toArray();
    }

    private function getWeeklyPakanData(): array
    {
        $start = Carbon::now()->subDays(7)->toDateString();

        $result = Pakan::raw(function ($collection) use ($start) {
            return $collection->aggregate([
                ['$match' => ['tanggal' => ['$gte' => $start]]],
                ['$group' => [
                    '_id' => '$tanggal',
                    'total' => ['$sum' => '$konsumsi_pakan']
                ]],
                ['$sort' => ['_id' => 1]],
            ]);
        });

        return collect($result)->pluck('total')->toArray();
    }
}
