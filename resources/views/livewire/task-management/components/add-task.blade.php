<div>
    <!-- Add Task Button -->
    <button class="btn btnaddtask mt-3" data-bs-toggle="modal" data-bs-target="#addTaskModal-{{ $sprint->id }}">
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
                    <div class="mx-3">
                        <label for="project_id" class="form-label">Select Project</label>
                        <select name="project_id" id="project_id-{{ $sprint->id }}" class="form-control" required
                            onchange="loadTasks(this.value, '{{ $sprint->id }}')">
                            <option value="" disabled selected>Select Project</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Task Selection -->
                    <div class="mx-3">
                        <label for="task_id-{{ $sprint->id }}" class="form-label">Select Task</label>
                        <select name="task_id" id="task_id-{{ $sprint->id }}" class="form-control" required>
                            <option value="" disabled selected>Select Task</option>
                        </select>
                    </div>

                    <!-- Task Description -->
                    <div class="mx-3">
                        <label for="task_description-{{ $sprint->id }}" class="form-label">Task Description</label>
                        <textarea name="task_description" id="task_description-{{ $sprint->id }}" class="form-control" rows="3"
                            placeholder="Enter task description"></textarea>
                    </div>


                    <!-- Priority -->
                    <div class="row">
                        <div class="col-md-6 mx-3">
                            <label for="task_priority" class="form-label">Priority</label>
                            <select name="task_priority" id="task_priority" class="form-select" required>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mx-3">
                            <label for="task_status" class="form-label">Status</label>
                            <select name="task_status" id="task_status" class="form-select" required>
                                <option value="To Do">To Do</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Done">Done</option>
                            </select>
                        </div>
                    </div>

                    <!-- Assign User -->
                    <div class="mx-3">
                        <label for="task_assign" class="form-label">Assign Task (Optional)</label>
                        <select name="task_assign" id="task_assign" class="form-select">
                            <option value="" disabled selected>Select a user (optional)</option>
                            @foreach ($staff as $member)
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btnclose" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btntask">Add Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<style>
    .btnaddtask {
        background-color: #2657c1;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 7px;
        cursor: pointer;
        font-size: 10px;
    }

    .btnaddtask:hover {
        background-color: #1a4a9c;
        color: white;
    }

    .btnproject, .btntask {
        background-color: #2657c1;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 7px;
        cursor: pointer;
        font-size: 10px;
    }

    .btnproject:hover, .btntask:hover {
        background-color: #2657c1;
        color: white;
    }

    .btnclose {
        background-color: #7f9dde;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 7px;
        cursor: pointer;
        font-size: 10px;
    }

    .btnclose:hover {
        background-color: #7f9dde;
        color: white;
    }
</style>
<script>
    function loadTasks(projectId, sprintId) {
        if (projectId) {
            fetch(/tasks/${projectId}/${sprintId})
                .then(response => response.json())
                .then(data => {
                    console.log("Fetched Tasks:", data);

                    let taskDropdown = document.getElementById(task_id-${sprintId});
                    let taskDescription = document.getElementById(task_description-${sprintId});

                    if (!taskDropdown || !taskDescription) {
                        console.error("Dropdown or description field not found!");
                        return;
                    }

                    // Clear existing options
                    taskDropdown.innerHTML = '<option value="" disabled selected>Select Task</option>';

                    data.forEach(task => {
                        console.log("Task Data:", task);

                        let option = document.createElement("option");
                        option.value = task.id;
                        option.textContent = task.name;

                        // Check if 'task description' exists
                        if (task.task_description) {
                            option.setAttribute("data-description", task.task_description);
                        } else {
                            console.warn(Task ${task.id} has no description!);
                        }

                        taskDropdown.appendChild(option);
                    });

                    // Reset task description
                    taskDescription.value = '';

                    taskDropdown.onchange = function() {
                        let selectedTask = taskDropdown.options[taskDropdown.selectedIndex];
                        let description = selectedTask.getAttribute("data-description") ||
                            'No description available';
                        console.log("Selected Task Description:",
                        description); // Debug: Log selected task description
                        taskDescription.value = description;
                    };
                })
                .catch(error => {
                    console.error('Error fetching tasks:', error);
                });
        }
    }
</script>