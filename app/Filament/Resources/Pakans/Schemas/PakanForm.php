<?php

namespace App\Filament\Resources\Pakans\Schemas;

use App\Models\Kandang;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PakanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('kandang_id')
                    ->label('Kandang')
                    ->options(Kandang::all()->pluck('lokasi', '_id'))
                    ->required(),
                DatePicker::make('tanggal')
                    ->required(),
                TextInput::make('pemberian_pakan')
                    ->label('Pemberian Pakan (gr)')
                    ->required()
                    ->numeric(),
                TextInput::make('sisa_pakan')
                    ->label('Sisa Pakan (gr)')
                    ->required()
                    ->numeric(),
            ]);
    }
}
