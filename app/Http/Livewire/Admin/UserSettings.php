<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Livewire\Component;

class UserSettings extends Component
{
    public function render(Request $request)
    {
         // Ensure the user has the admin role
         if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        // Fetch users based on the filter applied
        if ($request->get('filter') == 'resigned') {
            $userQuery = User::role('resign');

        } elseif($request->get('filter') == 'admin') {
            $userQuery = User::role('admin');

        } elseif($request->get('filter') == 'staff') {
            $userQuery = User::role('staff');

        } elseif($request->get('filter') == 'user'){
            $userQuery = User::role('user');

        } else {
            $userQuery = User::query();
        }

        $users = $userQuery->get();


        return view('livewire.admin.user-settings.show', compact('users'));
    }

    public function index(Request $request)
    {
        // Ensure the user has the admin role
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        $users = User::get();

        return view('livewire.admin.user-settings', compact('users'));
    }

    public function update(Request $request, $id)
    {


        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|in:admin,staff,resign,user',
        ]);


        $user = User::findOrFail($id);
        $user->update($request->only('name', 'email', 'phone', 'location'));
        $user->syncRoles([]);


        $selectedRole = $request->input('role');

        if($selectedRole == 'admin'){
            $user->assignRole('admin');
            $user->assignRole('staff');
        } elseif ($selectedRole == 'staff'){
            $user->assignRole('staff');
        } elseif ($selectedRole == 'resign') {
            $user->assignRole('resign');
        } elseif ($selectedRole == 'user'){
            $user->assignRole('user');
        }


        return redirect()->route('admin.user-settings')->with('success', 'User updated successfully');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id); // Find the user by their ID

        // Perform the deletion
        $user->delete();

        return redirect()->route('admin.user-settings')->with('success', 'User deleted successfully');
    }



}
