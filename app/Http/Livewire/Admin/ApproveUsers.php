<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class ApproveUsers extends Component
{

    public $user_id;

    public function approve(User $user){
        $this->user_id = $user->id;

    }
    public function confirmApprove() {
        $user = User::find($this->user_id);
        $user->assignRole('staff');
        session()->flash('success', 'User '.$user->name.' approved successfully!');
    }


    public function reject(User $user){

        $user->update([
            'reject_status'=>1,
        ]);

    }

    public function render()
    {
        $users = User::all();
        return view('livewire.admin.approve-users', compact('users'));
    }
}
