<?php

namespace App\Http\Controllers;

use App\Models\StibLine;

class StibSubwaysController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $lines = StibLine::with(['disruptions', 'stops.disruptions'])
            ->whereIn('name', [1, 2, 3, 4, 5, 6])
            ->get()
            ->sortBy('name')

            // same name for the two directions of a line
            ->groupBy('name');

        return view('stib.subways')->with('lines', $lines);
    }
}
