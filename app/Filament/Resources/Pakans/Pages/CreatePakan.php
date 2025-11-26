<?php

namespace App\Filament\Resources\Pakans\Pages;

use App\Filament\Resources\Pakans\PakanResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePakan extends CreateRecord
{
    protected static string $resource = PakanResource::class;

    public function getTitle(): string
    {
        return 'Tambah Data Pakan';
    }
}
