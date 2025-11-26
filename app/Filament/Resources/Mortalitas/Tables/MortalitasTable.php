<?php

namespace App\Filament\Resources\Mortalitas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MortalitasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kandang.lokasi')
                    ->label('Kandang')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Kandang Atas' => 'success',
                        'Kandang Bawah' => 'info',
                    })
                    ->sortable(),
                TextColumn::make('tanggal')
                    ->dateTime('d/m/Y')
                    ->sortable(),
                TextColumn::make('jumlah_mati')
                    ->label('Jumlah Mati')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('penyebab')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
