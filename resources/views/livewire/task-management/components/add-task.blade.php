<!-- Add Task Button -->
<button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#addTaskModal-{{ $sprint->id }}">
    Add Task
</button>

<!-- Add Task Modal -->
<div class="modal fade" id="addTaskModal-{{ $sprint->id }}" tabindex="-1"
    aria-labelledby="addTaskModalLabel-{{ $sprint->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTaskModalLabel-{{ $sprint->id }}">Add Task to
                    {{ $sprint->name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <input type="hidden" name="sprint_id" value="{{ $sprint->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="task_name" class="form-label">Task Name</label>
                        <input type="text" name="name" id="task_name" class="form-control" placeholder="Enter task name"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="task_description" class="form-label">Task Description</label>
                        <textarea name="task_description" id="task_description" class="form-control" rows="3"
                            placeholder="Enter task description"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="task_priority" class="form-label">Priority</label>
                            <select name="task_priority" id="task_priority" class="form-select" required>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="task_status" class="form-label">Status</label>
                            <select name="task_status" id="task_status" class="form-select" required>
                                <option value="To Do">To Do</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Done">Done</option>
                                <option value="Stuck">Stuck</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="task_assign" class="form-label">Assign Task (Optional)</label>
                        <select name="task_assign" id="task_assign" class="form-select">
                            <option value="" disabled selected>Select a user (optional)</option>
                            @foreach ($staff as $member)
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                            @endforeach
                        </select>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Task</button>
                </div>
            </form>

        </div>
    </div>
</div>