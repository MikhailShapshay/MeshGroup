<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/api/upload', [FileController::class, 'upload']);
Route::get('/api/rows', [FileController::class, 'getRows']);
