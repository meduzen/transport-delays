<?php

namespace App\Http\Controllers;

use App\Models\Line;

class BrusselsSubwayController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $lines = Line::whereIn('name', [1, 2, 3, 4, 5, 6])
            ->with('statuses')
            ->get()
            ->sortBy('name')
            ->groupBy('name');

        return view('lines')->with('lines', $lines);
    }
}
