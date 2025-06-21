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
                    <div data-bs-dismiss="modal">
                        <svg width="20px" height="20px" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 21.32L21 3.32001" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 3.32001L21 21.32" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </div>
                </div>
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="sprint_id" value="{{ $sprint->id }}">


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
                        <button type="submit" class="btn btntask" style="font-size: 12px;">Add Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<style>
    .btnaddtask {
        background-color: #0070ff;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 7px;
        cursor: pointer;
        font-size: 12px;
    }

    .btnaddtask:hover {
        background-color: #0070ff;
        color: white;
    }

    .btnproject, .btntask {
        background-color: #0070ff;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 7px;
        cursor: pointer;
        font-size: 12px;
    }

    .btnproject:hover, .btntask:hover {
        background-color: #0070ff;
        color: white;
    }
</style>
<script>
    function loadTasks(sprintId) {

            fetch(`/tasks/sprint/${sprintId}`)
                .then(response => response.json())
                .then(data => {
                    console.log("Fetched Tasks:", data);

                    let taskDropdown = document.getElementById(`task_id-${sprintId}`);
                    let taskDescription = document.getElementById(`task_description-${sprintId}`);

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
                            console.warn(`Task ${task.id} has no description!`);
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
        document.addEventListener('DOMContentLoaded', function () {
            const modals = document.querySelectorAll('.modal');

            modals.forEach(modal => {
                modal.addEventListener('show.bs.modal', function (event) {
                    const modalId = this.getAttribute('id');
                    const sprintId = modalId.split('-')[1];
                    loadTasks(sprintId); 
                });
            });
        });
</script>