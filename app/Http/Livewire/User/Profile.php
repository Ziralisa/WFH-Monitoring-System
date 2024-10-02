<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Profile extends Component
{

    public User $user;
    public $showSuccesNotification  = false;

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

/*
     // Personal Information
     #[Validate('required|max:40|min:3')]
     public $first_name = '';
     #[Validate('required|max:40|min:3')]
     public $last_name = '';
     #[Validate('required|date')]
     public $birthdate = '';
     #[Validate('required|in:male,female,other')]
     public $gender = '';
     #[Validate('required|email:rfc,dns')]
     public $email = '';
     #[Validate('required|max:15')]
     public $phone = '';
     #[Validate('required|max:40|min:10')]
     public $location1 = '';
     #[Validate('nullable|max:40')]
     public $location2 = '';
     #[Validate('required|min:3|max:40')]
     public $suburb = '';
     #[Validate('required|min:3|max:40')]
     public $state = '';
     // Job Information
     #[Validate('required|in:0,1')]
     public $job_status = '';
     #[Validate('required|max:40|min:3')]
     public $position = '';
     #[Validate('nullable|date')]
     public $started_work = '';
     #[Validate('nullable|email:rfc,dns')]
     public $work_email = '';
     #[Validate('nullable|max:15')]
     public $work_phone = '';
     // Emergency Contact
     #[Validate('nullable|max:40|min:3')]
     public $emergency_firstname = '';
     #[Validate('nullable|max:40|min:3')]
     public $emergency_lastname = '';
     #[Validate('nullable|min:5')]
     public $emergency_relation = '';
     #[Validate('nullable|max:15')]
     public $emergency_phone = '';
*/


    public function mount() {
        $this->user = auth()->user();
        $this->userId = $this->user->id;
    }

    public function save()
{
    if (env('IS_DEMO')) {
        $this->showDemoNotification = true;
    } else {
        $this->validate();
        $this->user->save();
        Debugbar::info('User Saved');
        return redirect()->route('user-profile')->with('success', 'Your profile information has been successfully saved!');
    }
}

    public function render()
    {
        return view('livewire.user.profile.show');
    }
}
