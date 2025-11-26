<?php

namespace App\Filament\Resources\Mortalitas\Pages;

use App\Filament\Resources\Mortalitas\MortalitasResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMortalitas extends CreateRecord
{
    protected static string $resource = MortalitasResource::class;

    public function getTitle(): string
    {
        return 'Tambah Data Mortalitas';
    }
}
