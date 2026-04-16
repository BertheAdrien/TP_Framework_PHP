<?php

use App\Http\Controllers\ProfileController;
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
    
    // Film routes
    Route::get('/films', [\App\Http\Controllers\FilmController::class, 'index'])->name('films.index');
    Route::get('/films/create', [\App\Http\Controllers\FilmController::class, 'create'])->name('films.create');
    Route::post('/films', [\App\Http\Controllers\FilmController::class, 'store'])->name('films.store');
    Route::get('/films/{film}', [\App\Http\Controllers\FilmController::class, 'show'])->name('films.show');
    Route::get('/films/{film}/edit', [\App\Http\Controllers\FilmController::class, 'edit'])->name('films.edit');
    Route::put('/films/{film}', [\App\Http\Controllers\FilmController::class, 'update'])->name('films.update');
    Route::delete('/films/{film}', [\App\Http\Controllers\FilmController::class, 'destroy'])->name('films.destroy');

    // Location routes
    Route::get('/locations', [\App\Http\Controllers\LocationController::class, 'index'])->name('locations.index');
    Route::get('/locations/create', [\App\Http\Controllers\LocationController::class, 'create'])->name('locations.create');
    Route::post('/locations', [\App\Http\Controllers\LocationController::class, 'store'])->name('locations.store');
    Route::get('/locations/{location}', [\App\Http\Controllers\LocationController::class, 'show'])->name('locations.show');
    Route::get('/locations/{location}/edit', [\App\Http\Controllers\LocationController::class, 'edit'])->name('locations.edit');
    Route::put('/locations/{location}', [\App\Http\Controllers\LocationController::class, 'update'])->name('locations.update');
    Route::delete('/locations/{location}', [\App\Http\Controllers\LocationController::class, 'destroy'])->name('locations.destroy');
});


require __DIR__.'/auth.php';
