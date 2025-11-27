<?php

use Illuminate\Support\Facades\Route;
use App\Models\Laporan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return redirect()->route('filament.slamet_quail_farm.pages.dashboard');
});
Route::get('/laporan/{laporan}/download', function (Laporan $laporan) {
    $data = json_decode($laporan->data_laporan, true);
    
    $pdf = Pdf::loadView('filament.pages.laporan', $data)
        ->setPaper('a4', 'portrait')
        ->setOptions([
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);

    $filename = 'Laporan_' . str_replace(' ', '_', $data['periode']) . '_' . $laporan->created_at->format('Y-m-d_H-i') . '.pdf';
    
    return response($pdf->output(), 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ]);
})->name('laporan.download');

Route::get('/storage/temp/{filename}', function ($filename) {
    $path = 'temp/' . $filename;
    
    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }
    
    return response()->download(Storage::disk('public')->path($path), $filename, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ]);
})->name('laporan.temp-download');