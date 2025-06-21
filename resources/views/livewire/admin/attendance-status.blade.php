<x-layouts.base>
    @includeIf('layouts.navbars.auth.sidebar')
    @includeIf('layouts.navbars.auth.nav')

    <main class="main-content mt-1 border-radius-lg">
        <div class="container mt-4">
            <h4 class="my-4"><b>ATTENDANCE STATUS</b></h4>

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
                        <button type="submit" class="btn btnfilter">Filter</button>
                        <a href="{{ url('/admin/attendance-status') }}" class="btn btnreset">Reset</a>
                    </div>
                </div>
            </form>

            <!-- Charts Section -->
            @php
                $total = $staffRecords->count();

                $weeklyExcellent = $staffRecords->where('weeklyStatus', 'Excellent')->count();
                $weeklyGood = $staffRecords->where('weeklyStatus', 'Good')->count();
                $weeklyBad = $total - $weeklyExcellent - $weeklyGood;

                $weeklyExcellentPercent = $total > 0 ? round(($weeklyExcellent / $total) * 100) : 0;
                $weeklyGoodPercent = $total > 0 ? round(($weeklyGood / $total) * 100) : 0;
                $weeklyBadPercent = $total > 0 ? round(($weeklyBad / $total) * 100) : 0;

                $monthlyExcellent = $staffRecords->where('monthlyStatus', 'Excellent')->count();
                $monthlyGood = $staffRecords->where('monthlyStatus', 'Good')->count();
                $monthlyBad = $total - $monthlyExcellent - $monthlyGood;

                $monthlyExcellentPercent = $total > 0 ? round(($monthlyExcellent / $total) * 100) : 0;
                $monthlyGoodPercent = $total > 0 ? round(($monthlyGood / $total) * 100) : 0;
                $monthlyBadPercent = $total > 0 ? round(($monthlyBad / $total) * 100) : 0;
            @endphp

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body text-center">
                            <h6 class="card-title"><b>Weekly Status Distribution</b></h6>
                            <div style="height: 250px;">
                                <canvas id="weeklyPieChart" style="height: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body text-center">
                            <h6 class="card-title"><b>Monthly Status Distribution</b></h6>
                            <div style="height: 250px;">
                                <canvas id="monthlyPieChart" style="height: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendance Records Table (Fixed Display) -->
            <div class="card mb-5">
                <div class="card-body mt-3 ml-5">
                    <h5 class="card-title text-center">Attendance Records</h5>
                    <div class="usertable table-responsive mt-3 mb-3">
                        <table class="table align-items-center mb-0 modern-table outer-border">
                            <thead>
                                <tr class="head text-center">
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Weekly Status</th>
                                    <th>Monthly Status</th>
                                    <th>Points</th>
                                </tr>
                            </thead>
                            <tbody>
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
                </div>
            </div>
        </div>
    </main>
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
</x-layouts.base>
=======
=======
>>>>>>> 0e35d15 (Reapply "merge")

    <style>
    .btnfilter, .btnreset {
        background-color: #0070ff;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 7px;
        cursor: pointer;
        font-size: 12px;
    }

    .btnfilter:hover, .btnreset:hover {
        background-color: #0070ff;
        color: white;
    }

    table th,
    table td {
        border: none !important;
        text-align: center;
    }

    .outer-border {
        border: 1px solid black;
        border-radius: 8px;
        border-collapse: separate;
        border-spacing: 0;
        overflow: hidden;
        width: 1000px;
        margin: 0 auto 30px auto;
    }

    .head {
        background-color: #0070ff;
        color: rgb(255, 255, 255);
    }

    tbody tr {
        background-color: #f8f8f8;
        color: black;
    }

    table thead th:first-child {
        border-top-left-radius: 8px;
    }

    table thead th:last-child {
        border-top-right-radius: 8px;
    }

    table tbody tr:last-child td:first-child {
        border-bottom-left-radius: 8px;
    }

    table tbody tr:last-child td:last-child {
        border-bottom-right-radius: 8px;
    }
    table tbody tr:hover {
        background-color: #d4e2ff;
        cursor: pointer;
        color: #000000;
    }
    
    .outer-border {
        border: 1px solid rgb(255, 255, 255);
        border-radius: 8px;
        border-collapse: separate;
        border-spacing: 0;
        overflow: hidden; 
        min-width: 600px;
        width: 100%;
        max-width: 1000px;
        margin: 0 auto 30px auto;
    }
    </style>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Chart Scripts -->
    <script>
        const weeklyCtx = document.getElementById('weeklyPieChart').getContext('2d');
        new Chart(weeklyCtx, {
            type: 'pie',
            data: {
                labels: [
                    'Excellent ({{ $weeklyExcellentPercent }}%)',
                    'Good ({{ $weeklyGoodPercent }}%)',
                    'Bad ({{ $weeklyBadPercent }}%)'
                ],
                datasets: [{
                    data: [{{ $weeklyExcellent }}, {{ $weeklyGood }}, {{ $weeklyBad }}],
                    backgroundColor: ['#4169E1', 'green', 'red'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed + ' record(s)';
                            }
                        }
                    }
                }
            }
        });

        const monthlyCtx = document.getElementById('monthlyPieChart').getContext('2d');
        new Chart(monthlyCtx, {
            type: 'pie',
            data: {
                labels: [
                    'Excellent ({{ $monthlyExcellentPercent }}%)',
                    'Good ({{ $monthlyGoodPercent }}%)',
                    'Bad ({{ $monthlyBadPercent }}%)'
                ],
                datasets: [{
                    data: [{{ $monthlyExcellent }}, {{ $monthlyGood }}, {{ $monthlyBad }}],
                    backgroundColor: ['#4169E1', 'green', 'red'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed + ' record(s)';
                            }
                        }
                    }
                }
            }
        });
    </script>
<<<<<<< HEAD
</x-layouts.base>
>>>>>>> 039ec79 (Reapply "merge")
=======
</x-layouts.base>
>>>>>>> 1a6b553 (Revert "merge")
=======
</x-layouts.base>
>>>>>>> 0e35d15 (Reapply "merge")
