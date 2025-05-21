<?php
namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class UserSettings extends Component
{
    public $users;
    public $filter = '';
    public $name, $email, $role, $editUserId;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'role' => 'required|in:admin,staff,resign,user',
    ];

    public function mount()
    {
        $this->fetchUsers();
    }

    public function updatedFilter()
    {
        $this->fetchUsers();
    }

    public function fetchUsers()
    {
        $query = User::query()
        ->where('company_id', auth()->user()->company_id);
        if ($this->filter) {
            $query = $query::role($this->filter);
        }
        $this->users = $query->get();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->editUserId = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->getRoleNames()->first();
        $this->confirmingEdit = true;
    }

    public function update()
    {
        $validated = $this->validate([
            'name' => 'required|min:5',
            'email' => 'required|email',
        ]);
        $user = User::findOrFail($this->editUserId);
        $user->update($validated);
        $user->syncRoles([$this->role]);
        $this->fetchUsers();
        return redirect()->route('admin.user-settings')->with('success', 'User updated successfully');
    }
    public function delete($id)
    {
        User::findOrFail($id)->delete();
        $this->fetchUsers();
        return redirect()->route('admin.user-settings')->with('success', 'User deleted successfully');
    }

    public function render()
    {
        return view('livewire.admin.user-settings.show');
    }
}