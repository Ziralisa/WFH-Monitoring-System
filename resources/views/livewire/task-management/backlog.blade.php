<x-layouts.base>
    @includeIf('layouts.navbars.auth.sidebar') <!-- Sidebar -->
    @includeIf('layouts.navbars.auth.nav') <!-- Navbar -->

    <main class="main-content mt-1 border-radius-lg">
        <div class="container mt-4">
            <h1 class="mb-4">Backlog</h1>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Add Sprint Form -->
            <form action="{{ route('create-sprint') }}" method="POST">
                @csrf
                <div class="d-flex align-items-center mb-3">
                    <label for="name" class="mr-2">Sprint</label>
                    <input type="text" name="name" id="name" class="mr-2" required>

                    <label for="desc" class="mr-2">Description</label>
                    <textarea name="desc" id="desc" class="mr-2" required></textarea>

                    <label for="startdate" class="mr-2">Start Date</label>
                    <input type="date" name="startdate" id="startdate" class="mr-2" required>

                    <label for="enddate" class="mr-2">End Date</label>
                    <input type="date" name="enddate" id="enddate" class="mr-2" required>

                    <button type="submit" class="btn btn-primary">Add Sprint</button>
                </div>
            </form>

            <h2>Sprints</h2>

            @forelse($sprints as $sprint)
                <div class="sprint-card">
                    <h3>{{ $sprint->name }}</h3>
                    <p>{{ $sprint->desc }}</p>
                    <div class="sprint-dates">
                        <span><strong>Start Date:</strong> {{ $sprint->startdate }}</span>
                        <span><strong>End Date:</strong> {{ $sprint->enddate }}</span>
                    </div>

                    <!-- Display task table -->
                    <table class="table modern-table">
                        <thead>
                            <tr>
                                <th>Task</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Assign</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sprint->tasks as $task)
                                <tr>
                                    <td>{{ $task->name }}</td>
                                    <td>{{ $task->task_description }}</td>
                                    <td>
                                        <form>
                                            <select id="task-status-{{ $task->id }}" class="task-status"
                                                data-task-id="{{ $task->id }}" required>
                                                <option value="To Do" {{ $task->task_status == 'To Do' ? 'selected' : '' }}>To Do
                                                </option>
                                                <option value="In Progress" {{ $task->task_status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="Done" {{ $task->task_status == 'Done' ? 'selected' : '' }}>Done
                                                </option>
                                                <option value="Stuck" {{ $task->task_status == 'Stuck' ? 'selected' : '' }}>Stuck
                                                </option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>{{ $task->task_priority }}</td>
                                    <td>
                                        @if($task->assignedUser)
                                            {{ $task->assignedUser->name }}
                                        @else
                                            <form action="{{ route('assign-task', $task->id) }}" method="POST">
                                                @csrf
                                                <select name="task_assign" class="form-select" required>
                                                    <option value="" disabled selected>Select a user</option>
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="btn btn-primary btn-sm mt-2">Assign</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No tasks available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Add Task Button -->
                    <button class="btn btn-success mt-3" data-bs-toggle="modal"
                        data-bs-target="#addTaskModal-{{ $sprint->id }}">
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
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('tasks.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="sprint_id" value="{{ $sprint->id }}">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="task_name" class="form-label">Task Name</label>
                                            <input type="text" name="name" id="task_name" class="form-control"
                                                placeholder="Enter task name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="task_description" class="form-label">Task Description</label>
                                            <textarea name="task_description" id="task_description" class="form-control"
                                                rows="3" placeholder="Enter task description"></textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="task_priority" class="form-label">Priority</label>
                                                <select name="task_priority" id="task_priority" class="form-select"
                                                    required>
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
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Add Task</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>
            @empty
                <div class="no-sprints">No sprints added yet.</div>
            @endforelse

        </div>
    </main>

    <style>
        .sprint-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 24px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .sprint-card h3 {
            margin: 0 0 8px;
            color: #2c3e50;
        }

        .sprint-card .sprint-dates span {
            display: inline-block;
            margin-right: 16px;
            font-size: 14px;
            color: #7f8c8d;
        }

        .modern-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        .modern-table th,
        .modern-table td {
            padding: 12px 16px;
            text-align: left;
        }

        .modern-table th {
            background-color: #f4f6f9;
            font-weight: bold;
            color: #2c3e50;
            border-bottom: 2px solid #ddd;
        }

        .modern-table td {
            border-bottom: 1px solid #ddd;
        }

        .modern-table tr:hover {
            background-color: #f9f9f9;
        }

        .status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            color: white;
        }

        .status-in-progress {
            background-color: #3498db;
        }

        .status-completed {
            background-color: #2ecc71;
        }

        .status-pending {
            background-color: #e74c3c;
        }

        .no-sprints {
            text-align: center;
            color: #7f8c8d;
        }

        .text-center {
            text-align: center;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.task-status').forEach(function (element) {
                element.addEventListener('change', function () {
                    let taskId = this.dataset.taskId;
                    let status = this.value;

                    // AJAX request to update task status
                    fetch(`/tasks/${taskId}/status`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ task_status: status })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Task status updated successfully');
                            } else {
                                alert('Failed to update task status');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
</x-layouts.base>