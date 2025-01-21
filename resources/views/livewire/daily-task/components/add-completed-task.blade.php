<div class="modal fade" id="completedTaskModal" tabindex="-1" role="dialog" aria-labelledby="completedTaskModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="completedTaskModalLabel">Add
                    Completed Tasks for Today</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <select class="form-select" wire:model="selectedTaskId">
                    <option selected disabled></option>
                    <option value="test">Select an unassigned task</option>
                    @forelse ($assignedTasks as $task)
                        <option value="{{ $task->id }}">
                            {{ $task->project->name }}: {{ $task->name }}
                        </option>
                    @empty
                        <option disabled>No assigned tasks available</option>
                    @endforelse
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn bg-gradient-primary" wire:click.prevent='addCompletedTaskToday'>Save
                    changes</button>
            </div>
        </div>
    </div>
</div>
