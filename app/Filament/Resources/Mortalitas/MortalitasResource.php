<?php

namespace App\Filament\Resources\Mortalitas;

use App\Filament\Resources\Mortalitas\Pages\CreateMortalitas;
use App\Filament\Resources\Mortalitas\Pages\EditMortalitas;
use App\Filament\Resources\Mortalitas\Pages\ListMortalitas;
use App\Filament\Resources\Mortalitas\Schemas\MortalitasForm;
use App\Filament\Resources\Mortalitas\Tables\MortalitasTable;
use App\Models\Mortalitas;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MortalitasResource extends Resource
{
    protected static ?string $model = Mortalitas::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return MortalitasForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MortalitasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMortalitas::route('/'),
            'create' => CreateMortalitas::route('/create'),
            'edit' => EditMortalitas::route('/{record}/edit'),
        ];
    }
}
