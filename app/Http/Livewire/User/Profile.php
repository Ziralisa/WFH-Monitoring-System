<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
<<<<<<< HEAD
use Livewire\Attributes\Validate;
use Livewire\Component;

class Profile extends Component
{
=======
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Profile extends Component
{
    use WithFileUploads;

>>>>>>> a2f031c (initial commit)
    public User $user;
    public $latitude;
    public $longitude;

<<<<<<< HEAD
    public $showSuccesNotification = false;

=======
    public $photo; // For image upload
    public $showSuccesNotification = false;
>>>>>>> a2f031c (initial commit)
    public $showDemoNotification = false;
    public ?int $selectedUserId = null;

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
<<<<<<< HEAD
=======

        // Profile photo
        'photo' => 'nullable|image|max:2048',
>>>>>>> a2f031c (initial commit)
    ];

    public function mount($selectedUserId = null)
    {
        $this->selectedUserId = $selectedUserId;

<<<<<<< HEAD
        // If viewing another user, fetch that user; otherwise, use the authenticated user.
        $this->user = $selectedUserId ? User::findOrFail($selectedUserId) : auth()->user();
=======
        $this->user = $selectedUserId
            ? User::findOrFail($selectedUserId)
            : auth()->user();
>>>>>>> a2f031c (initial commit)
    }

    public function saveLocation(Request $request)
    {
        $user = auth()->user();

<<<<<<< HEAD
        // Validate the request data
=======
>>>>>>> a2f031c (initial commit)
        $validated = $request->validate([
            'home_lat' => 'required|numeric',
            'home_lng' => 'required|numeric',
        ]);

<<<<<<< HEAD
        // Update the user's home location
=======
>>>>>>> a2f031c (initial commit)
        $user->home_lat = $validated['home_lat'];
        $user->home_lng = $validated['home_lng'];
        $user->save();

<<<<<<< HEAD
        // Set a flash message in the session
        session()->flash('success', 'Your location information has been successfully saved!');

        // Return a JSON response indicating success
        return response()->json(['message' => 'Location saved successfully!']);
    }

=======
        session()->flash('success', 'Your location information has been successfully saved!');
        return response()->json(['message' => 'Location saved successfully!']);
    }

    public function updatedPhoto()
    {
        $this->validateOnly('photo');

        if ($this->photo) {
            // Delete old photo if exists
            if ($this->user->profile_photo_path) {
                Storage::disk('public')->delete($this->user->profile_photo_path);
            }

            $path = $this->photo->store('profile-photos', 'public');
            $this->user->profile_photo_path = $path;
            $this->user->save();

            session()->flash('success', 'Profile photo updated!');
        }
    }

>>>>>>> a2f031c (initial commit)
    public function save()
    {
        if (env('IS_DEMO')) {
            $this->showDemoNotification = true;
        } else {
            $this->validate();
            $this->user->save();
<<<<<<< HEAD
            Debugbar::info('User Saved');
            return redirect()->route(route: 'user-profile')->with('success', 'Your profile information has been successfully saved!');
=======

            Debugbar::info('User Saved');
            return redirect()->route('user-profile')->with('success', 'Your profile information has been successfully saved!');
>>>>>>> a2f031c (initial commit)
        }
    }

    public function render()
    {
        return view('livewire.user.profile.show');
    }
}
