<?php

namespace App\Filament\Resources\Pakans\Pages;

use App\Filament\Resources\Pakans\PakanResource;
use App\Traits\MeasuresPerformance;
use Filament\Resources\Pages\CreateRecord;

class CreatePakan extends CreateRecord
{
    use MeasuresPerformance;

    protected static string $resource = PakanResource::class;

    public function getTitle(): string
    {
        return 'Tambah Data Pakan';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->startPerformanceMeasurement();
        return $data;
    }

    protected function afterCreate(): void
    {
        $result = $this->endPerformanceMeasurement('CREATE', 'Pakan');
        // $this->showPerformanceNotification($result);
    }
}
