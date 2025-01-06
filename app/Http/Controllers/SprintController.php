<?php

namespace App\Http\Controllers;

use App\Models\Sprint;
use App\Models\User;
use Illuminate\Http\Request;

class SprintController extends Controller
{
    /**
     * Show the backlog view with all sprints.
     */
    public function showBacklog()
    {
        $sprints = Sprint::all(); // Fetch all sprints
        $users = User::all();

        return view('livewire.task-management.backlog', compact('sprints','users'));


    }

    /**
     * Display the form to create a new sprint.
     */
    public function create()
    {
        return view('sprints.create');
    }

    /**
     * Store a new sprint in the database.
     */
    public function storeSprint()
    {

        //dd(request()->all());

        // Validate the incoming data
        $validated = request()->validate([
            'name' => 'required|string|max:50',
            'desc' => 'nullable|string|max:255',
            'startdate' => 'required|date',
            'enddate' => 'required|date|after_or_equal:startdate',
        ]);

        //dd($request->validate());
        // Create and save the sprint
        Sprint::create($validated);

        return redirect()->route('backlog.show')->with('success', 'Sprint added successfully!');
    }
}
