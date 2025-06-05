<!DOCTYPE html>
<html>
<head>
    <title>Attendance Report PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h3 style="text-align: center;">Attendance Report</h3>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Staff Name</th>
                <th>Clock In</th>
                <th>Clock Out</th>
                <th>Clock In Points</th>
                <th>Working Hour Points</th>
                <th>Total Points</th>
            </tr>
        </thead>
        <tbody>
            @foreach($allUserLocations as $record)
                <tr>
                    <td>{{ $record->created_at->format('Y-m-d') }}</td>
                    <td>{{ $record->user->name ?? 'N/A' }}</td>
                    <td>{{ $record->created_at->format('g:i A') }}</td>
                    <td>{{ $record->updated_at->format('g:i A') }}</td>
                    <td>{{ $record->clockinpoints ?? 'N/A' }}</td>
                    <td>{{ $record->workinghourpoints ?? 'N/A' }}</td>
                    <td>{{ $record->total_points ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
