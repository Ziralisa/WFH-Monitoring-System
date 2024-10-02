<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\User;

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
    }
}
=======
    public $selectedUserId;
    public $actionType; // To track whether approving or rejecting

    public function render()
    {
        // Fetch all users with the role 'user'
        $users = User::role('user')->get();

        // Check if there are no users to approve
        $noUsersToApprove = $users->isEmpty();

        return view('livewire.admin.approve-users', [
            'users' => $users,
            'noUsersToApprove' => $noUsersToApprove, // Pass this variable to the Blade view
        ]);
    }

    // Method to open confirmation modal
    public function confirmAction($userId, $action)
    {
        $this->selectedUserId = $userId; // Set selected user ID
        $this->actionType = $action; // Set action type (approve/reject)
        $this->dispatch('openModal'); // Trigger the modal to open
    }

    // Method to perform the selected action (approve/reject)
    public function performAction()
    {
        $user = User::find($this->selectedUserId); // Fetch user by ID

        if ($user) {
            if ($this->actionType == 'approve') {
                // Assign the 'staff' role to the user
                $user->syncRoles('staff');
                session()->flash('success', 'User approved successfully!');
            } elseif ($this->actionType == 'reject') {
                // Delete the user from the database
                $user->delete();
                session()->flash('reject', 'User rejected and deleted successfully!');
            }
            // Close the modal after the action is performed
            $this->dispatch('closeModal');
        } else {
            session()->flash('error', 'User not found.');
        }
    }
}
>>>>>>> 79a5615aa9faf2b90247f9c6c49ca66143ffe5d6
