<?php

namespace App\Http\Controllers;

use App\Models\Line;
use Illuminate\Support\Facades\Storage;

class LinesController extends Controller
{
    public function __invoke()
    {
        $lines = Line::all();

        // @todo: organize travellers info with regular fetching
        $travellers_information = collect(Storage::json('samples/travellers-information-rt-production.json',))
            ->map(fn ($info) => [
                'content' => json_decode($info['content']),
                'type' => $info['type'],
                'lines' => json_decode($info['lines']),
                'priority' => $info['priority'],
                'stops' => json_decode($info['points']),
            ]);

        return view('lines')->with([
            'lines' => $lines,
            'travellers_information' => $travellers_information,
        ]);
    }
}
