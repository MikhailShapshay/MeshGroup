<?php

use App\Http\Controllers\RowController;
use Illuminate\Support\Facades\Route;

Route::get('/rows', [RowController::class, 'index']);
Route::post('/upload', [App\Http\Controllers\FileController::class, 'upload'])->name('upload');
Route::get('/', function () {
    return view('upload');
});
