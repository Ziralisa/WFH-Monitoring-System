<div wire:ignore.self class="modal fade" id="newRoleModal" tabindex="-1"
                aria-labelledby="newRoleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="newRoleModalLabel">New Role</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" wire:click="store">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
