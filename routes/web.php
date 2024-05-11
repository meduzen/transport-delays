<?php

use App\Http\Controllers\BrusselsSubwayController;
use App\Http\Controllers\LinesController;
use App\Http\Controllers\LinesAndStopsController;
use Illuminate\Support\Facades\Route;

Route::get('/wip/brussels-subway', BrusselsSubwayController::class);

Route::get('/wip/lines', LinesController::class);

Route::get('/wip/lines-and-stops', LinesAndStopsController::class);

Route::get('/laravel', fn () => view('laravel'));
