<?php

namespace App\Filament\Resources\ProduksiTelurs\Schemas;

use App\Models\Kandang;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProduksiTelurForm
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
                TextInput::make('telur_ok')
                    ->label('Telur OK')
                    ->numeric()
                    ->required(),
                TextInput::make('telur_bs')
                    ->label('Telur BS')
                    ->numeric()
                    ->required(),
                TextInput::make('berat')
                    ->label('Berat (kg)')
                    ->numeric()
                    ->required(),
            ]);
    }
}
