<?php

namespace App\Filament\Resources\Kandangs\Pages;

use App\Filament\Resources\Kandangs\KandangResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKandang extends EditRecord
{
    protected static string $resource = KandangResource::class;

    public function getTitle(): string
    {
        return 'Ubah Data Kandang';
    }
}
