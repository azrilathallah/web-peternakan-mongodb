<?php

namespace App\Filament\Resources\Mortalitas\Pages;

use App\Filament\Resources\Mortalitas\MortalitasResource;
use App\Traits\MeasuresPerformance;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Collection;

class ListMortalitas extends ListRecords
{
    use MeasuresPerformance;

    protected static string $resource = MortalitasResource::class;

    public function getTableRecords(): Collection
    {
        $this->startPerformanceMeasurement();

        $records = parent::getTableRecords();

        $result = $this->endPerformanceMeasurement('READ', 'Mortalitas');
        // $this->showPerformanceNotification($result);

        return $records;
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Data'),
        ];
    }
}
