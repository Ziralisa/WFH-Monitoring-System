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
            <button type="button" class="btn btnproject" data-bs-toggle="modal" data-bs-target="#ProjectModal">Create New Project</button>
            <button type="button" class="btn btntask" data-bs-toggle="modal" data-bs-target="#TaskModal">Create New Task</button>
        </div>
    </div>

    <!-- Sort by row -->
    <div class="d-flex justify-content-end align-items-center gap-2 mb-3">
        <p class="sort mb-0">Sort by:</p>
        <a href="{{ route('projects.index', ['sort' => 'latest']) }}" class="button btnSortby"><b>LATEST</b></a>
        <a href="{{ route('projects.index', ['sort' => 'oldest']) }}" class="button btnSortby"><b>OLDEST</b></a>
    </div>
</div>

<!--Project Modal (to create new project)-->
<div class="modal fade" id="ProjectModal" tabindex="-1" aria-labelledby="ProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

<<<<<<< HEAD


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
=======

                            <!----------------------------------------------------------------------------------------->
>>>>>>> 0e35d15 (Reapply "merge")
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btnclose"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btnproject">Create Project</button>
                        </div>
                    </form>
=======
                <div data-bs-dismiss="modal">
                    <svg width="20px" height="20px" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 21.32L21 3.32001" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 3.32001L21 21.32" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
>>>>>>> 8758df5 (project)
                </div>
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

                    <div class="mb-3">
                        <label for="start_date" class="mr-2 px-2">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="mr-2 px-3" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="mr-2 px-2">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="mr-2 px-3" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btnproject">Create Project</button>
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
=======
>>>>>>> 0e35d15 (Reapply "merge")
        <!-- DISPLAY LIST PROJECTS AND TASKS -->
        <div class="row mt-4">
=======
<!-- Task Modal (to create new task)-->
<div class="modal fade" id="TaskModal" tabindex="-1" aria-labelledby="TaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TaskModalLabel">Add New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div data-bs-dismiss="modal">
                    <svg width="20px" height="20px" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 21.32L21 3.32001" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 3.32001L21 21.32" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                </div>
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
                    <button type="submit" class="btn btntask">Create Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- DISPLAY LIST PROJECTS AND TASKS -->
<div class="row mt-4">
>>>>>>> 8758df5 (project)
    @forelse ($projects as $project)
        @php
            $today = \Carbon\Carbon::today();
            $endDate = \Carbon\Carbon::parse($project->end_date);
            $daysLeft = $today->diffInDays($endDate, false);
        @endphp
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 270919a (merge)
=======
>>>>>>> bf7d4fe (Revert "merge")
=======
>>>>>>> 039ec79 (Reapply "merge")
=======
>>>>>>> 1a6b553 (Revert "merge")
=======
>>>>>>> 0e35d15 (Reapply "merge")

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
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> a2f031c (initial commit)
=======

=======
>>>>>>> 8758df5 (project)
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
=======

        <!--PROJECT DISPLAY-->
        <div class="col-12 col-md-6 col-lg-4 mb-4">
>>>>>>> 0e35d15 (Reapply "merge")
            <div class="project-card">
                <h5><b>{{ $project->name }}</b>
                    <div class="dropdown positive-relative">
                        <div class="info-icon float-end" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                            <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier"> 
                                <path d="M12 13.75C12.9665 13.75 13.75 12.9665 13.75 12C13.75 11.0335 12.9665 10.25 12 10.25C11.0335 10.25 10.25 11.0335 10.25 
                                    12C10.25 12.9665 11.0335 13.75 12 13.75Z" fill="#000000"></path> <path d="M12 6.75C12.9665 6.75 13.75 5.9665 13.75 5C13.75 
                                    4.0335 12.9665 3.25 12 3.25C11.0335 3.25 10.25 4.0335 10.25 5C10.25 5.9665 11.0335 6.75 12 6.75Z" fill="#000000">
                                </path> 
                                <path d="M12 20.75C12.9665 20.75 13.75 19.9665 13.75 19C13.75 18.0335 12.9665 17.25 12 17.25C11.0335 17.25 10.25 18.0335 10.25 
                                    19C10.25 19.9665 11.0335 20.75 12 20.75Z" fill="#000000">
                                </path> 
                            </g>
                        </svg>
                    </div>
                    <div class="dropdown-menu dropdown-menu-end shadow-sm small-dropdown text-center">
                            <button class="btnform btnedit mb-2" data-bs-toggle="modal"
                                data-bs-target="#EditProjectModal-{{ $project->id }}">
                                <i class="fas fa-edit" style="font-size: 17px; color: rgb(255, 191, 0);"></i>
                            </button>
                            <form action="{{ route('projects.destroy', $project->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                                <button type="submit" class="btnform btnedit"
                                    onclick="return confirm('Are you sure you want to delete this project?')">
                                    <i class="fas fa-trash-alt" style="font-size: 17px; color: rgb(234, 69, 33);"></i>
                                </button>
                            </form>
                        
                    </div>
                </h5>

                <p>{{ $project->description }}</p>
<<<<<<< HEAD
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
=======
>>>>>>> 0e35d15 (Reapply "merge")
                <p>
                    <strong>Start Date:</strong> {{ \Carbon\Carbon::parse($project->start_date)->format('d M Y') }}<br>
                    <strong>End Date:</strong> {{ \Carbon\Carbon::parse($project->end_date)->format('d M Y') }}
                </p>

<<<<<<< HEAD
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
=======
                @if($project->tasks->isNotEmpty())
                    <div class="usertable table-responsive mt-3-mb-5">
                        <table class="table align-items-center mb-0 modern-table outer-border">
                            <thead>
                                <tr class="head text-center">
                                    <th style="width: 20%; text-align:center">Task</th>
                                    <th style="text-align: center">Description</th>
                                    <th style="width: 20%; text-align:center">Actions</th>
>>>>>>> 0e35d15 (Reapply "merge")
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($project->tasks as $task)
                                    <tr>
                                        <td>{{ $task->name }}</td>
                                        <td>{{ $task->task_description }}</td>
                                        <td class="center">
                                            <button class="btnform btnedit" data-bs-toggle="modal"
                                                data-bs-target="#EditTaskModal-{{ $task->id }}">
                                                <i class="fas fa-edit" style="font-size: 17px; color: rgb(255, 191, 0);"></i>
                                            </button>
                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btnform btndelete"
                                                    onclick="return confirm('Are you sure you want to delete this task?')">
                                                    <i class="fas fa-trash-alt" style="font-size: 17px; color: rgb(234, 69, 33);"></i>
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
                                    <div data-bs-dismiss="modal">
                                        <svg width="20px" height="20px" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 21.32L21 3.32001" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 3.32001L21 21.32" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                    </div>
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

                                <div data-bs-dismiss="modal">
                                    <svg width="20px" height="20px" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 21.32L21 3.32001" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 3.32001L21 21.32" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </div>
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
                                    <button type="submit" class="btn btnproject">Update Project</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
<<<<<<< HEAD
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

<<<<<<< HEAD
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
=======
            </div>
>>>>>>> 0e35d15 (Reapply "merge")
        </div>
    @empty
        <p>No projects available.</p>
    @endforelse
</div>

<<<<<<< HEAD
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
=======
>>>>>>> 0e35d15 (Reapply "merge")
=======
<style>
    .small-dropdown {
        width: 80px !important;
        padding: 5px !important;
        min-width: unset !important;
    }
>>>>>>> 8758df5 (project)

    table th,
    table td {
        border: none !important;
    }

    .head {
        background-color: #0070ff;
        color: rgb(255, 255, 255);
    }

<<<<<<< HEAD
            .project-card {
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 16px;
<<<<<<< HEAD
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
=======
>>>>>>> 0e35d15 (Reapply "merge")
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                height: 100%;
                overflow-x: hidden;
                background-color: #ffffff;
            }
=======
    tbody tr {
        background-color: #f8f8f8;
        color: black;
    }
>>>>>>> 8758df5 (project)

    table thead th:first-child {
        border-top-left-radius: 8px;
    }

    table thead th:last-child {
        border-top-right-radius: 8px;
    }

    table tbody tr:last-child td:first-child {
        border-bottom-left-radius: 8px;
    }

    table tbody tr:last-child td:last-child {
        border-bottom-right-radius: 8px;
    }
    table tbody tr:hover {
        background-color: #d4e2ff;
        cursor: pointer;
        color: #000000;
    }
    
    .outer-border {
        border: 1px solid rgb(255, 255, 255);
        border-radius: 8px;
        border-collapse: separate;
        border-spacing: 0;
        overflow: hidden; 
        min-width: 600px;
        width: 100%;
        max-width: 1000px;
        margin: 0 auto 30px auto;
    }

    .project-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 16px;
        box-shadow: 0 2px 4px #ffffff;
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
        background-color: #0070ff;
        font-weight: bold;
        color: #ffffff;
        border-bottom: 2px solid #ddd;
    }

    .modern-table td {
        border-bottom: 1px;
    }

    .modern-table tr:hover {
        background-color: #f9f9f9;
    }

    .table-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
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

    .button {
        border-radius: 7px;
        color: white;
        padding: 3px 16px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 12px;
        margin-right: 2px;
        margin-left: 1px;
        margin-bottom: 4px;
        transition-duration: 0.4s;
        cursor: pointer;
    }
            
    .btnSortby {
        background-color: white; 
        color: black; 
         border: 2px solid #0070ff;
    }

    .btnSortby:hover {
        background-color: #0070ff;
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

    .btnedit {
        background-color: transparent;
        border: none;
        color: black;
        cursor: pointer;
        text-align: center;
    }

    .btndelete {
        background-color: transparent;
        border: none;
        color: black;
        cursor: pointer;
        text-align: center;
    }

    .center {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</x-layouts.base>