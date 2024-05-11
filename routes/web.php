<?php

use App\Http\Controllers\StibLinesController;
use App\Http\Controllers\StibLinesAndStopsController;
use Illuminate\Support\Facades\Route;

Route::get('/stib/lines', StibLinesController::class);

Route::get('/stib/lines-and-stops', StibLinesAndStopsController::class);

Route::get('/laravel', fn () => view('laravel'));
