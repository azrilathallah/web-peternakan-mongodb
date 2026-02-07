<?php

namespace App\Filament\Resources\Laporans\Pages;

use App\Filament\Resources\Laporans\LaporanResource;
use App\Traits\MeasuresPerformance;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLaporan extends EditRecord
{
    use MeasuresPerformance;

    protected static string $resource = LaporanResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->startPerformanceMeasurement();
        return $data;
    }

    protected function afterSave(): void
    {
        $result = $this->endPerformanceMeasurement('UPDATE', 'Laporan');
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
                    $result = $this->endPerformanceMeasurement('DELETE', 'Laporan');
                    // $this->showPerformanceNotification($result);
                }),
        ];
    }
}
