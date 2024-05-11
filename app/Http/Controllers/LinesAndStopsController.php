<?php

namespace App\Http\Controllers;

use App\Models\Line;

class LinesAndStopsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $lines = Line::with('stops')->get();
        return view('lines-and-stops')->with('lines', $lines);
    }
}
