<x-layouts.base>
    @include('layouts.navbars.auth.sidebar')

    <main class="main-content mt-1 border-radius-lg">
        @include('layouts.navbars.auth.nav')

        <div class="container mt-5">
            <h1 class="my-4">Admin Attendance Report</h1>

            @php
                $complete = $late = $incomplete = 0;
                foreach ($userLocations as $record) {
                    $clockIn = $record->created_at;
                    $clockOut = $record->updated_at;

                    $clockInPoints = 0;

                    if ($clockIn) {
                        $clockInTime = \Carbon\Carbon::parse($clockIn);
                        $nine = $clockInTime->copy()->setTime(9, 0);
                        $nineThirty = $clockInTime->copy()->setTime(9, 30);
                        $ten = $clockInTime->copy()->setTime(10, 0);

                        if ($clockInTime->lte($nine)) {
                            $clockInPoints = 50;
                        } elseif ($clockInTime->lte($nineThirty)) {
                            $clockInPoints = 30;
                        } elseif ($clockInTime->lte($ten)) {
                            $clockInPoints = 20;
                        }
                    }

                    if (!$clockOut) {
                        $incomplete++;
                    } elseif ($clockInPoints < 50) {
                        $late++;
                    } else {
                        $complete++;
                    }
                }

                $totalStatus = $complete + $late + $incomplete;
                $completePercent = $totalStatus ? round(($complete / $totalStatus) * 100) : 0;
                $latePercent = $totalStatus ? round(($late / $totalStatus) * 100) : 0;
                $incompletePercent = $totalStatus ? round(($incomplete / $totalStatus) * 100) : 0;
            @endphp

            <!-- Filter Form -->
            <form method="GET" action="{{ route('attendance-report') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="name" class="form-control" placeholder="Search by name"
                               value="{{ request('name') }}">
                    </div>

                    <div class="col-md-3">
                        <select name="month" class="form-control">
                            <option value="">Select Month</option>
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
                    <div class="col-md-4">
<<<<<<< HEAD
                        <button type="submit" class="btn btn-primary">Filter</button>
=======
                        <button type="submit" class="btn btn-primary">Search</button>
>>>>>>> a2f031c (initial commit)
=======
=======
>>>>>>> 039ec79 (Reapply "merge")

                    <div class="col-md-3">
                        <select name="year" class="form-control">
                            <option value="">Select Year</option>
                            @foreach(range(2010, 2070) as $year)
                                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Filter</button>
<<<<<<< HEAD
>>>>>>> 270919a (merge)
=======
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">Search</button>
>>>>>>> bf7d4fe (Revert "merge")
=======
>>>>>>> 039ec79 (Reapply "merge")
                        <a href="{{ route('attendance-report') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
            @if(session('message'))
                <div class="alert alert-warning text-center">
                    {{ session('message') }}
=======
=======
>>>>>>> 039ec79 (Reapply "merge")
            <!-- Bar Chart Container -->
            <div class="card mb-4 w-100">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Attendance Status Overview ({{ request('year') ?? 'All Years' }})</h5>
<<<<<<< HEAD
>>>>>>> 270919a (merge)
=======
            @if(session('message'))
                <div class="alert alert-warning text-center">
                    {{ session('message') }}
>>>>>>> bf7d4fe (Revert "merge")
=======
>>>>>>> 039ec79 (Reapply "merge")
                </div>
                <div class="card-body">
                    <div style="width: 100%;">
                        <canvas id="attendanceStatusBarChart" style="width: 100%; height: 250px;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Indicators Legend -->
            <div class="mb-3 d-flex gap-3 align-items-center">
                <span style="width: 16px; height: 16px; background-color: green; border-radius: 3px;"></span>
                <span>Attendance Complete</span>

                <span style="width: 16px; height: 16px; background-color: orange; border-radius: 3px;"></span>
                <span>Late Arrival</span>

                <span style="width: 16px; height: 16px; background-color: red; border-radius: 3px;"></span>
                <span>Attendance Incomplete</span>
            </div>

>>>>>>> a2f031c (initial commit)
            <!-- Attendance Records Table -->
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Attendance Records</h5>
                </div>
                <div class="card-body">
<<<<<<< HEAD
                    <!-- Responsive Table Wrapper -->
=======
>>>>>>> a2f031c (initial commit)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Staff Name</th>
                                    <th>Clock In Time</th>
                                    <th>Clock Out Time</th>
                                    <th>Clock In Points</th>
                                    <th>Working Hour Points</th>
                                    <th>Total Points</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($userLocations as $record)
                                    @php
                                        $clockIn = $record->created_at;
                                        $clockOut = $record->updated_at;

                                        $clockInPoints = 0;
                                        $workingHourPoints = 0;
                                        $totalPoints = 0;

                                        if ($clockIn) {
                                            $clockInTime = \Carbon\Carbon::parse($clockIn);
                                            $nine = $clockInTime->copy()->setTime(9, 0);
                                            $nineThirty = $clockInTime->copy()->setTime(9, 30);
                                            $ten = $clockInTime->copy()->setTime(10, 0);

                                            if ($clockInTime->lte($nine)) {
                                                $clockInPoints = 50;
                                            } elseif ($clockInTime->lte($nineThirty)) {
                                                $clockInPoints = 30;
                                            } elseif ($clockInTime->lte($ten)) {
                                                $clockInPoints = 20;
                                            }
                                        }

                                        if ($clockIn && $clockOut) {
                                            $in = \Carbon\Carbon::parse($clockIn);
                                            $out = \Carbon\Carbon::parse($clockOut);
                                            $hoursWorked = $in->diffInHours($out);

                                            $workingHourPoints = $hoursWorked >= 8 ? 50 : 0;
                                        }

                                        $totalPoints = $clockInPoints + $workingHourPoints;

                                        if (!$clockOut) {
                                            $statusColor = 'red';
                                            $statusText = 'Attendance Incomplete';
                                        } elseif ($clockInPoints < 50) {
                                            $statusColor = 'orange';
                                            $statusText = 'Late Arrival';
                                        } else {
                                            $statusColor = 'green';
                                            $statusText = 'Attendance Complete';
                                        }
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($record->date)->format('Y-m-d') }}</td>
                                        <td class="text-center">{{ $record->user_name ?? 'N/A' }}</td>
                                        <td class="text-center">
                                            {{ $clockIn ? \Carbon\Carbon::parse($clockIn)->format('g:i A') : 'N/A' }}
                                        </td>
                                        <td class="text-center">
                                            {{ $clockOut ? \Carbon\Carbon::parse($clockOut)->format('g:i A') : 'N/A' }}
                                        </td>
                                        <td class="text-center">{{ $clockInPoints }}</td>
                                        <td class="text-center">{{ $workingHourPoints }}</td>
                                        <td class="text-center">{{ $totalPoints }}</td>
                                        <td class="text-center">
                                            <span class="badge" style="background-color: {{ $statusColor }};">
                                                {{ $statusText }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

<<<<<<< HEAD
                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $allUserLocations->links() }}
                    </div>
=======
                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $userLocations->appends(request()->query())->links() }}
                    </div>

                    <!-- Export Button -->
                    <div class="mb-3">
                        <a href="{{ route('report-pdf.pdf', request()->query()) }}" class="btn btn-danger">
                            Download PDF
                        </a>
                    </div>
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD

>>>>>>> a2f031c (initial commit)
=======
>>>>>>> 270919a (merge)
=======

>>>>>>> bf7d4fe (Revert "merge")
=======
>>>>>>> 039ec79 (Reapply "merge")
                </div>
            </div>

        </div>
    </main>
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
</x-layouts.base>
=======
</x-layouts.base>
>>>>>>> a2f031c (initial commit)
=======
=======
>>>>>>> 039ec79 (Reapply "merge")

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Bar Chart Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const canvas = document.getElementById('attendanceStatusBarChart');
            if (canvas) {
                const ctxBar = canvas.getContext('2d');
                new Chart(ctxBar, {
                    type: 'bar',
                    data: {
                        labels: [
                            'Attendance Complete ({{ $completePercent }}%)',
                            'Late Arrival ({{ $latePercent }}%)',
                            'Attendance Incomplete ({{ $incompletePercent }}%)'
                        ],
                        datasets: [{
                            label: 'Status Percentage',
                            data: [{{ $completePercent }}, {{ $latePercent }}, {{ $incompletePercent }}],
                            backgroundColor: ['green', 'orange', 'red'],
                            borderRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.label + ': ' + context.raw + '%';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100,
                                title: {
                                    display: true,
                                    text: 'Percentage (%)'
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
<<<<<<< HEAD
</x-layouts.base>
>>>>>>> 270919a (merge)
=======
</x-layouts.base>
>>>>>>> bf7d4fe (Revert "merge")
=======
</x-layouts.base>
>>>>>>> 039ec79 (Reapply "merge")
