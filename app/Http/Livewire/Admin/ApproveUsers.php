<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;

class ApproveUsers extends Component
{
<<<<<<< HEAD

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
=======
    public $selectedUserId;

    public function render()
    {
        // Fetch all users with the role 'user'
        $users = Role::where('role', 'user')->get();
        return view('livewire.approve-users', ['users' => $users]);
    }

    // Method to select a user for rejection
    public function selectUser($userId)
    {
        $this->selectedUserId = $userId;
    }

    // Method to approve the user
    public function approve($userId)
    {
        $user = User::find($userId);

        if ($user) {
            $user->role = 'staff';
            $user->save();

            session()->flash('success', 'User approved successfully!');
        } else {
            session()->flash('error', 'User not found.');
        }
    }

    // Method to reject the user
    public function reject()
    {
        $user = User::find($this->selectedUserId);

        if ($user) {
            $user->role = 'reject';
            $user->save();

            session()->flash('success', 'User rejected successfully!');
        } else {
            session()->flash('error', 'User not found.');
        }
>>>>>>> fe358c2e4a2d91b18cbf05635aa0bd292e973e9a
    }
}
