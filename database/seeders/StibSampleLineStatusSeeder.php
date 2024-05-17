<?php

namespace Database\Seeders;

use App\Models\StibLine;
use App\Models\StibStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class StibSampleLineStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            Storage::json('samples/2024-04-29-travellers-information-rt-production.json'),
            Storage::json('samples/2024-05-10-travellers-information-rt-production.json'),
            Storage::json('samples/2024-05-16-travellers-information-rt-production.json'),
        ])
            ->flatten(1)
            ->map(function ($info) {

                /**
                 * Replace stringified JSON to have proper objects. It’s
                 * needed to store the raw stringified JSON status.
                 */
                $info['content'] = json_decode($info['content']);
                $info['lines'] = json_decode($info['lines']);
                $info['points'] = json_decode($info['points']);

                $status = new StibStatus();
                $status->priority = $info['priority'];
                $status->type = $info['type'];
                $status->content = $info['content'];
                $status->raw = json_encode($info);

                $status->save();

                $lines_id = collect($info['lines'])->pluck('id');
                $lines = StibLine::whereIn('name', $lines_id)->get();

                $status->lines()->sync($lines);
            });
    }
}
