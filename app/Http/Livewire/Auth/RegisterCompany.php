<?php

namespace App\Http\Livewire\Auth;

use Auth;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;

class RegisterCompany extends Component
{
     public $company_name = '';
    public $registration_no = '';
    public $address = '';
    public $contact_email = '';
    public $contact_phone = '';

    // public $name = '';
    // public $email = '';
    // public $password = '';
    // public $password_confirmation = '';


    protected $rules = [
        'company_name' => 'required|min:3',
        'registration_no' => 'required|min:3',
        'address' => 'required|min:3',
        'contact_email' => 'required|email:rfc,dns|unique:companies',
        'contact_phone' => 'required|min:3',
        // 'name' => 'required|min:3',
        // 'email' => 'required|email:rfc,dns|unique:users',
        // 'password' => 'required|min:6'
    ];

//     public function mount() {
//         if(auth()->user()){
//             redirect('/dashboard');
//         }
// }

public function createcompany()
{
    $this->validate([
        'company_name' => 'required|string|max:255',
        'registration_no' => 'required|string|max:255|unique:companies,registration_no',
        'address' => 'required|string|max:255',
        'contact_email' => 'required|email|max:255',
        'contact_phone' => 'required|string|max:20',

        // 'name' => 'required|min:3',
        // 'email' => 'required|email|unique:users',
        // 'password' => 'required|min:6|same:password_confirmation',
        
    ]);

    $company = Company::create([
        'company_name' => $this->company_name,
        'registration_no' => $this->registration_no,
        'address' => $this->address,
        'contact_email' => $this->contact_email,
        'contact_phone' => $this->contact_phone,
    ]);

    // $user = User::create([
    //     'name' => $this->name,
    //     'email' => $this->email,
    //     'password' => Hash::make($this->password),
    //     'company_id' => $company->id,
    //     // 'company_id' => $company->id,
    // ]);

    //     // Assign role to the user
    //     $user->assignRole('admin');

    $user = Auth::user();
    $user->company_id = $company->id;
    $user->save();

    session()->flash('success', 'Company registered successfully!');
    return redirect()->route('login');
}
    public function render()
    {
        return view('livewire.register-company');
    }
}
