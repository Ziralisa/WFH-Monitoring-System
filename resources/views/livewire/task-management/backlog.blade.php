<div>
    <div class="container mt-4">
        <h1 class="mb-4">Backlog</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Add Sprint Modal -->
        <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#SprintModal">
        Add Sprint
        </button>

        <div class="modal fade" id="SprintModal" tabindex="-1" role="dialog" 
            aria-labelledby="SprintModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="SprintModal">
                            New Sprint
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <form action="{{ route('create-sprint') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Sprint Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="desc" class="form-label">Description</label>
                            <textarea name="desc" id="desc" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="startdate" class="mr-2 px-2">Start Date</label>
                            <input type="date" name="startdate" id="startdate" class="mr-2 px-3" required>
                        </div>
                        <div class="mb-3">
                            <label for="enddate" class="mr-2 px-2">End Date</label>
                            <input type="date" name="enddate" id="enddate" class="mr-2 px-3" required>
                        </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn bg-gradient-primary">Submit</button>
                        </div>
                </div>
            </div>
        </div>

        @forelse($sprints as $sprint)
            <div class="sprint-card">
                <h3> Sprint: {{ $sprint->name }}</h3>
                <p>Description: {{ $sprint->desc }}</p>
                <div class="sprint-dates">
                    <span><strong>From: {{ $sprint->startdate }} To {{ $sprint->enddate }} </strong> </span>
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
                            <th>Comments</th>
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
                                            <option value="To Do"
                                                {{ $task->task_status == 'To Do' ? 'selected' : '' }}>To
                                                Do
                                            </option>
                                            <option value="In Progress"
                                                {{ $task->task_status == 'In Progress' ? 'selected' : '' }}>In
                                                Progress</option>
                                            <option value="Done"
                                                {{ $task->task_status == 'Done' ? 'selected' : '' }}>
                                                Done
                                            </option>
                                            <option value="Stuck"
                                                {{ $task->task_status == 'Stuck' ? 'selected' : '' }}>
                                                Stuck
                                            </option>
                                        </select>
                                    </form>
                                </td>
                                <td>{{ $task->task_priority }}</td>
                                <td>
    @if ($task->assignedUser)
        {{ $task->assignedUser->name }}
    @else
        <form id="assign-form-{{ $task->id }}" action="{{ route('assign-task', $task->id) }}" method="POST">
            @csrf
            <select name="task_assign" id="task_assign_{{ $task->id }}" class="form-select" onchange="this.form.submit()">
                <option value="" disabled selected>Select a user (optional)</option>
                @foreach ($staff as $member)
                    <option value="{{ $member->id }}" {{ $task->assignedUser && $task->assignedUser->id == $member->id ? 'selected' : '' }}>
                        {{ $member->name }}
                    </option>
                @endforeach
            </select>
        </form>
    @endif
</td>

                                <td>
                                    @include('livewire.task-management.components.comment')
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No tasks available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @include('livewire.task-management.components.add-task')
            </div>
        @empty
            <div class="no-sprints">No sprints added yet.</div>
        @endforelse
    </div>

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
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.task-status').forEach(function(element) {
                element.addEventListener('change', function() {
                    let taskId = this.dataset.taskId;
                    let status = this.value;

                    // AJAX request to update task status
                    fetch(`/tasks/${taskId}/status`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                task_status: status
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Task status updated successfully');
                                location.reload(); // Reload the page
                            } else {
                                alert('Failed to update task status');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });

    </script>

</div>
