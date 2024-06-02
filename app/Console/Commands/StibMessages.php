<?php

namespace App\Console\Commands;

use App\Services\StibDataFetchingService;
use Illuminate\Console\Command;

class StibMessages extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'stib:messages';

    /**
     * The console command description.
     */
    protected $description = 'Fetch STIB real-time messages';

    /**
     * Execute the console command.
     */
    public function handle(StibDataFetchingService $service)
    {
        $this
            ->newLine()
            ->line('Fetching current STIB messages…');

        $count = $service->fetch();

        $this->info($count.' messages added.');

        return 0;
    }
}
