<?php

namespace App\Http\Controllers;

use App\Models\StibLine;

class StibLinesAndStopsController extends Controller
{
    public function __invoke()
    {
        $lines = StibLine::with('stops')->get();
        return view('stib.lines-and-stops')->with('lines', $lines);
    }
}
