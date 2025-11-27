<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Peternakan - {{ $periode }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #2c5282; }
        .header p { margin: 5px 0; color: #666; }
        .section { margin-bottom: 20px; }
        .section-title { background-color: #2c5282; color: white; padding: 8px; font-weight: bold; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f8f9fa; font-weight: bold; }
        .summary-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 15px; }
        .summary-card { border: 1px solid #ddd; padding: 15px; border-radius: 8px; background-color: #f8f9fa; text-align: center; }
        .summary-value { font-size: 24px; font-weight: bold; color: #2c5282; margin: 10px 0; }
        .summary-label { font-size: 14px; color: #666; }
        .text-success { color: #38a169; }
        .text-danger { color: #e53e3e; }
        .text-info { color: #3182ce; }
        .footer { margin-top: 30px; text-align: center; color: #666; font-size: 10px; border-top: 1px solid #ddd; padding-top: 10px; }
        .kandang-info { background-color: #e6f3ff; padding: 10px; border-radius: 5px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SLAMET QUAIL FARM</h1>
        <p>Laporan Peternakan Periode: {{ $periode }}</p>
        <p>Jenis Laporan: {{ ucfirst($jenis_laporan) }}</p>
        <p>Dicetak pada: {{ $tanggal_cetak }}</p>
    </div>

    <!-- Info Kandang -->
    <div class="section">
        <div class="section-title">INFORMASI KANDANG</div>
        <div class="kandang-info">
            <strong>Total Populasi:</strong> {{ number_format($ringkasan['total_populasi']) }} ekor |
            <strong>Kandang Dipilih:</strong> 
            @if(empty($filters['kandang']))
                Semua Kandang
            @else
                {{ is_array($kandang) ? count($kandang) : $kandang->count() }} kandang
            @endif
        </div>
    </div>

    <!-- Ringkasan -->
    <div class="section">
        <div class="section-title">RINGKASAN</div>
        <div class="summary-grid">
            <div class="summary-card">
                <div class="summary-label">TOTAL PRODUKSI TELUR</div>
                <div class="summary-value text-success">{{ number_format($ringkasan['total_produksi']) }}</div>
                <div class="summary-label">butir</div>
            </div>
            <div class="summary-card">
                <div class="summary-label">TOTAL MORTALITAS</div>
                <div class="summary-value text-danger">{{ number_format($ringkasan['total_mortalitas']) }}</div>
                <div class="summary-label">ekor</div>
            </div>
            <div class="summary-card">
                <div class="summary-label">TOTAL KONSUMSI PAKAN</div>
                <div class="summary-value text-info">{{ number_format($ringkasan['total_pakan'], 2) }}</div>
                <div class="summary-label">gr</div>
            </div>
        </div>
    </div>

    <!-- Data Produksi Telur -->
    @if(!empty($produksi) && count($produksi) > 0)
    <div class="section">
        <div class="section-title">DATA PRODUKSI TELUR</div>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kandang</th>
                    <th>Telur OK</th>
                    <th>Telur BS</th>
                    <th>Total</th>
                    <th>Berat (kg)</th>
                    <th>Rata-rata (gr)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produksi as $tanggal => $items)
                    @foreach($items as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}</td>
                        <td>{{ $item['kandang']['lokasi'] ?? ($item->kandang->lokasi ?? 'N/A') }}</td>
                        <td>{{ number_format($item['telur_ok'] ?? $item->telur_ok) }}</td>
                        <td>{{ number_format($item['telur_bs'] ?? $item->telur_bs) }}</td>
                        <td>{{ number_format($item['total_telur'] ?? $item->total_telur) }}</td>
                        <td>{{ number_format($item['berat'] ?? $item->berat, 2) }}</td>
                        <td>{{ number_format($item['rata_rata'] ?? $item->rata_rata, 2) }}</td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="section">
        <div class="section-title">DATA PRODUKSI TELUR</div>
        <p style="text-align: center; color: #666; padding: 20px;">Tidak ada data produksi telur untuk periode ini</p>
    </div>
    @endif

    <!-- Data Mortalitas -->
    @if(!empty($mortalitas) && count($mortalitas) > 0)
    <div class="section">
        <div class="section-title">DATA MORTALITAS</div>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kandang</th>
                    <th>Jumlah Mati</th>
                    <th>Penyebab</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mortalitas as $tanggal => $items)
                    @foreach($items as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}</td>
                        <td>{{ $item['kandang']['lokasi'] ?? ($item->kandang->lokasi ?? 'N/A') }}</td>
                        <td>{{ number_format($item['jumlah_mati'] ?? $item->jumlah_mati) }}</td>
                        <td>{{ $item['penyebab'] ?? $item->penyebab }}</td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="section">
        <div class="section-title">DATA MORTALITAS</div>
        <p style="text-align: center; color: #666; padding: 20px;">Tidak ada data mortalitas untuk periode ini</p>
    </div>
    @endif

    <!-- Data Pakan -->
    @if(!empty($pakan) && count($pakan) > 0)
    <div class="section">
        <div class="section-title">DATA PAKAN</div>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kandang</th>
                    <th>Pemberian (gr)</th>
                    <th>Sisa (gr)</th>
                    <th>Konsumsi (gr)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pakan as $tanggal => $items)
                    @foreach($items as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}</td>
                        <td>{{ $item['kandang']['lokasi'] ?? ($item->kandang->lokasi ?? 'N/A') }}</td>
                        <td>{{ number_format($item['pemberian_pakan'] ?? $item->pemberian_pakan, 2) }}</td>
                        <td>{{ number_format($item['sisa_pakan'] ?? $item->sisa_pakan, 2) }}</td>
                        <td>{{ number_format($item['konsumsi_pakan'] ?? $item->konsumsi_pakan, 2) }}</td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="section">
        <div class="section-title">DATA PAKAN</div>
        <p style="text-align: center; color: #666; padding: 20px;">Tidak ada data pakan untuk periode ini</p>
    </div>
    @endif
</body>
</html>