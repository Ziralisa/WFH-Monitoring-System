<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;

class ApproveUsers extends Component
{
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
    }
}
