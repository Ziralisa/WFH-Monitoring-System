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

            <!-- Display sprint details -->
            @forelse($sprints as $sprint)
                <div>
                    <strong>Name:</strong> {{ $sprint->name }} <strong>Description:</strong> {{ $sprint->desc }} <strong>Start Date:</strong> {{ $sprint->startdate }} <strong>End Date:</strong> {{ $sprint->enddate }}
                </div>

                <!-- Display task table -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Actions</th> <!-- Add actions for tasks -->
                        </tr>
                    </thead>
                    <tbody>
                        @if($sprint->tasks)
                            @foreach($sprint->tasks as $task)
                                <tr>
                                    <td>{{ $task->name }}</td>
                                    <td>{{ $task->status }}</td>
                                    <td>{{ $task->priority }}</td>
                                    <td>
                                        <!-- Edit and Delete buttons for tasks -->
                                        <a href="{{ route('edit-task', $task->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('delete-task', $task->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4">No tasks available</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <!-- Button to open popup form for adding new task -->
                <button class="btn btn-success btn-sm" id="addTaskButton" data-sprint-id="{{ $sprint->id }}">Add New Task</button>

                <!-- Popup Form -->
                <div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addTaskModalLabel">Add New Task</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="taskForm" action="{{ route('tasks.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="sprint_id" id="sprint_id">
                                    <div class="form-group">
                                        <label for="title">Task Title</label>
                                        <input type="text" class="form-control" name="title" id="title" required>
                                    </div>
                                    <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
                    @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" name="status" id="status" required>
                                            <option value="To Do">To Do</option>
                                            <option value="In Progress">In Progress</option>
                                            <option value="Done">Done</option>
                                            <option value="Stuck">Stuck</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                    <label for="priority">Priority</label>
                    <select id="priority" name="priority" class="form-control">
                        <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                        <option value="Medium" {{ old('priority') == 'Medium' ? 'selected' : '' }}>Medium</option>
                        <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>High</option>
                    </select>
                    @error('priority') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                                    <button type="submit" class="btn btn-primary">Save Task</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            @empty
                <div>No sprints added yet.</div>
            @endforelse
        </div>
    </main>

    <style>
        label {
            font-size: 16px;
            font-weight: bold;
        }

        .d-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mr-2 {
            margin-right: 8px;
        }

        .btn {
            margin-left: 10px;
        }

        textarea {
            width: 150px;
            height: 100px;
            resize: none;
        }

        table th, table td {
            text-align: center;
        }
    </style>

    <!-- Include Bootstrap CSS and JS for modal functionality -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#addTaskButton').click(function() {
                var sprintId = $(this).data('sprint-id');
                $('#sprint_id').val(sprintId);
                $('#addTaskModal').modal('show');
            });

            $('#taskForm').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.post($(this).attr('action'), formData, function(response) {
                    location.reload(); // Reload the page after adding the task
                });
            });
        });
    </script>
</x-layouts.base>
