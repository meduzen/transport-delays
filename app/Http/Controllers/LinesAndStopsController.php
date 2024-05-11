<?php

namespace App\Http\Controllers;

use App\Models\StibLine;

class LinesAndStopsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $lines = StibLine::with('stops')->get();
        return view('lines-and-stops')->with('lines', $lines);
    }
}
