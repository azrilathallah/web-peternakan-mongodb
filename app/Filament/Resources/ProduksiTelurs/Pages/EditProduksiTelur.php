<?php

namespace App\Filament\Resources\ProduksiTelurs\Pages;

use App\Filament\Resources\ProduksiTelurs\ProduksiTelurResource;
use App\Traits\MeasuresPerformance;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProduksiTelur extends EditRecord
{
    use MeasuresPerformance;

    protected static string $resource = ProduksiTelurResource::class;

    public function getTitle(): string
    {
        return 'Ubah Data Produksi Telur';
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->startPerformanceMeasurement();
        return $data;
    }

    protected function afterSave(): void
    {
        $result = $this->endPerformanceMeasurement('UPDATE', 'ProduksiTelur');
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
                    $result = $this->endPerformanceMeasurement('DELETE', 'ProduksiTelur');
                    // $this->showPerformanceNotification($result);
                }),
        ];
    }
}
