<?php

namespace App\Http\Controllers;

use App\Models\Line;
use Illuminate\Support\Facades\Storage;

class LinesController extends Controller
{
    public function __invoke()
    {
        $lines = Line::with('statuses')
            ->orderBy('name')
            ->get()
            ->groupBy('name');

        return view('lines')->with('lines', $lines);
    }
}
