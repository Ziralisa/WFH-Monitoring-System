<x-layouts.base>
<<<<<<< HEAD
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
=======
    @includeIf('layouts.navbars.auth.sidebar')
    @includeIf('layouts.navbars.auth.nav')

    <main class="main-content mt-1 border-radius-lg">
        <div class="container mt-4">
            <h1 class="my-4">Attendance Status</h1>

            <!-- Filter Form (Week, Month, Year) -->
            <form method="GET" action="{{ url('/admin/attendance-status') }}" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-3">
                        <select id="week" name="week" class="form-control">
                            <option value="">Select Week</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ request('week') == $i ? 'selected' : '' }}>Week {{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select id="month" name="month" class="form-control">
                            <option value="">Select Month</option>
                            @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $index => $month)
                                <option value="{{ $index + 1 }}" {{ request('month') == $index + 1 ? 'selected' : '' }}>{{ $month }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select id="year" name="year" class="form-control">
                            <option value="">Select Year</option>
                            @for ($year = 2010; $year <= 2070; $year++)
                                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ url('/admin/attendance-status') }}" class="btn btn-secondary">Reset</a>
>>>>>>> a2f031c (initial commit)
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
<<<<<<< HEAD
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
=======
                    @php
                        $sortedRecords = $staffRecords->sortBy(function ($record) {
                            return match($record->weeklyStatus) {
                                'Excellent' => 0,
                                'Good' => 1,
                                default => 2,
                            };
                        });
                    @endphp

                    @forelse($sortedRecords as $record)
                        <tr>
                            <td>{{ $record->user->name }}</td>
                            <td>{{ $record->user->email }}</td>

                            <!-- Weekly Status with color -->
                            <td>
                                @php
                                    $weeklyColor = match($record->weeklyStatus) {
                                        'Excellent' => 'color: #4169E1; font-weight: bold;',
                                        'Good' => 'color: green; font-weight: bold;',
                                        default => 'color: red; font-weight: bold;'
                                    };
                                @endphp
                                <span style="{{ $weeklyColor }}">
                                    {{ $record->weeklyStatus ?? 'No status' }}
                                </span>
                            </td>

                            <!-- Monthly Status with color -->
                            <td>
                                @php
                                    $monthlyColor = match($record->monthlyStatus) {
                                        'Excellent' => 'color: #4169E1; font-weight: bold;',
                                        'Good' => 'color: green; font-weight: bold;',
                                        default => 'color: red; font-weight: bold;'
                                    };
                                @endphp
                                <span style="{{ $monthlyColor }}">
                                    {{ $record->monthlyStatus ?? 'No status' }}
                                </span>
                            </td>

>>>>>>> a2f031c (initial commit)
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
<<<<<<< HEAD
</x-layouts.base>
=======
</x-layouts.base>
>>>>>>> a2f031c (initial commit)
