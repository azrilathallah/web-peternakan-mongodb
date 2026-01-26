<?php

namespace App\Filament\Widgets;

use App\Models\ProduksiTelur;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProduksiTelurChart extends ChartWidget
{
    protected ?string $heading = 'Produksi Telur 30 Hari Terakhir';
    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $startDate = Carbon::now()->subDays(30)->toDateString();

        $data = ProduksiTelur::raw(function ($collection) use ($startDate) {
            return $collection->aggregate([
                ['$match' => [
                    'tanggal' => ['$gte' => $startDate]
                ]],
                ['$group' => [
                    '_id' => '$tanggal',
                    'total_telur_harian' => ['$sum' => '$total_telur'],
                    'rata_rata_telur' => ['$avg' => '$total_telur'],
                ]],
                ['$sort' => ['_id' => 1]],
            ]);
        });

        $data = collect($data);

        return [
            'datasets' => [
                [
                    'label' => 'Produksi Harian',
                    'data' => $data->pluck('total_telur_harian'),
                    'borderWidth' => 2,
                    'borderColor' => 'rgb(34, 197, 94)',
                    'backgroundColor' => 'rgba(34, 197, 94, 0.3)',
                    'tension' => 0.4,
                    'fill' => true,
                ],
            ],
            'labels' => $data->pluck('_id')->map(function ($date) {
                return Carbon::parse($date)->format('d M');
            }),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => false,
                    'title' => [
                        'display' => true,
                        'text' => 'Jumlah Telur'
                    ],
                ],
                'x' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Tanggal'
                    ],
                ],
            ],
            'maintainAspectRatio' => false,
        ];
    }
}
