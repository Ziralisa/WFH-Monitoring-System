<style>
    .btnsave {
        background-color: #0070ff;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 7px;
        cursor: pointer;
        font-size: 12px;
    }

    .btnsave:hover {
        background-color: #4395ff;
        color: white;
    }
</style>

<div wire:ignore.self class="modal fade" id="editRoleModal" tabindex="-1"
                aria-labelledby="editRoleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>

                                            <div data-bs-dismiss="modal">
                    <svg width="20px" height="20px" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 21.32L21 3.32001" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 3.32001L21 21.32" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                </div>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-3">
                                    <label for="roleName" class="form-label">Role Name</label>
                                    <input type="text" class="form-control" id="roleName" wire:model="name">
                                </div>
                                <div class="mb-3">
                                    <label for="roleDesc" class="form-label">Description</label>
                                    <textarea class="form-control" id="roleDesc" wire:model="desc"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="permissions">Permissions</label>
                                    @foreach ($permissions as $permission)
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="permission-{{ Str::slug($permission->name) }}"
                                                wire:model="selectedPermissions" {{-- Bind to Livewire --}}
                                                value="{{ $permission->name }}">
                                            <label class="form-check-label"
                                                for="permission-{{ Str::slug($permission->name) }}">
                                                {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btnsave" wire:click="update">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>