<?php

namespace App\Filament\Resources\ProduksiTelurs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProduksiTelursTable
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
                TextColumn::make('telur_ok')
                    ->label('Telur OK')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('telur_bs')
                    ->label('Telur BS')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_telur')
                    ->label('Total Telur')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('berat')
                    ->label('Berat (kg)')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('rata_rata')
                    ->label('Rata-rata')
                    ->sortable()
                    ->numeric(),
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
