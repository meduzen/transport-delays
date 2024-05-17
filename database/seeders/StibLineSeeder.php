<?php

namespace Database\Seeders;

use App\Models\StibLine;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use stdClass;

class StibLineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add STIB lines from JSON

        $lines = collect(Storage::json('seed/stib-stops-by-line-production.json'))
            ->map(function ($line) {
                $various = new stdClass();
                $various->direction = $line['direction'];
                $various->points = json_decode($line['points']);

                return [
                    'name' => $line['lineid'],
                    'city' => null,
                    'direction' => $line['destination'],
                    'various' => json_encode($various),
                ];
            });

        DB::table('stib_lines')->insert($lines->toArray());

        // Try to associate lines running in opposite direction.

        $lines = StibLine::all();

        $lines->each(function ($line) use ($lines) {

            if ($line->opposite_direction_id !== null) {
                return;
            }

            // Find line running in opposite direction.

            $opposite_line = $lines->first(fn ($other_line) => $other_line['name'] == $line['name']
                && $other_line['direction'] != $line['direction']
            );

            if (! $opposite_line) {
                return;
            }

            // Associate opposite line.

            $line->opposite_direction_id = $opposite_line->id;

            $line->save();

            // While on it, do the same for the opposite line.

            if ($opposite_line->opposite_direction_id === null) {
                $opposite_line->opposite_direction_id = $line->id;

                $opposite_line->save();
            }
        });
    }
}
