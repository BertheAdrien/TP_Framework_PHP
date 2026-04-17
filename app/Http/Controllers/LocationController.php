<?php

namespace App\Http\Controllers;

use App\Jobs\RecalculateUpvotes;
use App\Models\Film;
use App\Models\Location;
use App\Models\Upvote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('location.owner', only: ['edit', 'update', 'destroy']),
        ];
    }

    public function index()
    {
        $locations = Location::latest()->get();

        return view('locations.index', compact('locations'));
    }

    public function create()
    {
        $films = Film::orderBy('title')->get();
        $users = User::orderBy('name')->get();

        return view('locations.create', compact('films', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'city' => 'required|max:255',
            'country' => 'required|max:255',
            'description' => 'nullable',
            'film_id' => 'required|exists:films,id',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['upvotes_count'] = 0;

        Location::create($validated);

        return redirect()->route('locations.index')
            ->with('success', 'Localisation créée');
    }

    public function show(Location $location)
    {
        return view('locations.show', compact('location'));
    }

    public function edit(Location $location)
    {
        $films = Film::orderBy('title')->get();
        $users = User::orderBy('name')->get();

        return view('locations.edit', compact('location', 'films', 'users'));
    }

    public function update(Request $request, Location $location)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'city' => 'required|max:255',
            'country' => 'required|max:255',
            'description' => 'nullable',
            'film_id' => 'required|exists:films,id',
        ]);

        $location->update($validated);

        return redirect()->route('locations.index')
            ->with('success', 'Localisation mise à jour');
    }

    public function destroy(Location $location)
    {
        $location->delete();

        return redirect()->route('locations.index')
            ->with('success', 'Localisation supprimée');
    }

    public function upvote(Location $location)
    {
        $alreadyVoted = Upvote::where('user_id', Auth::id())
            ->where('location_id', $location->id)
            ->exists();

        if ($alreadyVoted) {
            return back()->with('error', 'Vous avez déjà upvoté cette localisation.');
        }

        Upvote::create([
            'user_id' => Auth::id(),
            'location_id' => $location->id,
        ]);

        RecalculateUpvotes::dispatch($location);

        return back()->with('success', 'Upvote enregistré !');
    }
}
