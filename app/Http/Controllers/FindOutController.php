<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class FindOutController extends Controller
{
    public function __invoke()
    {
        $stops_by_line = Storage::get('samples/stops-by-line-production.json');
        $stop_details = Storage::get('samples/stop-details-production.json');
        $travellers_information = Storage::get('samples/travellers-information-rt-production.json');

        return view('find-out')->with([
            'stops_by_line' => json_decode($stops_by_line),
            'stop_details' => json_decode($stop_details),
            'travellers_information' => json_decode($travellers_information),
        ]);
    }
}
