<?php

namespace App\Filament\Resources\Kandangs\Pages;

use App\Filament\Resources\Kandangs\KandangResource;
use App\Traits\MeasuresPerformance;
use Filament\Resources\Pages\CreateRecord;

class CreateKandang extends CreateRecord
{
    use MeasuresPerformance;

    protected static string $resource = KandangResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->startPerformanceMeasurement();
        return $data;
    }

    protected function afterCreate(): void
    {
        $result = $this->endPerformanceMeasurement('CREATE', 'Kandang');
        // $this->showPerformanceNotification($result);
    }
}
