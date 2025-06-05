<div class="modal fade" id="inprogressTaskModal" tabindex="-1" role="dialog" aria-labelledby="inprogressTaskModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="inprogressTaskModalLabel">
                    Add To-Do Task for Today
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Dropdown for unassigned tasks -->
                <select class="form-select mb-3" wire:model="selectedTaskId">
                    <option selected hidden>Select an unassigned task</option>
                    @forelse ($unassignedTasks as $task)
                        <option value="{{ $task->id }}">
                            {{ $task->project->name }}: {{ $task->name }}
                        </option>
                    @empty
                        <option disabled>No tasks available</option>
                    @endforelse
                </select>

                <!-- OR separator -->
                <div class="text-center my-3">OR</div>

                <!-- Input for custom task -->
                <input type="text" class="form-control mb-3" wire:model="customTaskTitle"
                    placeholder="Enter open task title">

                <!-- Feedback messages -->
                @error('customTaskTitle') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" wire:click="addCustomTaskToday">Add Custom Task</button>
                <button type="button" class="btn btn-success" wire:click="addInprogressTaskToday">Add Selected Task</button>
            </div>
        </div>
    </div>
</div>