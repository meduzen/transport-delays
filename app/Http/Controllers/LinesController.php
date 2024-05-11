<?php

namespace App\Http\Controllers;

use App\Models\Line;

class LinesController extends Controller
{
    public function __invoke()
    {
        $lines = Line::with('statuses')
            ->get()
            ->sortBy('name')
            ->groupBy('name');

        return view('lines')->with('lines', $lines);
    }
}
