<?php

namespace App\Filament\Resources\Pakans\Pages;

use App\Filament\Resources\Pakans\PakanResource;
use App\Traits\MeasuresPerformance;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPakan extends EditRecord
{
    use MeasuresPerformance;

    protected static string $resource = PakanResource::class;

    public function getTitle(): string
    {
        return 'Ubah Data Pakan';
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->startPerformanceMeasurement();
        return $data;
    }

    protected function afterSave(): void
    {
        $result = $this->endPerformanceMeasurement('UPDATE', 'Pakan');
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
                    $result = $this->endPerformanceMeasurement('DELETE', 'Pakan');
                    // $this->showPerformanceNotification($result);
                }),
        ];
    }
}
