<?php

namespace App\Http\Controllers;

use App\Venue;
use Illuminate\Http\Request;

class VenuesController extends Controller
{
    public function index(Venue $venue)
    {
        $venues = $venue->all();
        $title = "Venues";
        return view('venues', compact('title', 'venues'));
    }

    public function store(Request $request, Venue $venue)
    {
        $this->validate($request, [
            'name' => 'required|unique:venues'
        ]);

        $venue->create(['name' => $request->get('name')]);

        return redirect()->back()->with('success', 'Hall created successfully!');
    }
}
