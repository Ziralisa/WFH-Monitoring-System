<!DOCTYPE html>
<html>
<head>
    <title>Attendance Report PDF</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead {
            background-color: #2c3e50;
            color: #fff;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 11px;
            color: #fff;
        }

        .complete {
            background-color: #3498db;
        }

        .late {
            background-color: #e67e22;
        }

        .incomplete {
            background-color: #e74c3c;
        }
    </style>
</head>
<body>
    <h3 style="text-align: center;">Attendance Report</h3>
    <table>
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
            @forelse($allUserLocations as $record)
            @php
                    $clockIn = $record->created_at ?? null;
                    $clockOut = $record->updated_at ?? null;

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
                        } else {
                            $clockInPoints = 0;
                        }
                    }

                    $workingHourPoints = $record->working_hour_points ?? 0;
                    $totalPoints = $clockInPoints + $workingHourPoints;

                    // Determine status
                    if (!$clockOut) {
                        $statusClass = 'incomplete';
                        $statusText = 'Attendance Incomplete';
                    } elseif ($clockInPoints < 70 && $clockInPoints < 50) {
                        $statusClass = 'late';
                        $statusText = 'Late Arrival';
                    } else {
                        $statusClass = 'complete';
                        $statusText = 'Attendance Complete';
                    }
                @endphp
                <tr>
                    <td>{{ $record->created_at->format('Y-m-d') }}</td>
                    <td>{{ $record->user->name ?? 'N/A' }}</td>
                    <td>{{ $record->created_at->format('g:i A') }}</td>
                    <td>{{ $record->updated_at->format('g:i A') }}</td>
                    <td>{{ $record->clockinpoints ?? 'N/A' }}</td>
                    <td>{{ $record->workinghourpoints ?? 'N/A' }}</td>
                    <td>{{ $record->total_points ?? 'N/A' }}</td>
                    <td class="{{ $statusClass }}">{{ $statusText }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">No records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
