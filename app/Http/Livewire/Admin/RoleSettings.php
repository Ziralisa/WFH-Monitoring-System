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

}
