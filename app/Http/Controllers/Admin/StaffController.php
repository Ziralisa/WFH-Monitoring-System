<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        // Fetch users based on the filter applied
        if ($request->get('filter') == 'resigned') {
            // Fetch users with the 'resign' role
            $staffQuery = User::role('resign');
        } else {
            // Fetch users with the 'staff' role by default
            $staffQuery = User::role('staff');
        }

        // Get the final result
        $staff = $staffQuery->get();

        return view('livewire.admin.staff-list', compact('staff'));
    }

    // Update staff info
    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:13',
            'location' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
        ]);

        $staff = User::findOrFail($id);
        $staff->update($request->only('name', 'email', 'phone', 'location'));

        return redirect()->route('admin.staff-list')->with('success', 'Staff updated successfully');
    }

    // Remove staff role and reassign to 'resign'
    public function removeRole($id)
    {
        // Find the user by their ID
        $staff = User::findOrFail($id);

        // Check if the user has the 'staff' role
        if ($staff->hasRole('staff')) {
            // Remove the 'staff' role
            $staff->removeRole('staff');

            // Assign the 'resign' role to the user
            $staff->assignRole('resign');

            return redirect()->route('admin.staff-list')->with('success', 'Staff role removed and reassigned to resigned successfully');
        }

        return redirect()->route('admin.staff-list')->with('error', 'User does not have the staff role');
    }
}