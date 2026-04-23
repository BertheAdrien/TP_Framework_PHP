
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Film;
use App\Http\Controllers\FilmController;

Route::middleware(['auth:api', 'subscribed'])->get('/films/{film}/locations', function ($film) {
    $film = Film::with('locations')->findOrFail($film);
    return response()->json([
        'film' => [
            'id' => $film->id,
            'title' => $film->title,
        ],
        'locations' => $film->locations->map(fn($loc) => [
            'id' => $loc->id,
            'name' => $loc->name,
            'city' => $loc->city,
            'country' => $loc->country,
        ]),
    ]);
});

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (!$token = Auth::guard('api')->attempt($credentials)) {
        return response()->json(['message' => 'Identifiants invalides'], 401);
    }

    return response()->json(['token' => $token]);
});

Route::get('/films', function () {
    return response()->json(Film::all());
});

Route::get('/films/{film}/locations', function ($film) {
    $film = Film::with('locations')->findOrFail($film);
    return response()->json([
        'film' => ['id' => $film->id, 'title' => $film->title],
        'locations' => $film->locations,
    ]);
});