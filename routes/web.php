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
Route::get('travelInquiry', [TravelInquiryController::class, 'index'])->name('travelInquiry.index');
Route::get('travelInquiry/{id}/edit', [TravelInquiryController::class, 'edit'])->name('travelInquiry.edit');
Route::get('/travel/search/results', [TravelInquiryController::class, 'searchResults'])->name('travelInquiry.searchResults');
Route::post('travelInquiry', [TravelInquiryController::class, 'store'])->name('travelInquiry.store');
Route::patch('travelInquiry/{id}', [TravelInquiryController::class, 'update'])->name('travelInquiry.update');
Route::delete('/travelInquiry/{id}', [TravelInquiryController::class, 'destroy'])->name('travelInquiry.destroy');