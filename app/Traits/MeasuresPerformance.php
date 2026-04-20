<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait MeasuresPerformance
{
    protected float $performanceStartTime;
    protected int $performanceStartMemory;
    protected array $performanceStartUsage; 

    protected function startPerformanceMeasurement(): void
    {
        $this->performanceStartTime = microtime(true);
        $this->performanceStartMemory = memory_get_usage();
        $this->performanceStartUsage = getrusage(); 
    }

    protected function endPerformanceMeasurement(string $operation, string $model): array
    {
        $endTime = microtime(true);
        $endMemory = memory_get_usage();
        $endUsage = getrusage(); 

        $executionTimeMs = ($endTime - $this->performanceStartTime) * 1000;
        $memoryUsed = $endMemory - $this->performanceStartMemory;

        $startTotalMicro = ($this->performanceStartUsage["ru_utime.tv_sec"] + $this->performanceStartUsage["ru_stime.tv_sec"]) * 1e6 
                         + $this->performanceStartUsage["ru_utime.tv_usec"] + $this->performanceStartUsage["ru_stime.tv_usec"];
        
        $endTotalMicro = ($endUsage["ru_utime.tv_sec"] + $endUsage["ru_stime.tv_sec"]) * 1e6 
                       + $endUsage["ru_utime.tv_usec"] + $endUsage["ru_stime.tv_usec"];
        
        $cpuTimeMs = ($endTotalMicro - $startTotalMicro) / 1000; 

        $result = [
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'operation' => $operation,
            'model' => $model,
            'execution_time_ms' => round($executionTimeMs, 4),
            'memory_usage_mb' => round($memoryUsed / 1024 / 1024, 4),
            'cpu_time_ms' => round($cpuTimeMs, 4), 
        ];

        $this->logPerformanceToCSV($result);

        Log::channel('single')->info("CRUD Performance: {$operation} {$model}", $result);

        return $result;
    }

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

        if (!$fileExists) {
            fputcsv($file, ['timestamp', 'operation', 'model', 'execution_time_ms', 'memory_usage_mb', 'cpu_time_ms']);
        }

        fputcsv($file, [
            $data['timestamp'],
            $data['operation'],
            $data['model'],
            $data['execution_time_ms'],
            $data['memory_usage_mb'],
            $data['cpu_time_ms'], 
        ]);

        fclose($file);
    }
}