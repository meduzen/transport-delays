<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StibStopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stops = collect(Storage::json('seed/stib-stop-details-production.json'))
            ->map(function($stop) {
                $geo = json_decode($stop['gpscoordinates']);

                return [
                    'internal_id' => $stop['id'],
                    'name' => $stop['name'],

                    // https://blog.mehdi.cc/articles/laravel-mysql-geography-seed
                    'coordinates' => DB::raw('ST_SRID(Point('.$geo->longitude.', '.$geo->latitude.'), 4326)'),
                ];
            });

        DB::table('stib_stops')->insert($stops->toArray());
    }
}
