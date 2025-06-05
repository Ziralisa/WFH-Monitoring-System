<x-layouts.base>
    {{-- Include sidebar and navbar if they exist --}}
    @includeIf('layouts.navbars.auth.sidebar') <!-- Sidebar -->
    @includeIf('layouts.navbars.auth.nav') <!-- Navbar -->

<div class="container mt-4">
        <h1 class="mb-4">Projects</h1>

        <!-- Buttons for Add Project and Add Task -->
        <div class="mb-4">
            <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#ProjectModal">
                Add Project
            </button>
            <button type="button" class="btn bg-gradient-success " data-bs-toggle="modal" data-bs-target="#TaskModal">
                Add Task
            </button>
        </div>

        <!-- Project Modal (to create new project)-->
        <div class="modal fade" id="ProjectModal" tabindex="-1" aria-labelledby="ProjectModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">New Project</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('projects.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Project Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" class="form-control"></textarea>
                            </div>
<<<<<<< HEAD
=======

                            <!--WAFA ADD START AND END DATE-->
                            <div class="mb-3">
                                <label for="start_date" class="mr-2 px-2">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="mr-2 px-3" required>
                            </div>
                            <div class="mb-3">
                                <label for="end_date" class="mr-2 px-2">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="mr-2 px-3" required>
                            </div>
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
                            <!--WAFA ADD START AND END DATE-->
>>>>>>> a2f031c (initial commit)
=======

                            <!----------------------------------------------------------------------------------------->
>>>>>>> 270919a (merge)
=======
                            <!--WAFA ADD START AND END DATE-->
>>>>>>> bf7d4fe (Revert "merge")
=======

                            <!----------------------------------------------------------------------------------------->
>>>>>>> 039ec79 (Reapply "merge")
=======
                            <!--WAFA ADD START AND END DATE-->
>>>>>>> 1a6b553 (Revert "merge")
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn bg-gradient-primary">Create Project</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Task Modal (to create new task)-->
        <div class="modal fade" id="TaskModal" tabindex="-1" aria-labelledby="TaskModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="TaskModalLabel">Add New Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('projects.tasks.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="project_id" class="form-label">Select Project</label>
                                <select name="project_id" class="form-select" required>
                                    <option value="">-- Select Project --</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Task Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="task_description" class="form-label">Description</label>
                                <textarea name="task_description" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn bg-gradient-primary">Create Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
        <!-- Display List Projects and Tasks -->
        @forelse ($projects as $project)
=======
=======
>>>>>>> bf7d4fe (Revert "merge")
=======
>>>>>>> 1a6b553 (Revert "merge")
        <div class="container mt-4">
            <div class="mb-4">
                <a href="{{route('projects.index', ['sort' => 'latest'])}}" class="btn btn-sm btn-primary">Sort by latest</a>
                <a href="{{route('projects.index', ['sort' => 'oldest'])}}" class="btn btn-sm btn-secondary">Sort by Oldest</a>
            </div>
        </div>
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> 039ec79 (Reapply "merge")
        <!-- DISPLAY LIST PROJECTS AND TASKS -->
        <div class="row mt-4">
    @forelse ($projects as $project)
        @php
            $today = \Carbon\Carbon::today();
            $endDate = \Carbon\Carbon::parse($project->end_date);
            $daysLeft = $today->diffInDays($endDate, false);
        @endphp
<<<<<<< HEAD
>>>>>>> 270919a (merge)
=======
>>>>>>> bf7d4fe (Revert "merge")
=======
>>>>>>> 039ec79 (Reapply "merge")
=======
>>>>>>> 1a6b553 (Revert "merge")

        <!-- Display List Projects and Tasks -->
        @forelse ($projects as $project)

            <!--WAFA ADD-->
            @php
                $today = \Carbon\Carbon::today();
                $endDate = \Carbon\Carbon::parse($project->end_date);
                $daysLeft = $today->diffInDays($endDate, false);
            @endphp

            @if($daysLeft > 0 && $daysLeft <= 3)
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Project Deadline Approaching!',
                    text: 'The project "{{ $project->name }}" is ending soon on {{ $endDate->format("d M Y") }}.',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                });
            });
            </script>
            @endif

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> a2f031c (initial commit)
=======

        <!--PROJECT DISPLAY-->
        <div class="col-12 col-md-6 col-lg-4 mb-4">
>>>>>>> 270919a (merge)
=======
>>>>>>> bf7d4fe (Revert "merge")
=======

        <!--PROJECT DISPLAY-->
        <div class="col-12 col-md-6 col-lg-4 mb-4">
>>>>>>> 039ec79 (Reapply "merge")
=======
>>>>>>> 1a6b553 (Revert "merge")
            <div class="project-card">
                <h3>
                    {{ $project->name }}
                    <!-- Info button (for delete and edit project) -->
                    <!-- <div class="dropdown text-end" style="display: inline-block; float: right;"> -->
                    <span class="info-icon" data-bs-toggle="dropdown" aria-expanded="false"
                        style="cursor: pointer; float: right;">
                        <i class="fas fa-ellipsis-v" style="font-size:20px"></i>
                    </span>
                    <!-- Dropdown Menu -->
                    <div class="dropdown-menu p-2 shadow-sm">
                        <!-- Edit Project Button -->
                        <button class="btn btn-sm btn-warning d-block w-100 mb-2" data-bs-toggle="modal"
                            data-bs-target="#EditProjectModal-{{ $project->id }}">
                            <i class="fas fa-edit" style="font-size: 15px;"></i> Edit
                        </button>

                        <!-- Delete Project Button -->
                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger d-block w-100"
                                onclick="return confirm('Are you sure you want to delete this project?')">
                                <i class="fas fa-trash-alt" style="font-size: 15px;"></i> Delete
                            </button>
                        </form>
                    </div>

                </h3>
                <p>{{ $project->description }}</p>
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD

<<<<<<< HEAD
=======
                <!--WAFA ADD-->
=======
>>>>>>> 270919a (merge)
=======

                <!--WAFA ADD-->
>>>>>>> bf7d4fe (Revert "merge")
=======
>>>>>>> 039ec79 (Reapply "merge")
=======

                <!--WAFA ADD-->
>>>>>>> 1a6b553 (Revert "merge")
                <p>
                    <strong>Start Date:</strong> {{ \Carbon\Carbon::parse($project->start_date)->format('d M Y') }}<br>
                    <strong>End Date:</strong> {{ \Carbon\Carbon::parse($project->end_date)->format('d M Y')}}
                </p>

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> a2f031c (initial commit)
                <!-- Display Task List -->
                @if($project->tasks->isNotEmpty())
                    <table class="table modern-table">
                        <thead>
                            <tr>
                                <th style="width: 40%">Task</th>
<<<<<<< HEAD
                                <th>Description</th>
                                <th style="width: 20%">Actions</th>
=======
                                <th >Description</th>
                                <th style="width: 100%">Actions</th>
>>>>>>> a2f031c (initial commit)
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($project->tasks as $task)
                                <tr>
                                    <td>{{ $task->name }}</td>
<<<<<<< HEAD
                                    <td>{{ $task->task_description }}</td>
=======
                                    <td style="white-space: normal; word-wrap: break-word; overflow-wrap: break-word; max-width: 600px; width: 100%;">
                                        {{ $task->task_description }}
                                    </td>

>>>>>>> a2f031c (initial commit)
                                    <td>
                                        <!-- Edit Task Button -->
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#EditTaskModal-{{ $task->id }}">
                                            <i class="fas fa-edit" style="font-size: 15px;"></i>
                                        </button>

                                        <!-- Delete Task Button -->
                                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this task?')">
                                                <i class="fas fa-trash-alt" style="font-size: 15px;"></i>
                                            </button>
                                        </form>
                                    </td>
=======
=======
                <!-- Display Task List -->
>>>>>>> bf7d4fe (Revert "merge")
                @if($project->tasks->isNotEmpty())
                    <table class="table modern-table">
                        <thead>
                            <tr>
                                <th style="width: 40%">Task</th>
                                <th >Description</th>
                                <th style="width: 100%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($project->tasks as $task)
                                <tr>
<<<<<<< HEAD
                                    <th style="width: 20%; text-align:center">Task</th>
                                    <th style="text-align: center">Description</th>
                                    <th style="width: 20%; text-align:center">Actions</th>
>>>>>>> 270919a (merge)
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($project->tasks as $task)
                                    <tr>
                                        <td>{{ $task->name }}</td>
                                        <td>{{ $task->task_description }}</td>
                                        <td>
                                            <button class="btnform btnedit" data-bs-toggle="modal"
                                                data-bs-target="#EditTaskModal-{{ $task->id }}">
                                                <i class="fas fa-edit" style="font-size: 15px;"></i>
=======
                                    <td>{{ $task->name }}</td>
                                    <td style="white-space: normal; word-wrap: break-word; overflow-wrap: break-word; max-width: 600px; width: 100%;">
                                        {{ $task->task_description }}
                                    </td>

                                    <td>
                                        <!-- Edit Task Button -->
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#EditTaskModal-{{ $task->id }}">
                                            <i class="fas fa-edit" style="font-size: 15px;"></i>
                                        </button>

                                        <!-- Delete Task Button -->
                                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this task?')">
                                                <i class="fas fa-trash-alt" style="font-size: 15px;"></i>
>>>>>>> bf7d4fe (Revert "merge")
                                            </button>
                                        </form>
                                    </td>
=======
=======
                <!-- Display Task List -->
>>>>>>> 1a6b553 (Revert "merge")
                @if($project->tasks->isNotEmpty())
                    <table class="table modern-table">
                        <thead>
                            <tr>
                                <th style="width: 40%">Task</th>
                                <th >Description</th>
                                <th style="width: 100%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($project->tasks as $task)
                                <tr>
<<<<<<< HEAD
                                    <th style="width: 20%; text-align:center">Task</th>
                                    <th style="text-align: center">Description</th>
                                    <th style="width: 20%; text-align:center">Actions</th>
>>>>>>> 039ec79 (Reapply "merge")
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($project->tasks as $task)
                                    <tr>
                                        <td>{{ $task->name }}</td>
                                        <td>{{ $task->task_description }}</td>
                                        <td>
                                            <button class="btnform btnedit" data-bs-toggle="modal"
                                                data-bs-target="#EditTaskModal-{{ $task->id }}">
                                                <i class="fas fa-edit" style="font-size: 15px;"></i>
=======
                                    <td>{{ $task->name }}</td>
                                    <td style="white-space: normal; word-wrap: break-word; overflow-wrap: break-word; max-width: 600px; width: 100%;">
                                        {{ $task->task_description }}
                                    </td>

                                    <td>
                                        <!-- Edit Task Button -->
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#EditTaskModal-{{ $task->id }}">
                                            <i class="fas fa-edit" style="font-size: 15px;"></i>
                                        </button>

                                        <!-- Delete Task Button -->
                                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this task?')">
                                                <i class="fas fa-trash-alt" style="font-size: 15px;"></i>
>>>>>>> 1a6b553 (Revert "merge")
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No tasks available for this project.</p>
                @endif
            </div>

            <!-- Edit Task Modal -->
            @foreach ($project->tasks as $task)
                <div class="modal fade" id="EditTaskModal-{{ $task->id }}" tabindex="-1" aria-labelledby="EditTaskModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="EditTaskModalLabel">Edit Task</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Task Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ $task->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="task_description" class="form-label">Description</label>
                                        <textarea name="task_description"
                                            class="form-control">{{ $task->task_description }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn bg-gradient-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn bg-gradient-primary">Update Task</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
            </div>
<<<<<<< HEAD
        @empty
<<<<<<< HEAD
            <p>No projects available.</p>
=======
            <p>No projects  available.</p>
>>>>>>> a2f031c (initial commit)
        @endforelse
=======
        </div>
    @empty
        <p>No projects available.</p>
    @endforelse
</div>

>>>>>>> 270919a (merge)
=======
            @endforeach

            <!-- Edit Project Modal -->
            <div class="modal fade" id="EditProjectModal-{{ $project->id }}" tabindex="-1"
                aria-labelledby="EditProjectModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="EditProjectModalLabel">Edit Project</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('projects.update', $project->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Project Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $project->name }}"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" class="form-control">{{ $project->description }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn bg-gradient-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn bg-gradient-primary">Update Project</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p>No projects  available.</p>
        @endforelse
>>>>>>> bf7d4fe (Revert "merge")
=======
            </div>
        </div>
    @empty
        <p>No projects available.</p>
    @endforelse
</div>

>>>>>>> 039ec79 (Reapply "merge")
=======
            @endforeach

            <!-- Edit Project Modal -->
            <div class="modal fade" id="EditProjectModal-{{ $project->id }}" tabindex="-1"
                aria-labelledby="EditProjectModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="EditProjectModalLabel">Edit Project</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('projects.update', $project->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Project Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $project->name }}"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" class="form-control">{{ $project->description }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn bg-gradient-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn bg-gradient-primary">Update Project</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p>No projects  available.</p>
        @endforelse
>>>>>>> 1a6b553 (Revert "merge")


        <style>
            .project-card {
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 16px;
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
                width: fit-content;
>>>>>>> a2f031c (initial commit)
                margin-bottom: 24px;
=======
>>>>>>> 270919a (merge)
=======
                width: fit-content;
                margin-bottom: 24px;
>>>>>>> bf7d4fe (Revert "merge")
=======
>>>>>>> 039ec79 (Reapply "merge")
=======
                width: fit-content;
                margin-bottom: 24px;
>>>>>>> 1a6b553 (Revert "merge")
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .project-card h3 {
                margin: 0 0 8px;
                color: #2c3e50;
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
        </style>
        </x-layouts.base>
