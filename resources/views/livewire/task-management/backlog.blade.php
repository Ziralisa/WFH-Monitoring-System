<div>
    <div class="container mt-4">
        <h1 class="mb-4">Sprint</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Add Sprint Modal -->
        <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#SprintModal">
            Add Sprint
        </button>

        <div class="modal fade" id="SprintModal" tabindex="-1" role="dialog" aria-labelledby="SprintModal"
            aria-hidden="true">
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
                            <button type="button" class="btn bg-gradient-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn bg-gradient-primary">Submit</button>
                        </div>
                    </form>  
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
                            <th style="width: 40%">Task</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Assign</th>
                            <th>Comment</th>
                            <th>Project</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($sprint->tasks as $task)
                        <tr>
                            <td>{{ $task->name }}</td>
                            <td class="text-center">
                                <a href="javascript:void(0)" class="btn-tooltip" data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="{{ $task->task_description ?? 'No description' }}" data-container="body"
                                    data-animation="true">
                                    <i class="fa-solid fa-circle-info"></i>
                                </a>
                            </td>
                            <td>
                                <form>
                                    <select id="task-status-{{ $task->id }}" class="task-status"
                                            data-task-id="{{ $task->id }}" required>
                                        <option value="To Do"
                                                {{ $task->task_status == 'To Do' ? 'selected' : '' }}>To Do
                                        </option>
                                        <option value="In Progress"
                                                {{ $task->task_status == 'In Progress' ? 'selected' : '' }}>In Progress
                                        </option>
                                        <option value="Done"
                                                {{ $task->task_status == 'Done' ? 'selected' : '' }}>Done
                                        </option>
                                        <option value="Stuck"
                                                {{ $task->task_status == 'Stuck' ? 'selected' : '' }}>Stuck
                                        </option>
                                    </select>
                                </form>
                            </td>
                                <td class="text-center font-weight-bolder
                                        @if ($task->task_priority === 'Low') priority-low
                                        @elseif($task->task_priority === 'Medium') priority-medium
                                        @elseif($task->task_priority === 'High') priority-high @endif">
                                    {{ $task->task_priority }}
                                </td>
                                <td>
                                    @if ($task->assignedUser)
                                        <div class="avatar-wrapper">
                                            <img src="{{ $task->assignedUser->img ? asset($task->assignedUser->img) : asset('assets/img/team-' . rand(1, 6) . '.jpg') }}"
                                                alt="{{ $task->assignedUser->name }}"
                                                class="avatar avatar-sm">
                                            <div class="tooltip-content">
                                                <h4>{{ $task->assignedUser->name }}</h4>
                                                <span>staff</span>
                                                <div class="contact-details">
                                                    <div class="email">
                                                        <span>{{ $task->assignedUser->email }}</span>
                                                    </div>
                                                </div>
                                                <a href="@if ($task->assignedUser->id === auth()->user()->id) 
                                                                {{ route('user-profile') }}
                                                            @else
                                                                {{ route('view-user-profile', $task->assignedUser->id) }} 
                                                            @endif" 
                                                            class="view-profile-hover">View Profile</a>
                                            </div>
                                        </div>
                                    @else
                                        <form id="assign-form-{{ $task->id }}"
                                            action="{{ route('assign-task', $task->id) }}" method="POST">
                                            @csrf
                                            <select name="task_assign" id="task_assign_{{ $task->id }}"
                                                    class="form-select" onchange="this.form.submit()">
                                                <option value="" disabled selected>Select a user (optional)</option>
                                                @foreach ($staff as $member)
                                                    <option value="{{ $member->id }}"
                                                        {{ $task->assignedUser && $task->assignedUser->id == $member->id ? 'selected' : '' }}>
                                                        {{ $member->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" class="mb-3" data-bs-toggle="modal"
                                    data-bs-target="#modal-{{ $task->id }}" wire:click='setTaskId({{ $task->id }})'>
                                        <i class="fa-solid fa-message"></i>
                                    </a>
                                    @include('livewire.task-management.components.comment')
                                </td>

                                    <!-- Display Project Name -->
                                    <td>
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

        /*Hover  */
        .avatar-wrapper {
        position: relative;
        display: inline-block;
        cursor: pointer;
        }

        .tooltip-content {
            visibility: hidden;
            background-color:rgb(102, 111, 120);
            color: #fff;
            text-align: left;
            border-radius: 10px;
            padding: 15px;
            position: absolute;
            z-index: 1;
            bottom: 125%; /* Position above the avatar */
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 250px; /* Adjust width for consistent layout */
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

    
        .tooltip-conent .contact-details {
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
        
        /* View Profile Button */
        .tooltip-content .view-profile-hover {
            display: inline-block;
            margin-top: 10px;
            padding: 5px 10px;
            background-color: rgb(102, 111, 120); /* Initial button background color */
            color: #fff;  /* Text color */
            text-decoration: none;  /* Removes underline */
            border-radius: 5px;  /* Rounded corners */
            font-size: 14px;  /* Font size */
            transition: background-color 0.3s ease-in-out;  /* Smooth transition for background color change */
        }

        /* Hover effect for View Profile Button */
        .tooltip-content .view-profile-hover:hover {
            background-color:rgb(52, 65, 78);  /* Darker background on hover */
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
