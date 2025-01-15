<div class="modal fade" id="todoTaskModal" tabindex="-1" role="dialog" aria-labelledby="todoTaskModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="todoTaskModalLabel">
                    Add To-Do Tasks for Today
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <select class="form-select" wire:model="selectedTaskId">
                    <option selected disabled>Select an unassigned task</option>
                    @forelse ($unassignedTasks as $task)
                        <option value="{{ $task->id }}">
                            <strong>Task {{ $task->id }}</strong> -
                            {{ $task->name }}
                        </option>
                    @empty
                        <option disabled>No unassigned tasks available</option>
                    @endforelse
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="button" wire:click.prevent="addTodoTaskToday" class="btn bg-gradient-primary">
                    Save changes
                </button>
            </div>
        </div>
    </div>
</div>
