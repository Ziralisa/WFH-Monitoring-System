<style>
    a {
        margin-right: 10px;
        margin-left: 10px;
    }
    .buttonedit i {
        color: rgb(255, 191, 0);
    }

    .buttondelete i {
        color: rgb(234, 69, 33);
    }

    table th,
    table td {
        border: none !important;
    }

    .outer-border {
        border: 1px solid black;
        border-radius: 8px;
        border-collapse: separate;
        border-spacing: 0;
        overflow: hidden;
        width: 1000px;
        margin: 0 auto 30px auto;
    }

    .head {
        background-color: #0070ff;
        color: rgb(255, 255, 255);
    }

    tbody tr {
        background-color: #f8f8f8;
        color: black;
    }

    table thead th:first-child {
        border-top-left-radius: 8px;
    }

    table thead th:last-child {
        border-top-right-radius: 8px;
    }

    table tbody tr:last-child td:first-child {
        border-bottom-left-radius: 8px;
    }

    table tbody tr:last-child td:last-child {
        border-bottom-right-radius: 8px;
    }
    table tbody tr:hover {
        background-color: #d4e2ff;
        cursor: pointer;
        color: #000000;
    }
    
    .outer-border {
        border: 1px solid rgb(255, 255, 255);
        border-radius: 10px;
        border-collapse: separate;
        border-spacing: 0;
        overflow: hidden; 
        min-width: 600px;
        width: 100%;
        max-width: 1000px;
        margin: 0 auto 30px auto;
    }
</style>

<div class="mt-3">
    <h4 class="m-4"><b>USERS</b></h4>
    <div><livewire:send-invitation-form/></div>

    <div class="col-12">
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

            <div class="usertable table-responsive mt-3 mb-5">
                <table class="table align-items-center mb-0 modern-table outer-border">
                    <thead>
                        <tr class="head">
                            <th class="text-center" style="width:5%">No.</th>
                            <th class="text-center" style="width:15%">Name</th>
                            <th class="text-center" style="width:15%">Email</th>
                             <th class="text-center" style="width:5%">Role</th>
                            <th class="text-center" style="width:5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $user)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">{{ $user->name }}</td>
                            <td class="text-center">{{ $user->email }}</td>
                            <td class="text-center">{{ $user->getRoleNames()->implode(', ') }}</td>
                            <td class="text-center">
                                <a wire:click="edit({{ $user->id }})" class="buttonedit" data-bs-toggle="modal" data-bs-target="#editUserModal">
                                    <i class="fas fa-edit" style="font-size: 17px;"></i>
                                </a>

                                <a wire:click="delete({{ $user->id }})" class="buttondelete" wire:confirm="Are you sure you want to delete this user?">
                                    <i class="fas fa-trash-alt" style="font-size: 17px;"></i>
                                </a>
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
        @include('livewire.admin.user-settings.components.edit-modal')
    </div>
</div>
