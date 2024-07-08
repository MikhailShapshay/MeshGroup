<?php

namespace App\Imports;

use App\Models\Row;
use Maatwebsite\Excel\Concerns\ToModel;

class RowsImport implements ToModel
{
    public function model(array $row)
    {
        return new Row([
            'id' => $row[0],
            'name' => $row[1],
            'date' => \Carbon\Carbon::createFromFormat('d.m.Y', $row[2])->format('Y-m-d'),
        ]);
    }
}
