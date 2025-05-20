<!-- Modal -->
<div wire:ignore.self class="modal fade" id="approveUserModal" tabindex="-1"
aria-labelledby="approveUserModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="approveUserModalLabel">Are you
                sure you want to approve this user?</h1>
            <button type="button" class="btn-close"
                data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            You can change the user's role later in "Manage Staffs".
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary"
                data-bs-dismiss="modal">Cancel</button>
            <form wire:submit='confirmApprove'>
                <button type="submit" class="btn btn-primary">Yes</button>
            </form>
        </div>
    </div>
</div>
</div>
