<?php

namespace App\Filament\Resources\Mortalitas\Pages;

use App\Filament\Resources\Mortalitas\MortalitasResource;
use App\Traits\MeasuresPerformance;
use Filament\Resources\Pages\CreateRecord;

class CreateMortalitas extends CreateRecord
{
    use MeasuresPerformance;

    protected static string $resource = MortalitasResource::class;

    public function getTitle(): string
    {
        return 'Tambah Data Mortalitas';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->startPerformanceMeasurement();
        return $data;
    }

    protected function afterCreate(): void
    {
        $result = $this->endPerformanceMeasurement('CREATE', 'Mortalitas');
        // $this->showPerformanceNotification($result);
    }
}
