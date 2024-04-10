<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TravelInquiryController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('travelInquiry/travel', [TravelInquiryController::class, 'travel'])->name('travelInquiry.travel');
    Route::match(['get', 'post'], 'travelInquiry', [TravelInquiryController::class, 'store'])->name('travelInquiry.store');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');