<?php

use App\Console\Commands\StibMessages;
use Illuminate\Support\Facades\Schedule;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();

Schedule::command(StibMessages::class)->everyThirtySeconds();
