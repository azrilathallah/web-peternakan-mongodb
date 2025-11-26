<?php

namespace App\Filament\Resources\Pakans;

use App\Filament\Resources\Pakans\Pages\CreatePakan;
use App\Filament\Resources\Pakans\Pages\EditPakan;
use App\Filament\Resources\Pakans\Pages\ListPakans;
use App\Filament\Resources\Pakans\Schemas\PakanForm;
use App\Filament\Resources\Pakans\Tables\PakansTable;
use App\Models\Pakan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PakanResource extends Resource
{
    protected static ?string $model = Pakan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return PakanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PakansTable::configure($table);
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
            'index' => ListPakans::route('/'),
            'create' => CreatePakan::route('/create'),
            'edit' => EditPakan::route('/{record}/edit'),
        ];
    }
}
