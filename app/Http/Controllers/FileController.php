<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadExcelRequest;
use App\Jobs\ParseExcelJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function upload(UploadExcelRequest $request)
    {
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads', $fileName, 'public');

        // Отправляем задачу в очередь
        ParseExcelJob::dispatch($filePath);

        return response()->json(['message' => 'File uploaded successfully']);
    }
}
