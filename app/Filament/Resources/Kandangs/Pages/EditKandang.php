<?php

namespace App\Filament\Resources\Kandangs\Pages;

use App\Filament\Resources\Kandangs\KandangResource;
use App\Traits\MeasuresPerformance;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKandang extends EditRecord
{
    use MeasuresPerformance;

    protected static string $resource = KandangResource::class;

    public function getTitle(): string
    {
        return 'Ubah Data Kandang';
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->startPerformanceMeasurement();
        return $data;
    }

    protected function afterSave(): void
    {
        $result = $this->endPerformanceMeasurement('UPDATE', 'Kandang');
        // $this->showPerformanceNotification($result);
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->before(function () {
                    $this->startPerformanceMeasurement();
                })
                ->after(function () {
                    $result = $this->endPerformanceMeasurement('DELETE', 'Kandang');
                    // $this->showPerformanceNotification($result);
                }),
        ];
    }
}
