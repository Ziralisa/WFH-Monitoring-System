<x-layouts.base>
    {{-- Include sidebar and navbar if they exist --}}
    @includeIf('layouts.navbars.auth.sidebar') <!-- Sidebar -->
    @includeIf('layouts.navbars.auth.nav') <!-- Navbar -->

    <main class="main-content mt-1 border-radius-lg">
        <div class="container mt-4">
            <h1 class="mb-4">Attendance Status</h1>

            <!-- Filter Form -->
            <form method="GET" action="{{ url('/admin/attendance-status') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <label for="week" class="form-label">Filter by Week</label>
                        <input type="number" id="week" name="week" class="form-control" value="{{ request('week') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="month" class="form-label">Filter by Month</label>
                        <input type="number" id="month" name="month" class="form-control" value="{{ request('month') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="date" class="form-label">Filter by Date</label>
                        <input type="date" id="date" name="date" class="form-control" value="{{ request('date') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>

            <!-- Attendance Records Table -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Weekly Status</th>
                        <th>Monthly Status</th>
                        <th>Points</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staffRecords as $record)
                        <tr>
                            <td>{{ $record->user->name }}</td>
                            <td>{{ $record->user->email }}</td>
                            <td>
                                {{-- Display the weekly status --}}
                                {{ $record->weeklyStatus ?? 'No status' }}
                            </td>
                            <td>
                                {{-- Display the monthly status --}}
                                {{ $record->monthlyStatus ?? 'No status' }}
                            </td>
                            <td>{{ $record->total_points }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</x-layouts.base>
