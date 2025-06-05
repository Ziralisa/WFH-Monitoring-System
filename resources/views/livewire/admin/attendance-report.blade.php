<!-- resources/views/attendance-report.blade.php -->
<x-layouts.base>
    @include('layouts.navbars.auth.sidebar')
    <main class="main-content mt-1 border-radius-lg">
        @include('layouts.navbars.auth.nav')

        <div class="container mt-5">
            <h1 class="my-4">Attendance Report</h1>

            <!-- Filter Form -->
            <form method="GET" action="{{ route('attendance-report') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="name" class="form-control" placeholder="Search by name"
                            value="{{ request('name') }}">
                    </div>
                    <div class="col-md-4">
                        <input type="date" name="date" class="form-control" placeholder="Search by date"
                            value="{{ request('date') }}">
                    </div>
<<<<<<< HEAD
<<<<<<< HEAD
                    <div class="col-md-4">
<<<<<<< HEAD
                        <button type="submit" class="btn btn-primary">Filter</button>
=======
                        <button type="submit" class="btn btn-primary">Search</button>
>>>>>>> a2f031c (initial commit)
=======

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
>>>>>>> 270919a (merge)
=======
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">Search</button>
>>>>>>> bf7d4fe (Revert "merge")
                        <a href="{{ route('attendance-report') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
            @if(session('message'))
                <div class="alert alert-warning text-center">
                    {{ session('message') }}
=======
            <!-- Bar Chart Container -->
            <div class="card mb-4 w-100">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Attendance Status Overview ({{ request('year') ?? 'All Years' }})</h5>
>>>>>>> 270919a (merge)
=======
            @if(session('message'))
                <div class="alert alert-warning text-center">
                    {{ session('message') }}
>>>>>>> bf7d4fe (Revert "merge")
                </div>
            @endif


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
                                    <th scope="col">Date</th>
                                    <th scope="col">Staff Name</th>
                                    <th scope="col">Clock In Time</th>
                                    <th scope="col">Clock Out Time</th>
                                    <th scope="col">Clock In Points</th>
                                    <th scope="col">Working Hour Points</th>
                                    <th scope="col">Total Points</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($allUserLocations as $record)
                                    <tr>
                                        <td class="text-center">{{ $record->created_at->format('Y-m-d') }}</td>
                                        <td class="text-center">{{ $record->user->name ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $record->created_at->format('g:i A') ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $record->updated_at->format('g:i A') ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $record->clockinpoints ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $record->workinghourpoints ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $record->total_points ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No records found</td>
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
                        {{ $allUserLocations->appends(request()->query())->links() }}
                    </div>

                    <!-- Export Button -->
                    <div class="mb-3">
                        <a href="{{ route('report-pdf.pdf', request()->query()) }}" class="btn btn-danger">
                            Download PDF
                        </a>
                    </div>
<<<<<<< HEAD
<<<<<<< HEAD

>>>>>>> a2f031c (initial commit)
=======
>>>>>>> 270919a (merge)
=======

>>>>>>> bf7d4fe (Revert "merge")
                </div>
            </div>
        </div>
    </main>
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
</x-layouts.base>
=======
</x-layouts.base>
>>>>>>> a2f031c (initial commit)
=======

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
</x-layouts.base>
>>>>>>> 270919a (merge)
=======
</x-layouts.base>
>>>>>>> bf7d4fe (Revert "merge")
