<div class="modal fade" id="inprogressTaskModal" tabindex="-1" role="dialog" aria-labelledby="inprogressTaskModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="inprogressTaskModalLabel">
                    Add In Progress Task for Today
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div data-bs-dismiss="modal">
                    <svg width="20px" height="20px" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 21.32L21 3.32001" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 3.32001L21 21.32" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                </div>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btnproject" wire:click="addInprogressTaskToday" style="font-size: 12px;">Add Selected Task</button>
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
        font-size: 20px;
    }

    .btnproject:hover, .btntask:hover {
        background-color: #0070ff;
        color: white;
    }
</style>