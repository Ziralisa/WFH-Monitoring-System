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
                        <input type="text" name="name" class="form-control" placeholder="Search by name" value="{{ request('name') }}">
                    </div>
                    <div class="col-md-4">
                        <input type="date" name="date" class="form-control" placeholder="Search by date" value="{{ request('date') }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('attendance-report') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>

            <!-- Attendance Records Table -->
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Attendance Records</h5>
                </div>
                <div class="card-body">
                    <!-- Responsive Table Wrapper -->
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
                                @forelse($attendanceData as $record)
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

                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $attendanceData->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layouts.base>
