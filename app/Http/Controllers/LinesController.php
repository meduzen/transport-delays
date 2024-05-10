<?php

namespace App\Http\Controllers;

use App\Models\Line;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class LinesController extends Controller
{
    public function __invoke()
    {
        $lines = Line::all()->sortBy('name')->groupBy('name');

        // @todo: organize travellers info with regular fetching
        $travellers_information = collect([
            Storage::json('samples/2024-04-29-travellers-information-rt-production.json'),
            Storage::json('samples/2024-05-10-travellers-information-rt-production.json'),
        ])
            ->flatten(1)
            ->map(fn ($info) => [
                'content' => json_decode($info['content']),
                'type' => $info['type'],
                'lines' => json_decode($info['lines']),
                'priority' => $info['priority'],
                'stops' => json_decode($info['points']),
            ]);

        return view('lines')->with(compact('lines', 'travellers_information'));
    }
}
