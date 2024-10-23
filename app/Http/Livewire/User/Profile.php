<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Profile extends Component
{
    public User $user;
    public $latitude;
    public $longitude;

    public $showSuccesNotification = false;

    public $showDemoNotification = false;

    protected $rules = [
        // Personal Information
        'user.first_name' => 'required|max:40|min:3',
        'user.last_name' => 'required|max:40|min:3',
        'user.birthdate' => 'required|date',
        'user.gender' => 'required|in:male,female,other',
        'user.email' => 'required|email:rfc,dns',
        'user.phone' => 'required|max:15',
        'user.location1' => 'required|max:40|min:10',
        'user.location2' => 'nullable|max:40',
        'user.suburb' => 'required|min:3|max:40',
        'user.state' => 'required|min:3|max:40',

        // Job Information
        'user.job_status' => 'required|in:0,1',
        'user.position' => 'required|max:40|min:3',
        'user.started_work' => 'nullable|date',
        'user.work_email' => 'nullable|email:rfc,dns',
        'user.work_phone' => 'nullable|max:15',

        // Emergency Contact
        'user.emergency_firstname' => 'nullable|max:40|min:3',
        'user.emergency_lastname' => 'nullable|max:40|min:3',
        'user.emergency_relation' => 'nullable|min:5',
        'user.emergency_phone' => 'nullable|max:15',
    ];

    public function mount()
    {
        $this->user = auth()->user();
        $this->userId = $this->user->id;
    }

    public function saveLocation(Request $request)
    {
        $user = auth()->user();

        // Validate the request data
        $validated = $request->validate([
            'home_lat' => 'required|numeric',
            'home_lng' => 'required|numeric',
        ]);

        // Update the user's home location
        $user->home_lat = $validated['home_lat'];
        $user->home_lng = $validated['home_lng'];
        $user->save();
        
        // Set a flash message in the session
        session()->flash('success', 'Your location information has been successfully saved!');

        // Return a JSON response indicating success
        return response()->json(['message' => 'Location saved successfully!']);
    }

    public function save()
    {
        if (env('IS_DEMO')) {
            $this->showDemoNotification = true;
        } else {
            $this->validate();
            $this->user->save();
            Debugbar::info('User Saved');
            return redirect()->route(route: 'user-profile')->with('success', 'Your profile information has been successfully saved!');
        }
    }

    public function render()
    {
        return view('livewire.user.profile.show');
    }
}
