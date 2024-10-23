<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SignUp extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email:rfc,dns|unique:users',
        'password' => 'required|min:6'
    ];

    public function mount() {
        if(auth()->user()){
            redirect('/dashboard');
        }
    }

    public function register() {
        $this->validate();
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            //Kodewave location by default
            'home_lat' => 3.0922698086381923,
            'home_lng' => 101.54353889438191,
        ]);

        $user->assignRole('user');

        auth()->login($user);

        return redirect('new-user-homepage');
    }

    public function render()
    {
        return view('livewire.auth.sign-up');
    }
}
