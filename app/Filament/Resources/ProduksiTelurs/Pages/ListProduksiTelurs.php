<?php

namespace App\Filament\Resources\ProduksiTelurs\Pages;

use App\Filament\Resources\ProduksiTelurs\ProduksiTelurResource;
use App\Traits\MeasuresPerformance;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Collection;

class ListProduksiTelurs extends ListRecords
{
    use MeasuresPerformance;

    protected static string $resource = ProduksiTelurResource::class;

    public function getTableRecords(): Collection
    {
        $this->startPerformanceMeasurement();

        $records = parent::getTableRecords();

        $result = $this->endPerformanceMeasurement('READ', 'ProduksiTelur');
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
