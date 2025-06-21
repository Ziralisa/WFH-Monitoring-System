<div class="modal fade" id="completedTaskModal" tabindex="-1" role="dialog" aria-labelledby="completedTaskModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="completedTaskModalLabel">Add
                    Completed Task for Today</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div data-bs-dismiss="modal">
                    <svg width="20px" height="20px" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 21.32L21 3.32001" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 3.32001L21 21.32" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                </div>
            </div>
            <div class="modal-body">
                <select class="form-select" wire:model="selectedTaskId">
                <option selected hidden>Select an unassigned task</option>
                    @forelse ($assignedTasks as $task)
                        <option value="{{ $task->id }}">
                            {{ $task->project->name }}: {{ $task->name }}
                        </option>
                    @empty
                        <option disabled>No assigned tasks available</option>
                    @endforelse

                    <!-- Display custom tasks from log_tasks -->
                    <optgroup label="Custom Tasks">
                        @forelse ($customTasks as $customTask)
                            <option value="{{ $customTask->id }}">
                                {{ $customTask->title }}
                            </option>
                        @empty
                            <option disabled>No custom tasks available</option>
                        @endforelse
                    </optgroup>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btnproject" wire:click.prevent='addCompletedTaskToday' style="font-size: 12px;">Save changes</button>
            </div>
        </div>
    </div>
</div>
<style>
    .btnproject, .btntask {
        background-color: #0070ff;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 7px;
        cursor: pointer;
    }

    .btnproject:hover, .btntask:hover {
        background-color: #0070ff;
        color: white;
    }
</style>