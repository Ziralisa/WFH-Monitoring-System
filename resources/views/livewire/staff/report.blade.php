<x-layouts.base>
    @include('layouts.navbars.auth.sidebar') <!-- Sidebar component inclusion -->
    <main class="main-content mt-1 border-radius-lg"> <!-- Main Content -->
        @include('layouts.navbars.auth.nav')  <!-- Navbar -->
        
        <div class="container mt-5">
            <h1 class="my-4">Attendance Report</h1>

            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 mx-4">
                        <div class="card-header pb-0">
                            <div class="d-flex flex-row justify-content-between">
                                <div>
                                    <h5 class="mb-0">Attendance Records</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            @if($attendances->isEmpty())
                                <div class="alert alert-warning">
                                    No attendance records found.
                                </div>
                            @else
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Date
                                                </th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Clock In Time
                                                </th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Clock Out Time
                                                </th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Work Hours
                                                </th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Clock In Point
                                                </th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Clock Out Point
                                                </th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Work Hours Point
                                                </th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Total Points
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
    @foreach($attendances as $attendance)
        <tr>
            <td class="text-center">
                <p class="text-xs font-weight-bold mb-0">
                    {{ $attendance->created_at->format('Y-m-d') }}
                </p>
            </td>
            <td class="text-center">
                <p class="text-xs font-weight-bold mb-0">
                    {{ $attendance->clock_in->format('H:i:s') }}
                </p>
            </td>
            <td class="text-center">
                <p class="text-xs font-weight-bold mb-0">
                    {{ $attendance->clock_out ? $attendance->clock_out->format('H:i:s') : 'N/A' }}
                </p>
            </td>
            @php
                // Calculate total work hours if clocked out
                $totalMinutes = $attendance->clock_out ? $attendance->clock_in->diffInMinutes($attendance->clock_out) : 0;
                $hours = floor($totalMinutes / 60);
                $minutes = $totalMinutes % 60;
            @endphp
            <td class="text-center">
                <p class="text-xs font-weight-bold mb-0">
                    @if($attendance->clock_out)
                        {{ $hours > 0 ? $hours . ' Hours ' . $minutes . ' Minutes' : $minutes . ' Minutes' }}
                    @else
                        N/A
                    @endif
                </p>
            </td>
            <td class="text-center">
                <p class="text-xs font-weight-bold mb-0">
                    {{ $attendance->clock_in_points }}
                </p>
            </td>
            <td class="text-center">
                <p class="text-xs font-weight-bold mb-0">
                    {{ $attendance->clock_out_points }}
                </p>
            </td>
            <td class="text-center">
                <p class="text-xs font-weight-bold mb-0">
                    {{ $attendance->working_hours_points }}
                </p>
            </td>
            <td class="text-center">
                <p class="text-xs font-weight-bold mb-0">
                    {{ $attendance->total_points }} <!-- Adjust this to your logic for total points -->
                </p>
            </td>
        </tr>
    @endforeach
</tbody>

                                    </table>
                                </div>
                                <!-- Pagination links -->
                                <div class="mt-4">
                                    {{ $attendances->links() }} <!-- Ensure you have pagination set up -->
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layouts.base>
