<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        // Ensure the user has the admin role
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        // Fetch users based on the filter applied
        if ($request->get('filter') == 'resigned') {
            // Fetch users with the 'resign' role
            $staffQuery = User::role('resign');
        } else {
            // Fetch users with the 'staff' role by default
            $staffQuery = User::role('staff');
        }

        $staff = $staffQuery->get();
        return view('livewire.admin.staff-list', compact('staff'));
    }

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

    public function removeRole($id)
    {
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

    public function delete($id)
    {
        $staff = User::findOrFail($id); // Find the user by their ID

        // Perform the deletion
        $staff->delete();

        return redirect()->route('admin.staff-list')->with('success', 'Staff member deleted successfully');
    }
}

