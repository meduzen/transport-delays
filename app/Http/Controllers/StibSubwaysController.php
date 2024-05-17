<?php

namespace App\Http\Controllers;

use App\Models\StibLine;
use Illuminate\Support\Str;

class StibSubwaysController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        // $lines = StibLine::with(['disruptions', 'stops'])
        $lines = StibLine::whereIn('name', [1, 2, 3, 4, 5, 6])
            ->get()
            ->sortBy('name')

            // same name for the two directions of a line
            ->groupBy('name')

            /**
             * @todo: improve data models and relationships to avoid this,
             * starting by creating a relationship between status and stops
             */
            // attach disruptions to their related stops
            ->map(function($line_group) {
                $line_group->each(function($line) {
                    $line->disruptions->each(function($disruption) use ($line) {
                        collect($disruption->raw->points)
                            ->each(function($impacted_stop) use ($line, $disruption) {
                                $stop = $line->stops->firstWhere('internal_id', $impacted_stop['id']);

                                if (!$stop) {
                                    return;
                                }

                                if (property_exists($stop, 'statuses')) {
                                    $stop->statuses->push($disruption);
                                } else {
                                    $stop->statuses = collect([$disruption]);
                                }
                            });
                    });
                });

                return $line_group;
            });

        return view('stib.subways')->with('lines', $lines);
    }
}
