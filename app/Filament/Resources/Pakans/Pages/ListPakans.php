<?php

namespace App\Filament\Resources\Pakans\Pages;

use App\Filament\Resources\Pakans\PakanResource;
use App\Traits\MeasuresPerformance;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Collection;

class ListPakans extends ListRecords
{
    use MeasuresPerformance;

    protected static string $resource = PakanResource::class;

    public function getTableRecords(): Collection
    {
        $this->startPerformanceMeasurement();

        $records = parent::getTableRecords();

        $result = $this->endPerformanceMeasurement('READ', 'Pakan');
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
