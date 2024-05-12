<?php

namespace App\Http\Controllers;

use App\Models\StibLine;

class StibLinesController extends Controller
{
    public function __invoke()
    {
        $lines = StibLine::with('disruptions')
            ->get()
            ->sortBy('name')
            ->groupBy('name');

        return view('stib.lines')->with('lines', $lines);
    }
}
