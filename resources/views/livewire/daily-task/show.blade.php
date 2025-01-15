@php
    // Get the current day of the week in the same format as your loop
    $currentDay = now()->format('l'); // E.g., 'Monday', 'Tuesday', etc.
@endphp
<div class="container-fluid py-4">
    <h2 id="current-time" class="text-black font-weight-bolder mx-6 mb-4 pt-2"></h2>
    <script>
        function updateTime() {
            const now = new Date();
            const options = {
                weekday: 'long', // Full name of the day (e.g., Monday)
                year: 'numeric', // Four-digit year (e.g., 2025)
                month: 'long', // Full name of the month (e.g., January)
                day: '2-digit', // Two-digit day (e.g., 14)
            };

            // Format the date
            const formattedDate = new Intl.DateTimeFormat('en-US', options).format(now);

            // Update the content of the current-time element
            document.getElementById('current-time').textContent = formattedDate;
        }

        updateTime();
        setInterval(updateTime, 1000); // Update every second
    </script>


    <div class="card">
        {{-- @dump('assigned tasks: ', $assignedTasks)
        @dump('unassigned tasks: ', $unassignedTasks) --}}
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr class="text-center">
                        @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                            <th
                                @if ($day === $currentDay) style="background-color: #333961; color: white;" @endif>
                                {{ $day }}
                            </th>
                        @endforeach
                </thead>
                <tbody>
                    <tr style="background-color: #71DB8C; height: 20rem;">
                        @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                            <td class="text-center align-top" style="height: 20rem; vertical-align: top;">
                                <div class="d-flex flex-column h-100">
                                    {{-- Top content: Display tasks --}}
                                        @if (isset($completedTasksForTable[$day]) && $completedTasksForTable[$day]->isNotEmpty())
                                            @foreach ($completedTasksForTable[$day] as $task)
                                                <div class="flex-fill p-2 mb-1">
                                                    <p class="font-weight-bold">{{ $task->name }}</p>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="font-italic font-weight-bold">No tasks</p>
                                        @endif

                                    {{-- Bottom content: Add Task button --}}
                                    @if ($day === $currentDay)
                                        <div class="flex-fill mt-auto">
                                            <button class="btn btn-primary mt-4" type="button" data-bs-toggle="modal"
                                                data-bs-target="#completedTaskModal">Add Task</button>
                                            <!-- Modal -->
                                            @include('livewire.daily-task.components.add-completed-task')
                                        </div>
                                    @endif
                                </div>
                            </td>
                        @endforeach
                    </tr>
                    <tr style="background-color: #FFDE75; height: 20rem;">
                        @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                            <td class="text-center align-top" style="height: 20rem; vertical-align: top;">
                                {{-- @dump($todoTasksForTable[$day]) --}}
                                <div class="d-flex flex-column justify-content-between h-100">
                                        @if (isset($todoTasksForTable[$day]) && $todoTasksForTable[$day]->isNotEmpty())
                                            @foreach ($todoTasksForTable[$day] as $task)
                                                <div class="flex-fill p-2 mb-1">
                                                    <p class="font-weight-bold">{{ $task->name }}</p>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="font-italic">No tasks</p>
                                        @endif
                                    @if ($day === $currentDay)
                                        <div class="flex-fill mt-auto">
                                            <button class="btn btn-primary mt-4" type="button" data-bs-toggle="modal"
                                                data-bs-target="#todoTaskModal">Add Task</button>
                                            <!-- Modal -->
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
    @include('livewire.task-management.components.daily-task-page')
</div>
