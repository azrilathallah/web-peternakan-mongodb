<?php

namespace App\Filament\Resources\Kandangs\Pages;

use App\Filament\Resources\Kandangs\KandangResource;
use App\Traits\MeasuresPerformance;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Collection;

class ListKandangs extends ListRecords
{
    use MeasuresPerformance;

    protected static string $resource = KandangResource::class;

    public function getTableRecords(): Collection
    {
        $this->startPerformanceMeasurement();

        $records = parent::getTableRecords();

        $result = $this->endPerformanceMeasurement('READ', 'Kandang');
        // $this->showPerformanceNotification($result);

        return $records;
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
