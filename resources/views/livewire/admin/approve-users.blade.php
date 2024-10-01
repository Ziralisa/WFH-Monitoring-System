<div>
    <!-- Check if there are no users to approve -->
    @if ($noUsersToApprove)
        <div class="alert alert-info">
            All users have been reviewed. No users awaiting approval at the moment.
        </div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Creation Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td><img src="{{ $user->photo_url }}" alt="{{ $user->name }}" width="50"></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ implode(', ', $user->getRoleNames()->toArray()) }}</td>
                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                        <td>
                            <!-- Trigger the approval confirmation -->
                            <button class="btn btn-success" wire:click="confirmAction({{ $user->id }}, 'approve')">Approve</button>
                            <!-- Trigger the rejection confirmation -->
                            <button class="btn btn-danger" wire:click="confirmAction({{ $user->id }}, 'reject')">Reject</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Modal for Confirmation -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">
                        @if ($actionType == 'approve')
                            Confirm Approval
                        @elseif ($actionType == 'reject')
                            Confirm Rejection
                        @endif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($actionType == 'approve')
                        Are you sure you want to approve this user?
                    @elseif ($actionType == 'reject')
                        Are you sure you want to reject this user? This action cannot be undone.
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <!-- Call performAction on confirmation -->
                    <button type="button" class="btn btn-success" wire:click="performAction">
                        @if ($actionType == 'approve')
                            Yes, Approve
                        @elseif ($actionType == 'reject')
                            Yes, Reject
                        @endif
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Livewire Event Listeners for Modal Control -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Open the modal when the openModal event is triggered
        window.addEventListener('openModal', event => {
            var modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            modal.show();
        });

        // Close the modal when the closeModal event is triggered
        window.addEventListener('closeModal', event => {
            var modal = bootstrap.Modal.getInstance(document.getElementById('confirmationModal'));
            if (modal) {
                modal.hide();
            }
        });
    });
</script>
