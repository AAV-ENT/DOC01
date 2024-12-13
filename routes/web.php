<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\LocationController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', [DashboardController::class, 'create'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard/{search?}', [DashboardController::class, 'create'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/services', [ServicesController::class, 'create'])->middleware(['auth', 'verified'])->name('services');
Route::post('/services/create', [ServicesController::class, 'store'])->middleware(['auth', 'verified'])->name('createService');
Route::get('/services/{id}/edit', [ServicesController::class, 'edit'])->middleware(['auth', 'verified'])->name('services.edit');
Route::put('/services/{id}', [ServicesController::class, 'update'])->middleware(['auth', 'verified'])->name('services.update');
Route::delete('/services/{id}', [ServicesController::class, 'destroy'])->middleware(['auth', 'verified'])->name('services.destroy');

Route::get('/doctors', [DoctorController::class, 'create'])->middleware(['auth', 'verified'])->name('doctors');
Route::post('/doctor/store', [DoctorController::class, 'store'])->middleware(['auth', 'verified'])->name('doctor.store');
Route::get('/doctor/{id}/edit', [DoctorController::class, 'edit'])->middleware(['auth', 'verified'])->name('doctor.edit');
Route::put('/doctor/{id}', [DoctorController::class, 'update'])->middleware(['auth', 'verified'])->name('doctor.update');
Route::delete('/doctor/{id}', [DoctorController::class, 'destroy'])->middleware(['auth', 'verified'])->name('doctor.destroy');

Route::get('/locations', [LocationController::class, 'create'])->middleware(['auth', 'verified'])->name('locations');
Route::post('/locations/store', [LocationController::class, 'store'])->middleware(['auth', 'verified'])->name('storeLocation');
Route::get('/locations/{id}/edit', [LocationController::class, 'edit'])->middleware(['auth', 'verified'])->name('editLocation');
Route::put('/locations/{id}', [LocationController::class, 'update'])->middleware(['auth', 'verified'])->name('updateLocation');
Route::delete('/locations/{id}', [LocationController::class, 'destroy'])->middleware(['auth', 'verified'])->name('deleteLocation');

Route::post('/dashboard/store', [AppointmentController::class, 'store'])->middleware(['auth', 'verified'])->name('appointment.store');
Route::post('/dashboard/search', [DashboardController::class, 'search'])->middleware(['auth', 'verified'])->name('appointment.search');

