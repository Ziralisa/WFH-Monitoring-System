<div>
    <h1 class="m-4">Roles</h1>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="card-header pb-0">
                    <button type="button" class="btn bg-gradient-info new-button"
                        data-toggle="modal"
                        data-target="#newRoleModal">
                        New Role</button>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        No.</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Role Name</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Description</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                        style="width: 150px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allRolesInDatabase as $role)
                                    <tr>
                                        <td class="text-xs text-center font-weight-bold mb-0">{{ $loop->iteration }}
                                        </td>
                                        <td class="text-xs text-center font-weight-bold mb-0">{{ $role->name }}</td>
                                        <td class="text-xs text-center font-weight-bold mb-0">{{ $role->desc }}</td>
                                        <td class="text-xs text-center font-weight-bold mb-0">
                                            <button type="button" class="btn btn-warning edit-button btn-sm"
                                                data-id="{{ $role->id }}" data-name="{{ $role->name }}"
                                                data-desc="{{ $role->desc }}"
                                                data-toggle="modal" data-target="#editRoleModal{{ $role->id }}">
                                                Edit Info
                                            </button>
                                            <form action="{{ route('admin.role.delete', $role->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this role?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <!-- Edit Role Modal -->
                                    @include('livewire.admin.role-settings.components.edit-modal')
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--New Role Modal-->
                @include('livewire.admin.role-settings.components.new-modal')
                <!-- Confirmation Modal -->
                @include('livewire.admin.role-settings.components.confirm-modal')
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function setFormAction(action) {
        document.getElementById('confirmDeleteForm').action = action;
    }
    $('.edit-button').on('click', function() {
        const roleId = $(this).data('id');
        const roleName = $(this).data('name');
        const roleDesc = $(this).data('desc');
        // Target the correct modal and set values
        const modal = $('#editRoleModal' + roleId);
        modal.find('#edit-name').val(roleName);
        modal.find('#edit-desc').val(roleDesc);
        // Set the form action with the role ID
        modal.find('#editRoleForm').attr('action', '/admin/role/' + roleId);
    });
    $('.new-button').on('click', function() {
        // Set the form action with the role ID
        modal.find('#newRoleForm').attr('action', '/admin/role/new');
    });
</script>
