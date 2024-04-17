<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccessTokenController;
use App\Http\Controllers\FlightSearchController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/init', AccessTokenController::class);
Route::post('/search', FlightSearchController::class);
Route::get('/search', FlightSearchController::class);
