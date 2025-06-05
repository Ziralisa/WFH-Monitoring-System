<x-layouts.base>
    {{-- Include sidebar and navbar if they exist --}}
    @includeIf('layouts.navbars.auth.sidebar') <!-- Sidebar -->
    @includeIf('layouts.navbars.auth.nav') <!-- Navbar -->

<div class="container mt-4">
    <!-- Flex row: Heading on the left, buttons on the right -->
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4 class="mb-0"><b>PROJECTS</b></h4>

        <!-- Buttons for Add Project and Add Task -->
        <div class="d-flex gap-2">
            <button type="button" class="btn btnproject" data-bs-toggle="modal" data-bs-target="#ProjectModal">
                Create New Project
            </button>
            <button type="button" class="btn btntask" data-bs-toggle="modal" data-bs-target="#TaskModal">
                Create New Task
            </button>
        </div>
    </div>

    <!-- Sort by row -->
    <div class="d-flex justify-content-end align-items-center gap-2 mb-3">
        <p class="sort mb-0">Sort by:</p>
        <a href="{{ route('projects.index', ['sort' => 'latest']) }}" class="button btnSortby"><b>LATEST</b></a>
        <a href="{{ route('projects.index', ['sort' => 'oldest']) }}" class="button btnSortby"><b>OLDEST</b></a>
    </div>
</div>

        <!------------------------------------------------------------------------------------------------------------------------>



        <!--Project Modal (to create new project)-->
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
                            <!--WAFA ADD START AND END DATE-->
>>>>>>> a2f031c (initial commit)
=======

                            <!----------------------------------------------------------------------------------------->
>>>>>>> 270919a (merge)
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btnclose"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btnproject">Create Project</button>
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
                            <button type="button" class="btn btnclose"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btntask">Create Task</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

<<<<<<< HEAD
<<<<<<< HEAD
        <!-- Display List Projects and Tasks -->
        @forelse ($projects as $project)
=======
        <div class="container mt-4">
            <div class="mb-4">
                <a href="{{route('projects.index', ['sort' => 'latest'])}}" class="btn btn-sm btn-primary">Sort by latest</a>
                <a href="{{route('projects.index', ['sort' => 'oldest'])}}" class="btn btn-sm btn-secondary">Sort by Oldest</a>
            </div>
        </div>
=======
        <!-- DISPLAY LIST PROJECTS AND TASKS -->
        <div class="row mt-4">
    @forelse ($projects as $project)
        @php
            $today = \Carbon\Carbon::today();
            $endDate = \Carbon\Carbon::parse($project->end_date);
            $daysLeft = $today->diffInDays($endDate, false);
        @endphp
>>>>>>> 270919a (merge)

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
>>>>>>> a2f031c (initial commit)
=======

        <!--PROJECT DISPLAY-->
        <div class="col-12 col-md-6 col-lg-4 mb-4">
>>>>>>> 270919a (merge)
            <div class="project-card">
                <h5><b>{{ $project->name }}</b>
                    <span class="info-icon float-end" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                        <i class="fas fa-ellipsis-v" style="font-size:20px"></i>
                    </span>
                    <div class="dropdown-menu p-2 shadow-sm">
                        <button class="btn btnproject d-block w-100 mb-2" data-bs-toggle="modal"
                            data-bs-target="#EditProjectModal-{{ $project->id }}">
                            <i class="fas fa-edit" style="font-size: 15px;"></i> Edit
                        </button>
                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btnclose d-block w-100"
                                onclick="return confirm('Are you sure you want to delete this project?')">
                                <i class="fas fa-trash-alt" style="font-size: 15px;"></i> Delete
                            </button>
                        </form>
                    </div>
                </h5>

                <p>{{ $project->description }}</p>
<<<<<<< HEAD

<<<<<<< HEAD
=======
                <!--WAFA ADD-->
=======
>>>>>>> 270919a (merge)
                <p>
                    <strong>Start Date:</strong> {{ \Carbon\Carbon::parse($project->start_date)->format('d M Y') }}<br>
                    <strong>End Date:</strong> {{ \Carbon\Carbon::parse($project->end_date)->format('d M Y') }}
                </p>

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
                @if($project->tasks->isNotEmpty())
                    <div class="table-container">
                        <table class="table modern-table">
                            <thead>
                                <tr>
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
                                            </button>
                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btnform btndelete"
                                                    onclick="return confirm('Are you sure you want to delete this task?')">
                                                    <i class="fas fa-trash-alt" style="font-size: 15px;"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No tasks available for this project.</p>
                @endif

                <!-- Edit Task Modals -->
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
                                        <button type="button" class="btn btnclose"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btnproject">Update Task</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
                                    <div class="mb-3">
                                        <label for="start_date" class="mr-2 px-2">Start Date</label>
                                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $project->start_date }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="end_date" class="mr-2 px-2">End Date</label>
                                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $project->end_date }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btnclose"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btnproject">Update Project</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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


        <style>

            .project-card {
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 16px;
<<<<<<< HEAD
<<<<<<< HEAD
=======
                width: fit-content;
>>>>>>> a2f031c (initial commit)
                margin-bottom: 24px;
=======
>>>>>>> 270919a (merge)
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                height: 100%;
                overflow-x: hidden;
                background-color: #ffffff;
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
                background-color: #e4effe;
                font-weight: bold;
                color: #2c3e50;
                border-bottom: 2px solid #ddd;
            }

            .modern-table td {
                border-bottom: 1px solid #a5caff;
            }

            .modern-table tr:hover {
                background-color: #f9f9f9;
            }

            .table-container {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
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
            .button {
                border-radius: 7px;
                color: white;
                padding: 3px 16px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 11px;
                margin-right: 2px;
                margin-left: 1px;
                margin-bottom: 4px;
                transition-duration: 0.4s;
                cursor: pointer;
            }
            
            .btnSortby {
                background-color: white; 
                color: black; 
                border: 2px solid #2657c1;
            }

            .btnSortby:hover {
                background-color: #2657c1;
                color: white;
            }        
            
            .btnedit {   
                border-radius: 13px;
                background-color: white; 
                color: black; 
                border: 2px solid #fcb83a;
                padding: 8px 12px; 
                font-size: 14px;
                transition: 0.4s;
                margin-right: 4px;
            }

            .btndelete {   
                border-radius: 13px;
                background-color: white; 
                color: black; 
                border: 2px solid #d9534f;
                padding: 8px 12px; 
                font-size: 14px;
                transition: 0.4s;
                margin-right: 4px;
            }
            
            .btnedit:hover {
                background-color: #fcb83a;
                color: white;
            }
            
            .btndelete:hover {
                background-color: #d9534f; /* or another red tone */
                color: white;
            }

            .button1 {
                border-radius: 7px;
                color: white;
                padding: 3px 16px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 11px;
                margin-right: 2px;
                margin-left: 1px;
                margin-bottom: 4px;
                transition-duration: 0.4s;
                cursor: pointer;
            }

            .border1 {
                border-radius: 3px;
                background-color: #04AA6D;
                color: white;
            }

            .border1 {
                border-radius: 3px;
                background-color: white;
                color: black;
                border: 2px solid #04AA6D;
            }
            
            .button111 {
                background-color: #04AA6D;
                border: none;
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        
            
        </x-layouts.base>