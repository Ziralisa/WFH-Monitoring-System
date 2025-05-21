<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use App\Models\Invitation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class SignUp extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $token = ''; 
    public $company_id = ''; 

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email:rfc,dns|unique:users',
        'password' => 'required|min:6'
    ];

    public function mount() {
        // if(auth()->user()){
        //     redirect('/dashboard');
        // }

        $this->token = request()->query('token');

        // Lookup the invitation
        $invitation = Invitation::where('token', $this->token)->first();

        if (!$invitation) {
            abort(403, 'Invalid or expired invitation link.');
        }

        $this->email = $invitation->email;
        $this->company_id = $invitation->company_id;
    }

    public function register() {
        $this->validate();

            if (!$this->company_id) {
        abort(403, 'Company information is missing.');
            }

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'company_id' => $this->company_id,
            //Kodewave location by default
            'home_lat' => 3.0922698086381923,
            'home_lng' => 101.54353889438191,
        ]);

        $user->assignRole('staff');

        auth()->login($user);

        return redirect('take-attendance');
    }

    public function render()
    {
        return view('livewire.auth.sign-up');
    }
}
