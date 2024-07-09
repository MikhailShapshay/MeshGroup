<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadExcelRequest;
use App\Jobs\ParseExcelJob;
use App\Models\Row;

class FileController extends Controller
{
    public function upload(UploadExcelRequest $request)
    {
        $file = $request->file('file');
        $path = $file->store('uploads');

        ParseExcelJob::dispatch($path);

        return response()->json(['message' => 'File uploaded successfully']);
    }

    public function getRows()
    {
        $rows = Row::all()->groupBy('date')->toArray();

        return response()->json($rows);
    }
}
