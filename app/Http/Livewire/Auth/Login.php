<?php

namespace App\Http\Livewire\Auth;

use Auth;
use Livewire\Component;
use App\Models\User;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember_me = false;

    protected $rules = [
        'email' => 'required|email:rfc,dns',
        'password' => 'required',
    ];

    public function mount() {
        if (auth()->user()) {
            redirect('new-user-homepage');
        }

        /*
        $user = Auth::user();

        if (auth()->user()) {
            if($user->hasRole('user'))
                return redirect('new-user-homepage');
            else
               return redirect('dashboard');
        }
        */

        $this->fill(['email' => '@gmail.com', 'password' => '1234567']);
    }

    public function login() {
        $credentials = $this->validate();
        if(auth()->attempt(['email' => $this->email, 'password' => $this->password], $this->remember_me)) {
            $user = User::where(["email" => $this->email])->first();
            auth()->login($user, $this->remember_me);
            
            if($user->hasRole('user'))
                return redirect()->intended(default: 'new-user-homepage');
            else
                return redirect()->intended(default: 'dashboard');
        }
        else{
            return $this->addError('email', trans('auth.failed'));
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
