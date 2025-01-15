<div class="mt-4">
    <h2 class="mb-4">Daily Task Log</h2>
    @foreach ($taskLogs as $date => $tasks)
        <div style="margin-bottom: 20px; border: 1px solid #ccc; padding: 10px;">
            <h3>
                ---- {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }} ----
                {{ \Carbon\Carbon::parse($date)->format('l') }} ----
            </h3>

            @foreach ($tasks as $task)
                {{-- Modal-like Display for Task Details --}}
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        {{-- MODAL HEADER --}}
                        <div class="modal-header d-flex align-items-center justify-content-start gap-2 p-3">
                            <div class="px-6">
                                <p class="h6 mb-0 text-s">Last updated:</p>
                                <p class="h6 text-uppercase text-secondary text-xs text-center opacity-7">
                                    {{ $task->updated_at }}
                                </p>
                            </div>
                            <div class="d-flex align-items-center flex-grow-1">
                                <div class="card w-100">
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <tbody>
                                                <tr>
                                                    <td class="ps-2 w-20">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <p class="h6 mb-2 text-s text-center">
                                                                {{ $task->assignedUser->name ?? 'Unassigned' }}
                                                            </p>
                                                            <span class="badge badge-sm"
                                                                style="
                                                                                    background-color:
                                                                                    {{ $task->task_status == 'To Do'
                                                                                        ? 'grey'
                                                                                        : ($task->task_status == 'In Progress'
                                                                                            ? 'orange'
                                                                                            : ($task->task_status == 'Done'
                                                                                                ? 'green'
                                                                                                : 'red')) }};
                                                                                    color: white;">
                                                                {{ $task->task_status }}
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td class="ps-2 w-80">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <p class="h6 mb-2 text-s mx-3">{{ $task->name }}</p>
                                                            <span
                                                                class="text-s text-secondary mx-3">{{ $task->task_description ?? 'No Description' }}</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
