<?php

namespace App\Filament\Resources\Laporans\Pages;

use App\Filament\Resources\Laporans\LaporanResource;
use App\Models\Kandang;
use App\Models\Mortalitas;
use App\Models\Pakan;
use App\Models\ProduksiTelur;
use App\Traits\MeasuresPerformance;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class CreateLaporan extends CreateRecord
{
    use MeasuresPerformance;

    protected static string $resource = LaporanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->startPerformanceMeasurement();

        // Generate data laporan
        $laporanData = $this->collectReportData($data);

        // Simpan data ke database
        return [
            'periode' => $data['jenis_laporan'],
            'data_laporan' => json_encode($laporanData),
        ];
    }

    protected function afterCreate(): void
    {
        // Generate PDF dan simpan ke storage sementara
        $data = $this->form->getState();
        $laporanData = $this->collectReportData($data);

        $pdf = Pdf::loadView('filament.pages.laporan', $laporanData)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

        $filename = 'Laporan_' . str_replace(' ', '_', $laporanData['periode']) . '_' . now()->format('Y-m-d_H-i') . '.pdf';

        // Simpan PDF ke storage sementara
        $path = 'temp/' . $filename;
        Storage::disk('public')->put($path, $pdf->output());

        // Generate URL untuk download
        $downloadUrl = Storage::url($path);

        // Tampilkan notifikasi dengan link download
        Notification::make()
            ->title('Laporan Berhasil Dibuat!')
            ->body('Laporan ' . $laporanData['periode'] . ' telah berhasil digenerate. Klik tombol dibawah untuk mendownload.')
            ->success()
            ->persistent()
            ->actions([
                Action::make('download')
                    ->button()
                    ->url($downloadUrl, shouldOpenInNewTab: true)
                    ->label('Download PDF'),
            ])
            ->send();

        // Log performance metrics
        $result = $this->endPerformanceMeasurement('CREATE', 'Laporan');
        // $this->showPerformanceNotification($result);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    private function collectReportData(array $filters): array
    {
        $dateRange = $this->getDateRange($filters);

        $data = [
            'periode' => $this->getPeriodeLabel($filters),
            'tanggal_cetak' => now()->format('d/m/Y H:i'),
            'filters' => $filters,
            'date_range' => $dateRange,
            'jenis_laporan' => $filters['jenis_laporan'],
        ];

        // Data Kandang
        $data['kandang'] = $this->getKandangData($filters['kandang'] ?? []);

        // Data Produksi Telur
        $data['produksi'] = $this->getProduksiData($dateRange, $filters['kandang'] ?? []);

        // Data Mortalitas
        $data['mortalitas'] = $this->getMortalitasData($dateRange, $filters['kandang'] ?? []);

        // Data Pakan
        $data['pakan'] = $this->getPakanData($dateRange, $filters['kandang'] ?? []);

        // Ringkasan Performa
        $data['ringkasan'] = $this->getRingkasanData($data);

        return $data;
    }

    private function getDateRange(array $filters): array
    {
        $jenis = $filters['jenis_laporan'];

        switch ($jenis) {
            case 'harian':
                $start = Carbon::parse($filters['tanggal']);
                $end = $start->copy();
                break;

            case 'mingguan':
                $start = Carbon::parse($filters['minggu'])->startOfWeek();
                $end = $start->copy()->endOfWeek();
                break;

            case 'bulanan':
                $tahun = $filters['tahun'] ?? now()->year;
                $bulan = $filters['bulan'] ?? now()->month;
                $start = Carbon::create($tahun, $bulan, 1);
                $end = $start->copy()->endOfMonth();
                break;

            default:
                $start = now();
                $end = now();
        }

        return [
            'start' => $start->format('Y-m-d'),
            'end' => $end->format('Y-m-d'),
            'start_formatted' => $start->translatedFormat('d F Y'),
            'end_formatted' => $end->translatedFormat('d F Y')
        ];
    }

    private function getPeriodeLabel(array $filters): string
    {
        switch ($filters['jenis_laporan']) {
            case 'harian':
                return Carbon::parse($filters['tanggal'])->translatedFormat('d F Y');
            case 'mingguan':
                $start = Carbon::parse($filters['minggu'])->startOfWeek();
                $end = $start->copy()->endOfWeek();
                return $start->translatedFormat('d M') . ' - ' . $end->translatedFormat('d M Y');
            case 'bulanan':
                $tahun = $filters['tahun'] ?? now()->year;
                $bulan = $filters['bulan'] ?? now()->month;
                return Carbon::create()->month($bulan)->translatedFormat('F') . ' ' . $tahun;
        }

        return '';
    }

    private function getKandangData(array $kandangFilter)
    {
        $query = Kandang::query();

        if (!empty($kandangFilter)) {
            $query->whereIn('_id', $kandangFilter);
        }

        return $query->get();
    }

    private function getProduksiData(array $dateRange, array $kandangFilter)
    {
        $query = ProduksiTelur::with('kandang')
            ->whereBetween('tanggal', [$dateRange['start'], $dateRange['end']]);

        if (!empty($kandangFilter)) {
            $query->whereIn('kandang_id', $kandangFilter);
        }

        return $query->get()->groupBy('tanggal');
    }

    private function getMortalitasData(array $dateRange, array $kandangFilter)
    {
        $query = Mortalitas::with('kandang')
            ->whereBetween('tanggal', [$dateRange['start'], $dateRange['end']]);

        if (!empty($kandangFilter)) {
            $query->whereIn('kandang_id', $kandangFilter);
        }

        return $query->get()->groupBy('tanggal');
    }

    private function getPakanData(array $dateRange, array $kandangFilter)
    {
        $query = Pakan::with('kandang')
            ->whereBetween('tanggal', [$dateRange['start'], $dateRange['end']]);

        if (!empty($kandangFilter)) {
            $query->whereIn('kandang_id', $kandangFilter);
        }

        return $query->get()->groupBy('tanggal');
    }

    private function getRingkasanData(array $reportData)
    {
        $totalProduksi = 0;
        $totalMortalitas = 0;
        $totalPakan = 0;

        // Hitung total produksi
        if (!empty($reportData['produksi'])) {
            foreach ($reportData['produksi'] as $tanggal => $produksi) {
                foreach ($produksi as $item) {
                    $totalProduksi += $item->total_telur;
                }
            }
        }

        // Hitung total mortalitas
        if (!empty($reportData['mortalitas'])) {
            foreach ($reportData['mortalitas'] as $tanggal => $mortalitas) {
                foreach ($mortalitas as $item) {
                    $totalMortalitas += $item->jumlah_mati;
                }
            }
        }

        // Hitung total pakan
        if (!empty($reportData['pakan'])) {
            foreach ($reportData['pakan'] as $tanggal => $pakan) {
                foreach ($pakan as $item) {
                    $totalPakan += $item->konsumsi_pakan;
                }
            }
        }

        // Hitung total populasi dari data kandang
        $totalPopulasi = 0;
        if (!empty($reportData['kandang'])) {
            $totalPopulasi = $reportData['kandang']->sum('jumlah_puyuh');
        }

        return [
            'total_produksi' => $totalProduksi,
            'total_mortalitas' => $totalMortalitas,
            'total_pakan' => $totalPakan,
            'total_populasi' => $totalPopulasi,
        ];
    }
}
