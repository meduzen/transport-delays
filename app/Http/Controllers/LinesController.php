<?php

namespace App\Http\Controllers;

use App\Models\StibLine;

class LinesController extends Controller
{
    public function __invoke()
    {
        $lines = StibLine::with('statuses')
            ->get()
            ->sortBy('name')
            ->groupBy('name');

        return view('lines')->with('lines', $lines);
    }
}
