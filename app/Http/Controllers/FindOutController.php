<?php

namespace App\Http\Controllers;

use App\Models\Stop;
use Illuminate\Support\Facades\Storage;

// https://stackoverflow.com/questions/24689852/fetching-mysql-geo-point-data-and-storing-result-in-php-variable
function rawPointToFloatPair($data)
{
    $res = unpack("lSRID/CByteOrder/lTypeInfo/dX/dY", $data);
    return [$res['X'],$res['Y']];
}

class FindOutController extends Controller
{
    public function __invoke()
    {
        $stops = Stop::all()
            ->map(function ($stop){
                $stop->name = json_decode($stop->name);
                $stop->coordinates = rawPointToFloatPair($stop->coordinates);
                return $stop;
            });


        $lines = collect(Storage::json('seed/stib-stops-by-line-production.json'))
            ->map(function ($line) use ($stops) {
                $lines_stop = collect(json_decode($line['points']))->sortBy('order');

                $lines_stop = $lines_stop->each(function ($stop) use ($stops) {
                    $matching_stop = $stops->first(fn ($stop_detail) => $stop_detail->internal_id == $stop->id);
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
