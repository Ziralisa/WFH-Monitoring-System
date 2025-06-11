<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class googleController extends Controller
{
 // Login: store mode in session
    public function redirectToGoogleLogin()
    {
        Session::put('google_mode', 'login');
        return Socialite::driver('google')->redirect();
    }

    // Register: store mode in session
    public function redirectToGoogleRegister()
    {
        Session::put('google_mode', 'register');
        return Socialite::driver('google')->redirect();
    }

    // Unified Callback
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $mode = Session::pull('google_mode'); // get and remove

        $user = User::where('email', $googleUser->getEmail())->first();

        if ($mode === 'login') {
            if (!$user) {
                return redirect('/login')->with('error', 'No account found. Please sign up.');
            }

            Auth::login($user);
            return $this->redirectByRole($user);

        } elseif ($mode === 'register') {
            if ($user) {
                return redirect('/user-register')->with('error', 'Account already exists. Please log in.');
            }

            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => bcrypt(str()->random(16)),
            ]);

            $user->assignRole('admin'); // or admin/staff if needed

            Auth::login($user);
            return redirect()->route('company-registration'); // or onboarding page
        }

        return redirect('/login')->with('error', 'Invalid access.');
    }

    private function redirectByRole($user)
    {
        if ($user->hasRole('user')) {
            return redirect()->route('new-user-homepage');
        } elseif ($user->hasRole('staff')) {
            return redirect()->route('take-attendance');
        } elseif ($user->hasRole('admin')) {
            return redirect()->route('dashboard');
        }

        return redirect('/login');
    }

}
