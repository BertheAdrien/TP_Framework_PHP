<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
        public function index()
    {
        $locations = \App\Models\Location::all();
        return view('locations.index', compact('locations'));
    }
    
    public function create()
    {
        return view('locations.create');
    }
    
    public function store(Request $request)
    {
        //
    }
    
    public function show($id)
    {
        return view('locations.show', ['id' => $id]);
    }
    
    public function edit($id)
    {
        return view('locations.edit', ['id' => $id]);
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
