<?php

use App\Http\Controllers\FindOutController;
use Illuminate\Support\Facades\Route;

Route::get('/', FindOutController::class);

Route::get('/laravel', function () {
    return view('laravel');
});
