<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([
    'prefix' => 'v1', 
    'namespace' => 'App\Http\Controllers\API\V1',
    // 'middleware' => ['auth:sanctum']
], function() {
    Route::apiResource('doctors', DoctorController::class);
    Route::apiResource('services', ServicesController::class);
    Route::apiResource('appointments', AppointmentsController::class);
    Route::apiResource('cities', CitiesController::class);
    Route::apiResource('location', LocationController::class);
});