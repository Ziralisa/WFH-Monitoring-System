<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\User;

class ApproveUsers extends Component
{
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
