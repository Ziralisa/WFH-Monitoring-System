<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Http\Request;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class RoleSettings extends Component
{

    public function render()
    {
        $allRolesInDatabase = Role::all();

        return view('livewire.admin.role-settings.show', ['allRolesInDatabase' => $allRolesInDatabase]);
    }

    public function index()
    {
        return $this->render();
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:20',
            'desc' => 'required|string|min:5',
            'permissions' => 'array',
            'permissions.*' => 'string',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'desc' => $request->desc
        ]);

        $role->syncPermissions($request->permissions);

        return redirect()->route('admin.role')->with('success', 'Role created successfully');

    }

    public function update(Request $request, $id)
    {
        //dd($request->all());
        $request->validate([
            'name' => 'required|string|max:20',
            'desc' => 'required|string|min:5',
            'permissions' => 'array',
            'permissions.*' => 'string',
        ]);


        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->desc = $request->desc;
        $role->save();

        $role->syncPermissions($request->permissions);

        return redirect()->route('admin.role')->with('success', 'Role updated successfully');
    }

    public function delete($id){
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('admin.role')->with('success', 'Role deleted successfully');

    }

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSettings extends Component
{
    public $roles,
        $editRole,
        $name,
        $desc,
        $permissions,
        $selectedPermissions = [];

    public function mount()
    {
        $this->roles = Role::all();
        $this->permissions = Permission::all(); // Fetch all permissions
    }

    public function edit($id)
    {
        $this->editRole = Role::find($id);
        $this->name = $this->editRole->name;
        $this->desc = $this->editRole->desc;
        $this->selectedPermissions = $this->editRole->permissions->pluck('name')->toArray(); // Pre-select permissions
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|min:3|max:70',
            'desc' => 'nullable|min:5|max:240',
        ]);

        $this->editRole->update([
            'name' => $this->name,
            'desc' => $this->desc,
        ]);

        $this->editRole->syncPermissions($this->selectedPermissions); // Sync permissions
        return redirect()->route('admin.role')->with('success', 'Role updated successfully!');
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:20',
            'desc' => 'nullable|string|min:5|max:240',
            'selectedPermissions' => 'array', // Ensure permissions are validated
            'selectedPermissions.*' => 'string',
        ]);

        $role = Role::create([
            'name' => $this->name,
            'desc' => $this->desc,
        ]);

        $role->syncPermissions($this->selectedPermissions);

        return redirect()->route('admin.role')->with('success', 'Role created successfully!');
    }

    public function delete($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('admin.role')->with('success', 'Role deleted successfully!');
    }

    public function render()
    {
        return view('livewire.admin.role-settings.show', [
            'roles' => $this->roles,
        ]);
    }

}
