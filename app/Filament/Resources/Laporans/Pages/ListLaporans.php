<?php

namespace App\Filament\Resources\Laporans\Pages;

use App\Filament\Resources\Laporans\LaporanResource;
use App\Traits\MeasuresPerformance;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Collection;

class ListLaporans extends ListRecords
{
    use MeasuresPerformance;

    protected static string $resource = LaporanResource::class;

    public function getTableRecords(): Collection
    {
        $this->startPerformanceMeasurement();

        $records = parent::getTableRecords();

        $result = $this->endPerformanceMeasurement('READ', 'Laporan');
        // $this->showPerformanceNotification($result);

        return $records;
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Buat Laporan Baru'),
        ];
    }
}
