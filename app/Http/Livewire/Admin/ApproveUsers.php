<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;

class ApproveUsers extends Component
{

    public $user_id;

    public function approve(User $user){
        $this->user_id = $user->id;

    }
    public function confirmApprove() {
        $user = User::find($this->user_id);
        $user->assignRole('staff');
        $user->removeRole('user');
        session()->flash('success', 'User '.$user->name.' approved successfully!');
    }


    public function reject(User $user){

        $user->update([
            'reject_status'=>1,
        ]);

    }

    public function render()
    {
        $users = User::role('user')->get();
        //dd($users);
        return view('livewire.admin.approve-users', compact('users'));
    }
}
