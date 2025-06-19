@php
    // Get the current day of the week in the same format as your loop
    $currentDay = now()->format('l'); // E.g., 'Monday', 'Tuesday', etc.
@endphp
<div class="container-fluid py-4">
    <h4 id="current-time" class="text-black font-weight-bolder mx-6 mb-4 pt-2"></h4>
    <select wire:model="selectedWeek" wire:change='loadTasksForSelectedWeek' class="form-control mb-4">
        @foreach ($availableWeeks as $index => $week)
            <option value="{{ $index }}">
                {{ $week['start'] }} to {{ $week['end'] }} (Week {{ $week['weekNumber'] }} of {{ $week['year'] }})
            </option>
        @endforeach
    </select>

    <div class="p-4">
        <h6>Task Card Color:</h6>

        <div style="display: flex; align-items: center; gap: 24px;">
            <span style="display: flex; align-items: center;">
                <span style="width: 20px; height: 20px; background-color: #66d080; border-radius: 3px; margin-right: 10px;"></span>
                Done
            </span>
            <span style="display: flex; align-items: center;">
                <span style="width: 20px; height: 20px; background-color: #627bbf; border-radius: 3px; margin-right: 10px;"></span>
                In Progress
            </span>
            <span style="display: flex; align-items: center;">
                <span style="width: 20px; height: 20px; background-color: #FFD700; border-radius: 3px; margin-right: 10px;"></span>
                To Do
            </span>
            <span style="display: flex; align-items: center;">
                <span style="width: 20px; height: 20px; background-color: rgb(197, 199, 198); border-radius: 3px; margin-right: 10px;"></span>
                Open Task
            </span>
        </div>
    </div>

    <script>
        function updateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric', 
                month: 'long', 
                day: '2-digit', 
            };
            // Format the date
            const formattedDate = new Intl.DateTimeFormat('en-US', options).format(now);

            // Update the content of the current-time element
            document.getElementById('current-time').textContent = formattedDate;
        }
        updateTime();
        setInterval(updateTime, 1000); // Update every second
    </script>

    <style>
        
        .content-wrapper {
            transition: margin-left 0.3s ease;
        }
        .shifted {
            margin-left: 250px; /* match your offcanvas width */
        }
    </style>
    <div class="card">
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr class="text-center" style="background-color: #ffc5a3; color: white;">
                        <th> </th>
                        @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                            <th @if ($day === $currentDay) style="background-color: #f4894b; color: white" @endif><strong>
                                {{ $day }}
                            </strong></th>
                        @endforeach
                </thead>
                <tbody>
                    <!-- Row for Completed Tasks -->
                    <tr style="background-color:rgba(101, 212, 129, 0.7)">
                        <!-- Leftmost cell for the row label -->
                        <td class="h6 align-middle font-weight-bolder" style="text-align: center;">Done</td>
                        @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                            <td class="text-center align-top" style="height: 20rem; vertical-align: top;">
                                <div class="d-flex flex-column h-100">
                                    {{-- Top content: Display tasks --}}
                                    @if (isset($completedTasksForTable[$day]) && $completedTasksForTable[$day]->isNotEmpty())
                                        @foreach ($completedTasksForTable[$day] as $task)
                                            <div class="shadow-lg card border p-2 mb-1"
                                                style="@if ($task->task_status == 'Done') background-color: #66d080; @else background-color: #FFDE75; @endif">
                                                <p class="h6"><strong>{{ $task->project->name ?? 'No Project' }}</strong>:
                                                    <small>{{ $task->name }}</small>
                                                </p>
                                            </div>
                                        @endforeach
                                    @elseif (!isset($completedTasksForTable[$day]) || $completedTasksForTable[$day]->isEmpty())

                                    @endif

                                    {{-- Bottom content: Add Task button --}}
                                    @if ($day === $currentDay)
                                        <div class="flex-fill mt-auto">
                                            <button class="btn btn-primary1 mt-4" type="button" data-bs-toggle="modal"
                                                data-bs-target="#completedTaskModal" style="background-color: #66d080; color: white;">Add Task</button>
                                            <!-- Modal -->
                                            @include('livewire.daily-task.components.add-completed-task')
                                        </div>
                                    @endif
                                </div>
                            </td>
                        @endforeach
                    </tr>


                    <!-- Row for In Progress Tasks -->
                    <tr style="background-color: #9db3e9; height: 20rem;">
                        <!-- Leftmost cell for the row label -->
                        <td class="h6 align-middle font-weight-bolder" style="text-align: center;">In Progress</td>
                        @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                            <td class="text-center align-top" style="height: 20rem; vertical-align: top;">
                                <div class="d-flex flex-column h-100">
                                    <!-- Display Regular In Progress Tasks -->
                                    @if (isset($inprogressTasksForTable[$day]) && $inprogressTasksForTable[$day]->isNotEmpty())
                                        @foreach ($inprogressTasksForTable[$day] as $task)
                                            <div class="h6 shadow-lg card border p-2 mb-1"
                                                style="@if ($task->task_status == 'Done') background-color: #66d080; @else background-color: #627bbf; @endif">
                                                <p class="h6"><strong>{{ $task->project->name ?? 'No Project' }}</strong>:
                                                    <small>{{ $task->name }}</small>
                                                </p>
                                            </div>
                                        @endforeach
                                    @endif

                                    @if ($day === $currentDay)
                                        <div class="flex-fill mt-auto">
                                            <button class="btn btn-primary2 mt-4" type="button" data-bs-toggle="modal"
                                                data-bs-target="#inprogressTaskModal" style="background-color: #627bbf; color: white;">Add Task</button>
                                            @include('livewire.daily-task.components.add-inprogress-task')
                                        </div>
                                    @endif
                                </div>
                            </td>
                        @endforeach
                    </tr>


                    <!-- Row for To Do Tasks -->
                    <tr style="background-color: rgba(255,222,117, 0.7); height: 20rem;">
                        <!-- Leftmost cell for the row label -->
                        <td class="h6 align-middle font-weight-bolder" style="text-align: center;">To Do</td>
                        @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                            <td class="text-center align-top" style="height: 20rem; vertical-align: top;">
                                <div class="d-flex flex-column h-100">
                                    <!-- Display Regular To-Do Tasks -->
                                    @if (isset($todoTasksForTable[$day]) && $todoTasksForTable[$day]->isNotEmpty())
                                        @foreach ($todoTasksForTable[$day] as $task)
                                            <div class="h6 shadow-lg card border p-2 mb-1"
                                                style="
                                                @if ($task->task_status == 'Done') background-color: #66d080; @else background-color: #FFDE75; @endif">
                                                <p class="h6"><strong>{{ $task->project->name ?? 'No Project' }}</strong>:
                                                    <small>{{ $task->name }}</small>
                                                </p>
                                            </div>
                                        @endforeach
                                    @endif

                                    @if ($day === $currentDay)
                                        <div class="flex-fill mt-auto">
                                            <button class="btn btn-primary3 mt-4" type="button" data-bs-toggle="modal"
                                                data-bs-target="#todoTaskModal" style="background-color: #FFD700; color: white;">Add Task</button>
                                            @include('livewire.daily-task.components.add-todo-task')
                                        </div>
                                    @endif
                                </div>
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @include('livewire.daily-task.components.logs')
</div>