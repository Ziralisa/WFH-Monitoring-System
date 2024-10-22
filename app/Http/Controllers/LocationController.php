<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{


    public function saveLocation(Request $request){

        $validated = $request->validate([
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'type' => 'nullable|string',
        'status' => 'nullable|string',
        ]);

        $userId = auth()->id();

        $user_location = Location::create([
            'user_id' => $userId,
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'type' => $validated['type'],
            'status' => $validated['status'],
        ]);

        return response()->json(['Location saved successfully']);
    }
}
