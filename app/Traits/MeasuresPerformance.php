<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait MeasuresPerformance
{
    protected float $performanceStartTime;
    protected int $performanceStartMemory;

    /**
     * Mulai pengukuran performa
     */
    protected function startPerformanceMeasurement(): void
    {
        $this->performanceStartTime = microtime(true);
        $this->performanceStartMemory = memory_get_usage();
    }

    /**
     * Akhiri pengukuran dan log hasilnya
     */
    protected function endPerformanceMeasurement(string $operation, string $model): array
    {
        $endTime = microtime(true);
        $endMemory = memory_get_usage();
        $peakMemory = memory_get_peak_usage();

        $executionTimeMs = ($endTime - $this->performanceStartTime) * 1000;
        $memoryUsed = $endMemory - $this->performanceStartMemory;

        $result = [
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'operation' => $operation,
            'model' => $model,
            'execution_time_ms' => round($executionTimeMs, 4),
            'memory_usage_mb' => round($memoryUsed / 1024 / 1024, 4),
            'memory_peak_mb' => round($peakMemory / 1024 / 1024, 4),
        ];

        // Log ke file CSV
        $this->logPerformanceToCSV($result);

        // Log ke Laravel log
        Log::channel('single')->info("CRUD Performance: {$operation} {$model}", $result);

        return $result;
    }

    /**
     * Simpan hasil pengukuran ke file CSV
     */
    protected function logPerformanceToCSV(array $data): void
    {
        $logDir = storage_path('logs/performance');
        
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }

        $database = config('database.default') === 'mongodb' ? 'mongodb' : 'mysql';
        $filePath = "{$logDir}/crud_performance_{$database}.csv";

        $fileExists = file_exists($filePath);
        $file = fopen($filePath, 'a');

        // Tulis header jika file baru
        if (!$fileExists) {
            fputcsv($file, ['timestamp', 'operation', 'model', 'execution_time_ms', 'memory_usage_mb', 'memory_peak_mb']);
        }

        fputcsv($file, [
            $data['timestamp'],
            $data['operation'],
            $data['model'],
            $data['execution_time_ms'],
            $data['memory_usage_mb'],
            $data['memory_peak_mb'],
        ]);

        fclose($file);
    }

    /**
     * Format memory ke MB
     */
    protected function formatToMB(float $mb): string
    {
        return sprintf("%.4f MB", $mb);
    }

    /**
     * Tampilkan notifikasi performance
     */
    // protected function showPerformanceNotification(array $result): void
    // {
    //     $message = sprintf(
    //         '%s %s - Waktu: %.4f ms | Memori: %s',
    //         $result['operation'],
    //         $result['model'],
    //         $result['execution_time_ms'],
    //         $this->formatToMB($result['memory_usage_mb'])
    //     );

    //     \Filament\Notifications\Notification::make()
    //         ->title('Performance Metrics')
    //         ->body($message)
    //         ->info()
    //         ->duration(5000)
    //         ->send();
    // }
}
