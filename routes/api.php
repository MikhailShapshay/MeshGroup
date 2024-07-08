<?php

use Illuminate\Support\Facades\Route;

Route::post('/upload', [App\Http\Controllers\FileController::class, 'upload']);
