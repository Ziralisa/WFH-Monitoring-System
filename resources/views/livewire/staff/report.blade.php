<x-layouts.base>
    @include('layouts.navbars.auth.sidebar')
    <main class="main-content mt-1 border-radius-lg">
        @include('layouts.navbars.auth.nav')

        <div class="container mt-5">
            <h1 class="my-4">Attendance Report</h1>

            <div class="row">
                <!-- Weekly Status Card -->
                <div class="col-12 col-md-6 mb-3">
                    <div class="card text-white bg-secondary">
                        <div class="card-body">
                            <h5 class="card-title">
                                @if ($selectedWeek)
                                    Weekly Status: Week {{ $selectedWeek }}
                                @else
                                    Weekly Status: Week {{ $currentWeek }} (Current Week)
                                @endif
                            </h5>

                            <p class="card-text">
                                Your weekly performance is
                                <strong class="@if($weeklyStatus === 'Bad') text-danger @elseif($weeklyStatus === 'Good') text-success @elseif($weeklyStatus === 'Excellent') text-primary @endif">
                                    {{ $weeklyStatus }}
                                </strong>.
                            </p>

                            <form method="GET" action="{{ route('report') }}">
                                <select name="week" class="form-control mb-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ $selectedWeek == $i ? 'selected' : '' }}>
                                            Week {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                                <button type="submit" class="btn btn-light btn-sm">Filter Week</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Monthly Status Card -->
                <div class="col-12 col-md-6 mb-3">
                    <div class="card text-white bg-secondary">
                        <div class="card-body">
                            <h5 class="card-title">
                                @if ($selectedMonth)
                                    Monthly Status: {{ date('F', mktime(0, 0, 0, (int)$selectedMonth, 1)) }}
                                @else
                                    Monthly Status: {{ date('F', mktime(0, 0, 0, (int)$currentMonth, 1)) }} (Current Month)
                                @endif
                            </h5>

                            <p class="card-text">
                                Your monthly performance is
                                <strong class="@if($monthlyStatus === 'Bad') text-danger @elseif($monthlyStatus === 'Good') text-success @elseif($monthlyStatus === 'Excellent') text-primary @endif">
                                    {{ $monthlyStatus }}
                                </strong>.
                            </p>

                            <form method="GET" action="{{ route('report') }}">
                                <select name="month" class="form-control mb-2">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ $selectedMonth == $i ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                        </option>
                                    @endfor
                                </select>
                                <button type="submit" class="btn btn-light btn-sm">Filter Month</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reset Filter Button -->
            <div class="col-12 text-end mb-3">
                <a href="{{ route('report') }}" class="btn btn-danger btn-sm">Reset Filter</a>
            </div>

            <!-- Indicators Legend -->
            <div class="mb-3 d-flex align-items-center gap-3">
                <div class="d-flex align-items-center">
                    <div style="width: 16px; height: 16px; background-color: orange; border-radius: 3px; margin-right: 6px;"></div>
                    <span>Late Arrival</span>
                </div>
                <div class="d-flex align-items-center">
                    <div style="width: 16px; height: 16px; background-color: red; border-radius: 3px; margin-right: 6px;"></div>
                    <span>Attendance Incomplete</span>
                </div>
                <div class="d-flex align-items-center">
                    <div style="width: 16px; height: 16px; background-color: green; border-radius: 3px; margin-right: 6px;"></div>
                    <span>Attendance Complete</span>
                </div>
            </div>

            <!-- Attendance Records Table -->
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Attendance Records</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Clock In Time</th>
                                    <th>Clock Out Time</th>
                                    <th>Clock In Points</th>
                                    <th>Working Hour Points</th>
                                    <th>Total Points</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($userLocations->sortByDesc('created_at') as $location)
                                    @php
                                        $clockOutRecord = null;
                                        if ($location->type === 'clock_in') {
                                            $clockOutRecord = $userLocations->first(function($loc) use ($location) {
                                                return $loc->type === 'clock_out' && $loc->created_at->format('Y-m-d') === $location->created_at->format('Y-m-d');
                                            });
                                        }

                                        $workingHourPoints = 'N/A';
                                        if ($location->type === 'clock_in' && $clockOutRecord) {
                                            $start = \Carbon\Carbon::parse($location->created_at);
                                            $endTime = $clockOutRecord->updated_at ?? $clockOutRecord->created_at;
                                            $end = \Carbon\Carbon::parse($endTime);

                                            $diffInHours = $start->diffInMinutes($end) / 60;

                                            $clockInValid = $start->hour >= 9;
                                            $clockOutValid = $end->hour <= 19;

                                            if ($clockInValid && $clockOutValid) {
                                                if ($diffInHours >= 8) {
                                                    $workingHourPoints = 50;
                                                } elseif ($diffInHours >= 4) {
                                                    $workingHourPoints = 35;
                                                } elseif ($diffInHours >= 2) {
                                                    $workingHourPoints = 15;
                                                } else {
                                                    $workingHourPoints = 0;
                                                }
                                            } else {
                                                $workingHourPoints = 0;
                                            }
                                        }

                                        $status = '';
                                        $statusColor = '';

                                        $clockInTime = \Carbon\Carbon::parse($location->created_at);
                                        $isLateArrival = $clockInTime->hour > 9 || ($clockInTime->hour == 9 && $clockInTime->minute > 0);
                                        $isAttendanceIncomplete = $location->type === 'clock_in' && !$clockOutRecord;

                                        if ($isAttendanceIncomplete) {
                                            $status = 'Attendance Incomplete';
                                            $statusColor = '#FF4C4C'; // Red
                                        } elseif ($isLateArrival) {
                                            $status = 'Late Arrival';
                                            $statusColor = '#FFA500'; // Orange
                                        } else {
                                            // Attendance complete & on time
                                            $status = 'Attendance Complete';
                                            $statusColor = '#28a745'; // Green
                                        }
                                    @endphp

                                    <tr>
                                        <td>{{ $location->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $location->created_at ? $location->created_at->format('g:i A') : 'N/A' }}</td>
                                        <td>
                                            @if ($location->type === 'clock_out' && $location->updated_at)
                                                {{ $location->updated_at->format('g:i A') }}
                                            @elseif($clockOutRecord)
                                                {{ ($clockOutRecord->updated_at ?? $clockOutRecord->created_at)->format('g:i A') }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $location->clockinpoints ?? 'N/A' }}</td>
                                        <td>{{ $workingHourPoints }}</td>
                                        <td>{{ ($location->clockinpoints ?? 0) + ($workingHourPoints !== 'N/A' ? $workingHourPoints : 0) }}</td>
                                        <td style="background-color: {{ $statusColor }}; color: white; display: flex; align-items: center; gap: 6px;">
                                            <div style="width: 16px; height:16px; border-radius: 3px; background-color: {{ $statusColor }};"></div>
                                            {{ $status }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center mt-3">
                            {{ $userLocations->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layouts.base>
