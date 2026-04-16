<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;

class FilmController extends Controller
{
    public function index()
    {
        $films = Film::all();
        return view('films.index', compact('films'));
    }
    
    public function create()
    {
        return view('films.create');
    }
    
    public function store(Request $request)
    {
        //
    }
    
    public function show($id)
    {
        return view('films.show', ['id' => $id]);
    }
    
    public function edit($id)
    {
        return view('films.edit', ['id' => $id]);
    }
    
    public function update(Request $request, $id)
    {
        //
    }
    
    public function destroy($id)
    {
        //
    }
}
