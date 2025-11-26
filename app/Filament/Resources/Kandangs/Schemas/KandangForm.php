<?php

namespace App\Filament\Resources\Kandangs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KandangForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kapasitas')
                    ->required()
                    ->numeric(),
                TextInput::make('jumlah_puyuh')
                    ->required()
                    ->numeric(),
            ]);
    }
}
