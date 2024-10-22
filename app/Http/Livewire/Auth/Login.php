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
        // If the user is already logged in, redirect them based on their role.
        if (auth()->check()) {
            $this->redirectByRole(auth()->user());
        }

        // Pre-fill email and password for easier testing
        $this->fill(['email' => '@gmail.com', 'password' => '1234567']);
    }

    public function login() {
        $credentials = $this->validate();

        // Attempt to log in the user
        if (auth()->attempt($credentials, $this->remember_me)) {
            $user = auth()->user();

            // Redirect the logged-in user based on their role
            return $this->redirectByRole($user);
        } else {
            // Add error message for invalid credentials
            return $this->addError('email', trans('auth.failed'));
        }
    }

    // Redirect user based on their role
    private function redirectByRole($user) {
        if ($user->hasRole('user')) {
            return redirect()->route('new-user-homepage');
        } elseif ($user->hasRole('staff')) {
            return redirect()->route('dashboard1');
        } elseif ($user->hasRole('admin')) {
            return redirect()->route('dashboard');
        }

        // Default redirect if no role matches
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
