<div class="mt-3 row">
    <h4 class="m-4"><b>USERS</b></h4>

    <div class="mb-4 mx-4">
        <livewire:send-invitation-form />
    </div> 
     
    <div class="col-12">
        <div class="row">
            @include('components.alerts.success')
            <div class="card mb-4 mx-4">
                <div class="card-header">
                    <div class="mb-4 mx-4">
                        <label for="filter" class="me-2">Filter User:</label>
                        <select wire:model="filter" wire:change='fetchUsers' class="form-select form-select-sm w-auto">
                            <option value="">All Users</option>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                            <option value="resign">Resigned Staff</option>
                            <option value="user">Unapproved</option>
                        </select>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Role</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $index => $user)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td class="text-center">{{ $user->name }}</td>
                                        <td class="text-center">{{ $user->email }}</td>
                                        <td class="text-center">{{ $user->getRoleNames()->implode(', ') }}
                                        </td>
                                        <td class="text-center">
                                            <button wire:click="edit({{ $user->id }})"
                                                class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editUserModal">Edit</button>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                wire:click="delete({{ $user->id }})"
                                                wire:confirm="Are you sure you want to delete this user?">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No users found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @include('livewire.admin.user-settings.components.edit-modal')
        </div>
    </div>
</div>