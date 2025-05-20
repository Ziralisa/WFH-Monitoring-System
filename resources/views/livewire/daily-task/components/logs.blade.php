<div class="mt-4">
    <h2 class="mb-4">Daily Task Log</h2>
    <h6 class="mb-4">Displaying task logs from
        <strong>{{ \Carbon\Carbon::parse($startOfWeek)->format('d/m/Y') }}</strong> to
        <strong>{{ \Carbon\Carbon::parse($endOfWeek)->format('d/m/Y') }}</strong>
    </h6>
    @forelse ($taskLogs as $date => $logs)
        <div style="margin-bottom: 20px; border: 1px solid #ccc; padding: 10px;">
            <h3>
                ---- {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }} ----
                {{ \Carbon\Carbon::parse($date)->format('l') }} ----
            </h3>
            @forelse ($logs as $log)
                @php
                    $task = $log->task; // Retrieve the related Task model
                @endphp
                @if ($task)
                    <div class="d-flex align-items-center justify-content-start p-4">
                        <div class="mx-4">
                            <p class="h6 mb-0 text-s">Last updated:</p>
                            <p class="h6 text-uppercase text-secondary text-xs text-center opacity-7">
                                {{ $log->created_at }}
                            </p>
                        </div>
                        <div class="d-flex flex-row align-items-center card w-80">
                            <div class="col-2 p-4 text-center">
                                <div class="py-2 flex-row user-wrapper">
                                    <a href="javascript:void(0)" class="h6 mb-2 text-s text-center">
                                        {{ $task->assignedUser->name ?? 'Unassigned' }}
                                    </a>
                                    <div class="tooltip-content">
                                        @if ($task->assignedUser)
                                            <h4>{{ $task->assignedUser->name }}</h4>
                                            <span>staff</span>
                                            <div class="contact-details">
                                                <div class="email">
                                                    <span>{{ $task->assignedUser->email }}</span>
                                                </div>
                                            </div>
                                            <a href="@if ($task->assignedUser->id === auth()->user()->id) {{ route('user-profile') }} @else {{ route('view-user-profile', $task->assignedUser->id) }} @endif"
                                                class="view-profile-hover">
                                                View Profile
                                            </a>
                                        @else
                                            <h4>Unassigned</h4>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-row">
                                    <span class="badge badge-sm" style="background-color: {{ $log->status == 'To Do'
                            ? 'grey'
                            : ($log->status == 'In Progress'
                                ? 'orange'
                                : ($log->status == 'Done'
                                    ? 'green'
                                    : 'red')) }}; color: white; width: 100px">
                                        {{ $log->status }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-10 p-4">
                                <p class="h6"><strong>{{ $task->project->name }}</strong>:
                                    {{ $task->name }}
                                </p>
                                <span class="text-s text-secondary mx-3">{{ $task->task_description ?? 'No Description' }}</span>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Handle custom task log -->
                    <div class="d-flex align-items-center justify-content-start p-4">
                        <div class="mx-4">
                            <p class="h6 mb-0 text-s">Last updated:</p>
                            <p class="h6 text-uppercase text-secondary text-xs text-center opacity-7">
                                {{ $log->created_at }}
                            </p>
                        </div>
                        <div class="d-flex flex-row align-items-center card w-80">
                            <div class="col-2 p-4 text-center">
                                <div class="py-2 flex-row user-wrapper">
                                    @if ($log->user_id)
                                        <!-- If the task log has an assigned user -->
                                        <a href="javascript:void(0)" class="h6 mb-2 text-s text-center">
                                            {{ $log->user->name ?? 'Unknown User' }}
                                        </a>
                                    @else
                                        <!-- If no user is assigned -->
                                        <a href="javascript:void(0)" class="h6 mb-2 text-s text-center">
                                            {{ 'Unassigned' }}
                                        </a>
                                    @endif
                                </div>
                                <div class="flex-row">
                                    <span class="badge badge-sm" style="background-color: grey; color: white; width: 100px">
                                        Open Task
                                    </span>
                                </div>
                            </div>
                            <div class="col-10 p-4">
                                <p class="h6"><strong>{{ $log->title ?? 'Custom Task' }}</strong></p>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <p>No tasks available for this date.</p>
            @endforelse
        </div>
    @empty
        <p>No task logs available.</p>
    @endforelse
</div>

<style>
    /*Hover  */
    .user-wrapper {
        position: relative;
        display: inline-block;
        cursor: pointer;
    }

    .tooltip-content {
        visibility: hidden;
        background-color: rgb(102, 111, 120);
        color: #fff;
        text-align: left;
        border-radius: 10px;
        padding: 15px;
        position: absolute;
        z-index: 9999;
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

    .user-wrapper:hover .tooltip-content {
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
</style>