
<div>
    <style>
    .btnrole {
        background-color: #0070ff;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 10px;
        cursor: pointer;
        font-size: 12px;
    }

    .btnrole:hover {
        background-color: #4395ff;
        color: white;
    }

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
        border-radius: 8px;
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
    <h4 class="m-4"><b>ROLES</b></h4>
        <div class="col-12">
            @include('components.alerts.success')
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <button type="button" class="btn btnrole" data-bs-toggle="modal"data-bs-target="#newRoleModal">New Role</button>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="usertable table-responsive mt-3-mb-5">
                        <table class="table align-items-center mb-0 modern-table outer-border">
                            <thead>
                                <tr class="head text-center">
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
                                            <a class="buttonedit" wire:click="edit({{ $role->id }})" data-bs-toggle="modal" data-bs-target="#editRoleModal">
                                                <i class="fas fa-edit" style="font-size: 17px;"></i>
                                            </a>
                                            <a class="buttondelete" wire:click="delete({{ $role->id }})" wire:confirm="Are you sure you want to delete this role?">
                                                <i class="fas fa-trash-alt" style="font-size: 17px;"></i>
                                            </a>
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
