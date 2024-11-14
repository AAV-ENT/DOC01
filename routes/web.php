<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\DoctorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Route::get('/services', function() {
//     return view('management.services');
// })->middleware(['auth', 'verified'])->name('services');

Route::get('/services', [ServicesController::class, 'create'])->middleware(['auth', 'verified'])->name('services');
Route::post('/services/create', [ServicesController::class, 'store'])->middleware(['auth', 'verified'])->name('createService');

Route::get('/doctors', [DoctorController::class, 'create'])->middleware(['auth', 'verified'])->name('doctors');
Route::post('/doctor/store', [DoctorController::class, 'store'])->middleware(['auth', 'verified'])->name('storeDoctor');


