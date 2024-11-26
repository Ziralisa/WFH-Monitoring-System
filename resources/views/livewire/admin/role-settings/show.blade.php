<div>
    <h1 class="m-4">Roles</h1>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="card-header pb-0">
                    <button type="button" class="btn bg-gradient-info" data-bs-toggle="modal"
                        data-bs-target="#newRoleModal">
                        New Role
                    </button>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Role Name</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $index => $role)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td class="text-center">{{ $role->name }}</td>
                                        <td class="text-center">{{ $role->desc }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-warning btn-sm"
                                                wire:click="edit({{ $role->id }})" data-bs-toggle="modal"
                                                data-bs-target="#editRoleModal">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                 wire:click="delete({{ $role->id }})"
                                                 wire:confirm="Are you sure you want to delete this role?"
                                                 >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Edit Role Modal -->
            @include('livewire.admin.role-settings.components.edit-modal')

            <!-- New Role Modal -->
            @include('livewire.admin.role-settings.components.new-modal')
            
        </div>
    </div>
</div>
