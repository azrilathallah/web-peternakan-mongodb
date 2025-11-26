<?php

namespace App\Filament\Resources\ProduksiTelurs\Pages;

use App\Filament\Resources\ProduksiTelurs\ProduksiTelurResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduksiTelur extends CreateRecord
{
    protected static string $resource = ProduksiTelurResource::class;

    public function getTitle(): string
    {
        return 'Tambah Data Produksi Telur';
    }
}
