<?php

namespace Database\Seeders;

use App\Models\Line;
use App\Models\Stop;
use Illuminate\Database\Seeder;

class StibLinesAndStopsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stops = Stop::all();

        Line::all()->each(function($line) use ($stops) {
            $lines_stop = collect($line->various->points)
                ->sortBy('order')
                ->mapWithKeys(function ($stop) use ($stops) {
                    $matching_stop = $stops->first(fn ($stop_detail) => $stop_detail->internal_id == $stop['id']);

                    if(!$matching_stop) {
                        return [null => null];
                    }

                    return [
                        $matching_stop->id => [
                            'order' => $stop['order'],
                        ],
                    ];
                })
                ->filter(); // for safety, hopefully never needed

            $line->stops()->sync($lines_stop);
        });
    }
}
