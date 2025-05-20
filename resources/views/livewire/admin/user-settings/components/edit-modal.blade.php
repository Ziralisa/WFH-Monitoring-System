<div wire:ignore.self class="modal fade" id="editUserModal" tabindex="-1" role="dialog"
    aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User Details</h5>
            </div>
            <div class="modal-body">
                <form>
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="edit-name" wire:model="name" required>
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="edit-email" wire:model="email" required>
                        @error('email')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="role">Role</label>
                        <select class="form-select" id="edit-role" wire:model="role" required>
                            <option value="" disabled>Select a role</option>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                            <option value="resign">Resigned</option>
                            <option value="user">User (Unapproved)</option>
                            <!-- Add more roles as needed -->
                        </select>
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="update">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>