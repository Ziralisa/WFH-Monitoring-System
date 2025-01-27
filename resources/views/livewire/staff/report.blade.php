<x-layouts.base>
    @include('layouts.navbars.auth.sidebar') <!-- Sidebar -->
    <main class="main-content mt-1 border-radius-lg">
        @include('layouts.navbars.auth.nav') <!-- Navbar -->

        <div class="container mt-5">
            <h1 class="my-4">Attendance Report</h1>

            <div class="row">
                <!-- Weekly Status Card -->
                <div class="col-12 col-md-6 mb-3">
                    <div class="card text-white bg-secondary">
                        <div class="card-body">
                            <h5 class="card-title">
                                @if ($selectedWeek)
                                    Weekly Status: {{ $selectedWeek }}
                                @else
                                    Weekly Status: {{ $currentWeek }} (Current Week)
                                @endif
                            </h5>

                            <p class="card-text">
                                Your weekly performance is <strong>{{ $weeklyStatus }}</strong>.
                            </p>
                            <!-- Week Selector -->
                            <form method="GET" action="{{ route('report') }}">
                                <select name="week" class="form-control mb-2">
                                    @for ($i = 1; $i <= 52; $i++)
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
                                    Monthly Status: {{ $selectedMonth }}
                                @else
                                    Monthly Status: {{ $currentMonth }} (Current Month)
                                @endif
                            </h5>

                            <!-- @if (!$selectedMonth)
                                <p>Your monthly performance is {{ $monthlyStatus }}.</p>
                            @endif -->
                            <p class="card-text">
                                Your monthly performance is <strong>{{ $monthlyStatus }}</strong>.
                            </p>
                            <!-- Month Selector -->
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
        

        <!-- Filter Form -->
        <form method="GET" action="{{ route('report') }}" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <input type="date" name="date" class="form-control" placeholder="Search by date"
                        value="{{ request('created_at') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('report') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>

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
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($userLocations as $location)
                                <tr>
                                    <td>{{ $location->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $location->created_at->format('g:i A') ?? 'N/A' }}</td>
                                    <td>{{ $location->type === 'clock_out' ? $location->updated_at->format('g:i A') : 'N/A' }}
                                    </td>
                                    <td>{{ $location->clockinpoints ?? 'N/A' }}</td>
                                    <td>{{ $location->workinghourpoints ?? 'N/A' }}</td>
                                    <td>{{ $location->total_points ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No records found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $userLocations->links() }}
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    </main>
</x-layouts.base>
