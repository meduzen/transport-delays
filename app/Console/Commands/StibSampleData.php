<?php

namespace App\Console\Commands;

use App\Services\StibDataFetchingService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class StibSampleData extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'stib:sample';

    /**
     * The console command description.
     */
    protected $description = 'Feed the database with sample STIB messages';

    /**
     * Execute the console command.
     */
    public function handle(StibDataFetchingService $service)
    {
        $this
            ->newLine()
            ->line('Feeding the database with sample STIB messages…');

        $data = collect([
            // Former STIB API
            Storage::json('samples/2024-04-29-travellers-information-rt-production.json'),
            // Storage::json('samples/2024-05-10-travellers-information-rt-production.json'),
            // Storage::json('samples/2024-05-16-travellers-information-rt-production.json'),

            // Current STIB API
            Storage::json('samples/2026-03-22-travellers-information-rt-production.json')['results'],
        ])
            ->flatten(1);

        $count = $service->process($data);

        $this->info($count.' messages added.');

        return 0;
    }
}
