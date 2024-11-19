<div class="modal fade" id="editRoleModal{{ $role->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoleModalLabel">Edit Role Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editRoleForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="edit-name" name="name" value="{{ $role->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" id="edit-desc" name="desc" value="{{ $role->description }}" required>
                    </div>
                    <div class="form-group">
                        <label for="permissions">Permissions</label>
                        @php
                            $permissions = \Spatie\Permission\Models\Permission::all();
                        @endphp
                        @foreach ($permissions as $permission)
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" 
                                    id="permission-{{ Str::slug($permission->name) }}"
                                    name="permissions[]"
                                    value="{{ $permission->name }}"
                                    {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                <label class="form-check-label" for="permission-{{ Str::slug($permission->name) }}">
                                    {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Update Role</button>
                </form>
            </div>
        </div>
    </div>
</div>
