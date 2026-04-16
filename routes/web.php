<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\LocationController;

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

    Route::post('/locations/{location}/upvote', [LocationController::class, 'upvote'])->name('locations.upvote');

    Route::get('/films', [FilmController::class, 'index'])->name('films.index');
    Route::get('/films/{film}', [FilmController::class, 'show'])->name('films.show');
    Route::middleware('is_admin')->group(function () {
        Route::get('/films/create', [FilmController::class, 'create'])->name('films.create');
        Route::post('/films', [FilmController::class, 'store'])->name('films.store');
        Route::get('/films/{film}/edit', [FilmController::class, 'edit'])->name('films.edit');
        Route::put('/films/{film}', [FilmController::class, 'update'])->name('films.update');
        Route::delete('/films/{film}', [FilmController::class, 'destroy'])->name('films.destroy');

    });
    Route::resource('locations', LocationController::class);
});

require __DIR__.'/auth.php';