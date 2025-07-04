<div>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h4 class="mb-4"><b>SPRINT</b></h4>
            <div class="d-flex gap-2">
                <button type="button" class="btn btnproject" data-bs-toggle="modal" data-bs-target="#SprintModal">Add Sprint</button>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Add Sprint Modal -->
        <div class="modal fade" id="SprintModal" tabindex="-1" role="dialog" aria-labelledby="SprintModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="SprintModal">New Sprint</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div data-bs-dismiss="modal">
                            <svg width="20px" height="20px" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 21.32L21 3.32001" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 3.32001L21 21.32" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                        </div>
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
                            <div class="form-group">
                                <label for="project_id">Select Project</label>
                                <select name="project_id" id="project_id" class="form-control" required>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
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
                            <button type="submit" class="btn btnproject">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Sprint Modals -->
        @foreach ($sprints as $sprint)
            <div class="modal fade" id="EditSprintModal-{{ $sprint->id }}" tabindex="-1" aria-labelledby="EditSprintModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="EditSprintModalLabel">Edit Sprint</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div data-bs-dismiss="modal">
                                    <svg width="20px" height="20px" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 21.32L21 3.32001" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 3.32001L21 21.32" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </div>
                    </div>
                    <form action="{{ route('sprints.edit', $sprint->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editName-{{ $sprint->id }}" class="form-label">Sprint Name</label>
                                <input type="text" name="name" id="editName-{{ $sprint->id }}" class="form-control" value="{{ $sprint->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="editDesc-{{ $sprint->id }}" class="form-label">Description</label>
                                <textarea name="desc" id="editDesc-{{ $sprint->id }}" class="form-control" required>{{ $sprint->desc }}</textarea>
                            </div>
                            <div class="mb-3">
                                    <label for="startdDate-{{ $sprint->id }}" class="form-label">Start Date</label>
                                    <input type="date" name="startdate" id="startdate" class="form-control" value="{{ $sprint->startdate }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="enddate-{{ $sprint->id }}" class="form-label">End Date</label>
                                    <input type="date" name="enddate" id="endDate" class="form-control" value="{{ $sprint->enddate }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                                <button type="submit" class="btn btnproject">Update Sprint</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Sprint Display -->
        @forelse($sprints as $sprint)
            <div class="sprint-card">
                <h5><b>{{ $sprint->name }}</b>
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
                            <button class="btn btndelete mb-2" data-bs-toggle="modal"
                                data-bs-target="#EditSprintModal-{{ $sprint->id }}">
                                Edit
                            </button>
                            <form action="{{ route('sprints.destroy', $sprint->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                                <button type="submit" class="btn btnedit"
                                    onclick="return confirm('Are you sure you want to delete this project?')">
                                    Delete
                                </button>
                            </form>
                        
                    </div>
                </h5>

                <p>Description: {{ $sprint->desc }}</p>
                <div class="sprint-dates">
                    <strong>From: {{ \Carbon\Carbon::parse($sprint->startdate)->format('Y-m-d') }} To: {{ \Carbon\Carbon::parse($sprint->enddate)->format('Y-m-d') }}</strong>
                </div>

                @include('livewire.task-management.components.add-task')

                <div class="usertable table-responsive mt-3-mb-5">
                    <table class="table align-items-center mb-0 modern-table outer-border">
                        <thead>
                            <tr class="head text-center">
                                <th style="width: 20%; text-align: center">Task</th>
                                <th style="text-align: center">Description</th>
                                <th style="text-align: center">Status</th>
                                <th style="text-align: center">Priority</th>
                                <th style="text-align: center">Assign</th>
                                <th style="text-align: center">Comment</th>
                                <th style="text-align: center">Project</th>
                            </tr>
                        </thead>
                    <tbody>
                    @forelse($sprint->tasks as $task)
                        <tr>
                            <td>{{ $task->name }}</td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" class="btn-tooltip" data-bs-toggle="tooltip" title="{{ $task->task_description ?? 'No description' }}">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </a>
                                </td>
                            <td>
                                <form>
                                    <select id="task-status-{{ $task->id }}" class="task-status" data-task-id="{{ $task->id }}" required>
                                        <option value="To Do" {{ $task->task_status == 'To Do' ? 'selected' : '' }}>To Do</option>
                                        <option value="In Progress" {{ $task->task_status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="Done" {{ $task->task_status == 'Done' ? 'selected' : '' }}>Done</option>
                                    </select>
                                </form>
                            </td>
                            <td class="text-center font-weight-bolder @if ($task->task_priority === 'Low') priority-low @elseif($task->task_priority === 'Medium') priority-medium @elseif($task->task_priority === 'High') priority-high @endif">{{ $task->task_priority }}</td>
                            <td>
                                @if ($task->assignedUser)
                                <div class="avatar-wrapper">
                                    <img src="{{ $task->assignedUser->img ? asset($task->assignedUser->img) : asset('assets/img/team-' . rand(1, 6) . '.jpg') }}" alt="{{ $task->assignedUser->name }}" class="avatar avatar-sm">
                                    <div class="tooltip-content">
                                        <h4>{{ $task->assignedUser->name }}</h4>
                                        <span>staff</span>
                                        <div class="contact-details">
                                            <div class="email">
                                                <span>{{ $task->assignedUser->email }}</span>
                                            </div>
                                        </div>
                                            <a href="@if ($task->assignedUser->id === auth()->user()->id) {{ route('user-profile') }} @else {{ route('view-user-profile', $task->assignedUser->id) }} @endif" class="view-profile-hover">View Profile</a>
                                    </div>
                                </div>
                                @else
                                <form id="assign-form-{{ $task->id }}" action="{{ route('assign-task', $task->id) }}" method="POST">
                                    @csrf
                                    <select name="task_assign" id="task_assign_{{ $task->id }}" class="form-select" onchange="this.form.submit()">
                                        <option value="" disabled selected>Select a user (optional)</option>
                                        @foreach ($staff as $member)
                                        <option value="{{ $member->id }}" {{ $task->assignedUser && $task->assignedUser->id == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                                        @endforeach
                                    </select>
                                </form>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="javascript:void(0)" class="mb-3" data-bs-toggle="modal" data-bs-target="#modal-{{ $task->id }}" wire:click='setTaskId({{ $task->id }})'>
                                    <i class="fa-solid fa-message"></i>
                                </a>
                                @include('livewire.task-management.components.comment')
                            </td>

                            <!-- Display Project Name -->
                            <td style="text-align: center;">
                                {{ $task->project->name ?? 'No project assigned' }}
                            </td>
                            </tr>
                            @empty
                        <tr>
                            <td colspan="7" class="text-center font-weight-bold">No tasks available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @empty
    <div class="no-sprints">No sprints added yet.</div>
    @endforelse
</div>

    <style>

    .small-dropdown {
        width: 120px !important;
        padding: 5px !important;
        min-width: unset !important;
    }

    table th,
    table td {
        border: none !important;
    }

    .outer-border {
        border: 1px solid black;
        border-radius: 8px;
        border-collapse: separate;
        border-spacing: 0;
        overflow: hidden;
        width: 1000px;
        margin: 0 auto 30px auto;
    }

    .head {
        background-color: #0070ff;
        color: rgb(255, 255, 255);
    }

    tbody tr {
        background-color: #f8f8f8;
        color: black;
    }

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

        .sprint-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 30px;
            margin-bottom: 24px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            height: 100%;
            background-color: #fff;
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

  
        .table-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;   /* Allows horizontal scrolling for smaller screens */
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

        td.priority-low {
            background-color: #d4edda !important;
            /* Add !important if necessary */
            color: #155724;
        }

        td.priority-medium {
            background-color: #fff3cd !important;
            color: #856404;
        }

        td.priority-high {
            background-color: #f8d7da !important;
            color: #721c24;
        }

        .no-sprints {
            text-align: center;
            color: #7f8c8d;
        }

        .text-center {
            text-align: center;
        }

        /Hover/
        .avatar-wrapper {
            position: relative;
            display: flex;
            /* Use flexbox for alignment */
            flex-direction: column;
            /* Stack items vertically */
            align-items: center;
            /* Center items horizontally */
            justify-content: center;
            /* Center items vertically */
            cursor: pointer;
        }

        .tooltip-content {
            visibility: hidden;
            background-color: rgb(102, 111, 120);
            color: #fff;
            text-align: left;
            /* Keeps tooltip content left-aligned */
            border-radius: 10px;
            padding: 15px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            /* Position above the avatar */
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 250px;
            /* Adjust width for consistent layout */
        }

        .avatar-wrapper:hover .tooltip-content {
            visibility: visible;
            opacity: 1;
        }

        .tooltip-content h4 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
        }

        .tooltip-content p {
            margin: 5px 0;
            font-size: 14px;
            color: #dcdcdc;
        }

        .tooltip-content .contact-details {
            margin-top: 10px;
        }

        .tooltip-content .email {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
            color: #dcdcdc;
        }

        .tooltip-content .email i {
            margin-right: 8px;
        }

        /* Center the avatar */
        .avatar-wrapper .avatar {
            display: block;
            margin: 0 auto;
            /* Centers the avatar horizontally */
        }

        /* View Profile Button */
        .tooltip-content .view-profile-hover {
            display: inline-block;
            margin-top: 10px;
            padding: 5px 10px;
            background-color: rgb(102, 111, 120);
            /* Initial button background color */
            color: #fff;
            /* Text color */
            text-decoration: none;
            /* Removes underline */
            border-radius: 5px;
            /* Rounded corners */
            font-size: 14px;
            /* Font size */
            transition: background-color 0.3s ease-in-out;
            /* Smooth transition for background color change */
        }

        /* Hover effect for View Profile Button */
        .tooltip-content .view-profile-hover:hover {
            background-color: rgb(52, 65, 78);
            /* Darker background on hover */
        }

        /* Ellipsis option */
        .hover-delete {
            position: relative;
            /* Ensure the delete menu is positioned relative to this container */
            cursor: pointer;
        }

        /* Hover menu hidden by default, shown on hover */
        .hover-delete-menu {
            display: none;
            /* Initially hidden */
            position: absolute;
            /* Positioned relative to the parent .hover-delete */
            top: 100%;
            /* Positioned below the ellipsis button */
            right: 0;
            /* Align to the right corner */
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 8px;
            border-radius: 4px;
            z-index: 10;
            /* Ensure it's above other content */
        }

        /* Display the hover menu when hovering over the container (ellipsis icon + menu) */
        .hover-delete:hover .hover-delete-menu {
            display: block;
        }

        /* Styling for the h3 element */
        h3 {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 18px;
            /* Adjust size as needed */
            margin: 0;
            padding: 5px 0;
        }

        /* Styling for the ellipsis icon */
        h3 i {
            font-size: 1.5rem;
            /* Size of the ellipsis icon */
            color: #6c757d;
            cursor: pointer;
        }

        /* Hover effect for the ellipsis icon */
        h3 i:hover {
            color: #343a40;
        }

        /* Button inside the hover menu */
        .hover-delete-menu button {
            width: 100%;
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 8px;
            border-radius: 4px;
            font-size: 14px;
            /* Consistent font size */
            font-weight: normal;
            /* Consistent font weight */
            font-family: inherit;
            /* Consistent font family */
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-bottom: 5px;
            /* Adds space between buttons */
        }

        /* Hover effect for the delete button */
        .hover-delete-menu button:hover {
            background-color: #c0392b;
        }

        /* Styling for the Edit button */
        .hover-delete-menu .edit-button {
            background-color: #f39c12;
            /* Yellow background for Edit */
            color: white;
            width: 100%;
            padding: 8px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            /* Same font size as Delete */
            font-weight: normal;
            /* Same font weight as Delete */
            font-family: inherit;
            /* Ensures same font family as Delete */
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-bottom: 5px;
            /* Adds space between buttons */
        }

        /* Hover effect for the Edit button */
        .hover-delete-menu .edit-button:hover {
            background-color: #e67e22;
            /* Darker yellow on hover */
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

        .btnedit, .btndelete {
        background-color: #0070ff;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 7px;
        cursor: pointer;
        font-size: 12px;
        width: 100px;
    }

    .btnedit:hover, .btndelete:hover {
        background-color: #0070ff;
        color: white;
    }

    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.task-status').forEach(function (element) {
                element.addEventListener('change', function () {
                    let taskId = this.dataset.taskId;
                    let status = this.value;

                    fetch(/tasks/${taskId}/status, {
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
                            location.reload();
                        } else {
                            alert('Failed to update task status');
                        }
                    })
                    .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</div>