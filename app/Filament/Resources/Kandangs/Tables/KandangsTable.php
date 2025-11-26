<?php

namespace App\Filament\Resources\Kandangs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KandangsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('lokasi')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Kandang Atas' => 'success',
                        'Kandang Bawah' => 'info',
                    })
                    ->sortable(),
                TextColumn::make('kapasitas')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('jumlah_puyuh')
                    ->label('Jumlah Puyuh')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([]),
            ]);
    }
}
