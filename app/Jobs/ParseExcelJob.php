<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Row;
use Illuminate\Support\Facades\Redis;
use App\Events\RowCreated;

class ParseExcelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function handle()
    {
        $rows = Excel::toArray([], storage_path('app/public/' . $this->filePath))[0];
        $chunkSize = 1000;
        $firstKey = array_key_first($rows);
        unset($rows[$firstKey]);
        foreach (array_chunk($rows, $chunkSize) as $index => $chunk) {
            $this->processChunk($chunk, $index);
        }
    }

    protected function processChunk($chunk, $index)
    {
        foreach ($chunk as $row) {
            $date = \DateTime::createFromFormat('d.m.Y', $row[2]);
            $rowData = Row::create([
                'name' => $row[1],
                'date' => $date ? $date->format('Y-m-d') : null,
            ]);

            // Отправка события
            event(new RowCreated($rowData));

            $processedRows = Redis::incr('excel_progress_' . $this->getUniqueKey());
        }

        Redis::set('excel_chunk_' . $this->getUniqueKey() . '_index', $index + 1);
    }

    protected function getUniqueKey()
    {
        return pathinfo($this->filePath, PATHINFO_FILENAME);
    }
}
