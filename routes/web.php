<?php

use App\Http\Controllers\StibApiTestController;
use App\Http\Controllers\StibLinesController;
use App\Http\Controllers\StibLinesAndStopsController;
use App\Http\Controllers\StibSubwaysController;
use Illuminate\Support\Facades\Route;

Route::get('/stib/subways', StibSubwaysController::class);

Route::get('/stib/lines', StibLinesController::class);

Route::get('/stib/lines-and-stops', StibLinesAndStopsController::class);

Route::get('/stib/test-api', StibApiTestController::class);

Route::get('/laravel', fn () => view('laravel'));
