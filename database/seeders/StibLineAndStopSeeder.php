<?php

namespace Database\Seeders;

use App\Models\StibLine;
use App\Models\StibStop;
use Illuminate\Database\Seeder;

class StibLineAndStopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stops = StibStop::all();

        StibLine::all()->each(function ($line) use ($stops) {
            $lines_stop = collect($line->various->points)
                ->sortBy('order')
                ->mapWithKeys(function ($stop) use ($stops) {
                    $matching_stop = $stops->first(fn ($stop_detail) => $stop_detail->internal_id == $stop['id']);

                    if (! $matching_stop) {
                        return [null => null];
                    }

                    return [
                        $matching_stop->id => [
                            'order' => $stop['order'],
                        ],
                    ];
                })
                ->filter(); // for safety, hopefully never needed

            $line->stops()->attach($lines_stop);
        });
    }
}
