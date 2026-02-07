<?php

namespace App\Filament\Resources\ProduksiTelurs\Pages;

use App\Filament\Resources\ProduksiTelurs\ProduksiTelurResource;
use App\Traits\MeasuresPerformance;
use Filament\Resources\Pages\CreateRecord;

class CreateProduksiTelur extends CreateRecord
{
    use MeasuresPerformance;

    protected static string $resource = ProduksiTelurResource::class;

    public function getTitle(): string
    {
        return 'Tambah Data Produksi Telur';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->startPerformanceMeasurement();
        return $data;
    }

    protected function afterCreate(): void
    {
        $result = $this->endPerformanceMeasurement('CREATE', 'ProduksiTelur');
        // $this->showPerformanceNotification($result);
    }
}
