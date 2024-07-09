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
        $rows = Excel::toArray([], storage_path('app/' . $this->filePath))[0];
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
            // Преобразование даты
            $dateString = $row[2];
            $date = \DateTime::createFromFormat('d.m.y', $dateString);
            if ($date) {
                $currentYear = (int) date('y');
                $inputYear = (int) $date->format('y');
                $century = $inputYear > $currentYear ? 1900 : 2000;
                $date->setDate($century + $inputYear, $date->format('m'), $date->format('d'));

                $formattedDate = $date->format('Y-m-d');
            } else {
                $formattedDate = null; // или обработка ошибки
            }
            if(empty($row[1]))
                continue;
            $model = new Row();
            $model->name = $row[1];
            $model->date = $formattedDate;
            $model->save();
            /*$rowData = $model::create([
                'name' => $row[1],
                'date' => $formattedDate,
            ]);*/

            // Отправка события
            event(new RowCreated($model));

            $processedRows = Redis::incr('excel_progress_' . $this->getUniqueKey());
        }

        Redis::set('excel_chunk_' . $this->getUniqueKey() . '_index', $index + 1);
    }

    protected function getUniqueKey()
    {
        return pathinfo($this->filePath, PATHINFO_FILENAME);
    }
}
