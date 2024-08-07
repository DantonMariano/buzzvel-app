<?php

use App\Http\Controllers\HolidayController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware("auth:sanctum")->group(function(){
    Route::resource('holidays', HolidayController::class);
    Route::get('download', [HolidayController::class, 'generatePdf']);
});
