<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class FindOutController extends Controller
{
    public function __invoke()
    {
        $stop_details = collect(Storage::json('samples/stop-details-production.json'))
            ->map(fn ($stop) => [
                'id' => $stop['id'],
                'name' => json_decode($stop['name']),
                'gpscoordinates' => json_decode($stop['gpscoordinates']),
            ]);

        $lines = collect(Storage::json('seed/stib-stops-by-line-production.json'))
            ->map(function ($line) use ($stop_details) {
                $lines_stop = collect(json_decode($line['points']))->sortBy('order');

                $lines_stop = $lines_stop->each(function ($stop) use ($stop_details) {
                    $matching_stop = $stop_details->first(fn ($stop_detail) => $stop_detail['id'] == $stop->id);
                    if ($matching_stop) {
                        $stop->name = $matching_stop['name'];
                    } else {
                        // should log?
                    }
                });

                return [
                    'line' => $line['lineid'],
                    'to' => json_decode($line['destination']),
                    'direction' => $line['direction'],
                    'stops' => $lines_stop,
                ];
            });

        // Travellers information

        $travellers_information = collect(Storage::json('samples/travellers-information-rt-production.json',))
            ->map(fn ($info) => [
                'content' => json_decode($info['content']),
                'type' => $info['type'],
                'lines' => json_decode($info['lines']),
                'priority' => $info['priority'],
                'stops' => json_decode($info['points']),
            ]);

        return view('find-out')->with([
            'lines' => $lines,
            'travellers_information' => $travellers_information,
        ]);
    }
}
