<?php

namespace App\Filament\Resources\ProduksiTelurs;

use App\Filament\Resources\ProduksiTelurs\Pages\CreateProduksiTelur;
use App\Filament\Resources\ProduksiTelurs\Pages\EditProduksiTelur;
use App\Filament\Resources\ProduksiTelurs\Pages\ListProduksiTelurs;
use App\Filament\Resources\ProduksiTelurs\Schemas\ProduksiTelurForm;
use App\Filament\Resources\ProduksiTelurs\Tables\ProduksiTelursTable;
use App\Models\ProduksiTelur;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProduksiTelurResource extends Resource
{
    protected static ?string $model = ProduksiTelur::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ProduksiTelurForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProduksiTelursTable::configure($table);
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
            'index' => ListProduksiTelurs::route('/'),
            'create' => CreateProduksiTelur::route('/create'),
            'edit' => EditProduksiTelur::route('/{record}/edit'),
        ];
    }
}
