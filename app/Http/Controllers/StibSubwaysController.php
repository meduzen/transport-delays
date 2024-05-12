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
        $lines = StibLine::whereIn('name', [1, 2, 3, 4, 5, 6])
            ->with('disruptions')
            ->get()
            ->sortBy('name')
            ->groupBy('name');

        return view('stib.subways')->with('lines', $lines);
    }
}
