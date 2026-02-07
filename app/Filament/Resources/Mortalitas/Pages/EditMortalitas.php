<?php

namespace App\Filament\Resources\Mortalitas\Pages;

use App\Filament\Resources\Mortalitas\MortalitasResource;
use App\Traits\MeasuresPerformance;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMortalitas extends EditRecord
{
    use MeasuresPerformance;

    protected static string $resource = MortalitasResource::class;

    public function getTitle(): string
    {
        return 'Ubah Data Mortalitas';
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->startPerformanceMeasurement();
        return $data;
    }

    protected function afterSave(): void
    {
        $result = $this->endPerformanceMeasurement('UPDATE', 'Mortalitas');
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
                    $result = $this->endPerformanceMeasurement('DELETE', 'Mortalitas');
                    // $this->showPerformanceNotification($result);
                }),
        ];
    }
}
