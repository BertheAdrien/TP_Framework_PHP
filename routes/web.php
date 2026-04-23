<?php

use App\Http\Controllers\FilmController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Stripe\Stripe;
use Stripe\Checkout\Session;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| GITHUB OAUTH
|--------------------------------------------------------------------------
*/

Route::get('/auth/github', function () {
    return Socialite::driver('github')->redirect();
})->name('github.login');

Route::get('/auth/github/callback', function () {

    $githubUser = app('Laravel\Socialite\Contracts\Factory')
        ->driver('github')
        ->stateless()
        ->user();

    $email = $githubUser->getEmail() ?? $githubUser->getId() . '@github.com';

    $user = User::updateOrCreate(
        ['email' => $email],
        [
            'name' => $githubUser->getName() ?? $githubUser->getNickname(),
            'password' => bcrypt(str()->random(16)),
        ]
    );

    Auth::login($user);

    return redirect('/dashboard');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Route::middleware(['subscribed'])->get('/api/films/{film}/locations', function ($film) {
    //     $film = \App\Models\Film::with('locations')->findOrFail($film);
    //     return response()->json([
    //         'film' => [
    //             'id' => $film->id,
    //             'title' => $film->title,
    //         ],
    //         'locations' => $film->locations->map(fn($loc) => [
    //             'id' => $loc->id,
    //             'name' => $loc->name,
    //             'city' => $loc->city,
    //             'country' => $loc->country,
    //         ]),
    //     ]);
    // });
    /*
    |--------------------------------------------------------------------------
    | FILMS
    |--------------------------------------------------------------------------
    */

    // Public (user + admin)
    Route::get('/films', [FilmController::class, 'index'])->name('films.index');
    Route::get('/films/{film}', [FilmController::class, 'show'])->name('films.show');

    // Admin only
    Route::middleware('is_admin')->group(function () {
        Route::get('/films/create', [FilmController::class, 'create'])->name('films.create');
        Route::post('/films', [FilmController::class, 'store'])->name('films.store');
        Route::get('/films/{film}/edit', [FilmController::class, 'edit'])->name('films.edit');
        Route::put('/films/{film}', [FilmController::class, 'update'])->name('films.update');
        Route::delete('/films/{film}', [FilmController::class, 'destroy'])->name('films.destroy');
    });

    Route::get('/test-api', function () {
        return view('test-api');
    });

    /*
    |--------------------------------------------------------------------------
    | LOCATIONS
    |--------------------------------------------------------------------------
    */

    Route::resource('locations', LocationController::class);

    Route::post('/locations/{location}/upvote', [LocationController::class, 'upvote'])
        ->name('locations.upvote');

    /*
    |--------------------------------------------------------------------------
    | STRIPE SUBSCRIPTION
    |--------------------------------------------------------------------------
    */

    Route::get('/subscribe', function () {
        return view('subscribe');
    });

    Route::post('/create-checkout-session', function () {

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Abonnement Premium',
                    ],
                    'unit_amount' => 500,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/success'),
            'cancel_url' => url('/subscribe'),
        ]);

        return redirect($session->url);
    });

    Route::get('/success', function () {

        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = User::find(Auth::id());

        if ($user) {
            $user->is_subscribed = true;
            $user->save();
        }

        return redirect('/dashboard')->with('success', 'Abonnement activé');
    });
});

require __DIR__ . '/auth.php';
