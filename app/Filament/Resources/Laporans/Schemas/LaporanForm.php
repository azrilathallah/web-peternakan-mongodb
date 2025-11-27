<?php

namespace App\Filament\Resources\Laporans\Schemas;

use App\Models\Kandang;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Fieldset as ComponentsFieldset;
use Filament\Schemas\Schema;

class LaporanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ComponentsFieldset::make('Pengaturan Laporan')
                    ->schema([
                        Select::make('jenis_laporan')
                            ->options([
                                'harian' => 'Laporan Harian',
                                'mingguan' => 'Laporan Mingguan',
                                'bulanan' => 'Laporan Bulanan',
                            ])
                            ->required()
                            ->reactive(),

                        DatePicker::make('tanggal')
                            ->label('Tanggal Laporan')
                            ->required()
                            ->visible(fn($get) => $get('jenis_laporan') === 'harian')
                            ->default(now()),

                        DatePicker::make('minggu')
                            ->label('Tanggal Awal Minggu')
                            ->required()
                            ->visible(fn($get) => $get('jenis_laporan') === 'mingguan')
                            ->default(now()),

                        Select::make('bulan')
                            ->options([
                                '1' => 'Januari',
                                '2' => 'Februari',
                                '3' => 'Maret',
                                '4' => 'April',
                                '5' => 'Mei',
                                '6' => 'Juni',
                                '7' => 'Juli',
                                '8' => 'Agustus',
                                '9' => 'September',
                                '10' => 'Oktober',
                                '11' => 'November',
                                '12' => 'Desember',
                            ])
                            ->required()
                            ->visible(fn($get) => $get('jenis_laporan') === 'bulanan')
                            ->default(now()->month),

                        CheckboxList::make('kandang')
                            ->options(
                                Kandang::all()
                                    ->pluck('lokasi', '_id')
                                    ->mapWithKeys(fn($value, $key) => [(string) $key => $value])
                            )
                            ->columns(2)
                            ->label('Pilih Kandang (kosongkan untuk semua)'),
                    ])
            ]);
    }
}
