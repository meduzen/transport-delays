<?php

use App\Http\Controllers\LinesController;
use App\Http\Controllers\LinesAndStopsController;
use Illuminate\Support\Facades\Route;

Route::get('/lines', LinesController::class);

Route::get('/lines-and-stops', LinesAndStopsController::class);

Route::get('/laravel', function () {
    return view('laravel');
});
