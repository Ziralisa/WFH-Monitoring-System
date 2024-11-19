<div class="modal fade" id="editRoleModal{{ $role->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoleModalLabel">Edit Role Details
                </h5>
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
                        <input type="text" class="form-control" id="edit-name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Description</label>
                        <input type="text" class="form-control" id="edit-desc" name="desc" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Permissions</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch"
                                id="flexSwitchCheckDefault-viewStaffDashboard" name="permissions[]"
                                value="view staff dashboard"
                                {{ $role->hasPermissionTo('view staff dashboard') ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexSwitchCheckDefault-viewStaffDashboard">View
                                staff dashboard</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch"
                                id="flexSwitchCheckDefault-viewAdminDashboard" name="permissions[]"
                                value="view admin dashboard"
                                {{ $role->hasPermissionTo('view admin dashboard') ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexSwitchCheckDefault-viewAdminDashboard">View
                                admin dashboard</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch"
                                id="flexSwitchCheckDefault-viewTakeAttendance" name="permissions[]"
                                value="view take attendance"
                                {{ $role->hasPermissionTo('view take attendance') ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexSwitchCheckDefault-viewTakeAttendance">View
                                take attendance</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch"
                                id="flexSwitchCheckDefault-viewAttendanceReport" name="permissions[]"
                                value="view attendance report"
                                {{ $role->hasPermissionTo('view attendance report') ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexSwitchCheckDefault-viewAttendanceReport">View
                                attendance report</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch"
                                id="flexSwitchCheckDefault-viewApproveUsers" name="permissions[]"
                                value="view approve users"
                                {{ $role->hasPermissionTo('view approve users') ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexSwitchCheckDefault-viewApproveUsers">View
                                approve users</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch"
                                id="flexSwitchCheckDefault-viewStaffList" name="permissions[]" value="view staff list"
                                {{ $role->hasPermissionTo('view staff list') ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexSwitchCheckDefault-viewStaffList">View
                                staff list</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch"
                                id="flexSwitchCheckDefault-viewUserSettings" name="permissions[]"
                                value="view user settings"
                                {{ $role->hasPermissionTo('view user settings') ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexSwitchCheckDefault-viewUserSettings">View
                                user settings</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch"
                                id="flexSwitchCheckDefault-viewRoleSettings" name="permissions[]"
                                value="view role settings"
                                {{ $role->hasPermissionTo('view role settings') ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexSwitchCheckDefault-viewRoleSettings">View
                                role settings</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Update Role</button>
                </form>
            </div>
        </div>
    </div>
</div>
