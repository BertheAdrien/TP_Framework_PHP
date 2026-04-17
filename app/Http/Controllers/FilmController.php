<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public static function middleware(): array
    {
        return [
            'admin' => ['except' => ['index', 'show']],
        ];
    }

    public function index()
    {
        $films = Film::latest()->get();

        return view('films.index', compact('films'));
    }

    public function create()
    {
        return view('films.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'release_year' => 'required|integer',
            'synopsis' => 'nullable',
        ]);

        Film::create($validated);

        return redirect()->route('films.index')
            ->with('success', 'Film ajouté avec succès');
    }

    public function show(Film $film)
    {
        return view('films.show', compact('film'));
    }

    public function edit(Film $film)
    {
        return view('films.edit', compact('film'));
    }

    public function update(Request $request, Film $film)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'release_year' => 'required|integer',
            'synopsis' => 'nullable',
        ]);

        $film->update($validated);

        return redirect()->route('films.index')
            ->with('success', 'Film modifié');
    }

    public function destroy(Film $film)
    {
        $film->delete();

        return redirect()->route('films.index')
            ->with('success', 'Film supprimé');
    }
}
