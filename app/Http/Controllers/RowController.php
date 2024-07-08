<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Row;

class RowController extends Controller
{
    public function index()
    {
        $rows = Row::all()->groupBy('date');

        return response()->json($rows);
    }
}
