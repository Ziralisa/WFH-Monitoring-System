<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function clockIn()
    {
        $now = Carbon::now();
        $clockInDeadline = Carbon::today()->setHour(9); // Example: 9 AM

        $clockInPoints = ($now->lte($clockInDeadline)) ? 20 : 10;

        Attendance::create([
            'user_id' => Auth::id(),
            'clock_in' => $now,
            'clock_in_points' => $clockInPoints,
        ]);

        return redirect()->back()->with('success', 'Clocked in successfully!');
    }

    public function clockOut()
    {
        $now = Carbon::now();
        $endOfDay = Carbon::today()->setHour(17); // Example: 5 PM

        $clockOutPoints = ($now->gte($endOfDay)) ? 20 : 10;

        $attendance = Attendance::where('user_id', Auth::id())
                                ->whereDate('created_at', Carbon::today())
                                ->firstOrFail();

        $attendance->update([
            'clock_out' => $now,
            'clock_out_points' => $clockOutPoints,
        ]);

        return redirect()->back()->with('success', 'Clocked out successfully!');
    }

    public function calculateWorkHoursPoints()
    {
        $attendance = Attendance::where('user_id', Auth::id())
                                ->whereDate('created_at', Carbon::today())
                                ->firstOrFail();

        $hoursWorked = $attendance->clock_in->diffInHours($attendance->clock_out);

        $workHourPoints = ($hoursWorked >= 8) ? 20 : 0;

        $attendance->update(['work_hour_points' => $workHourPoints]);

        return redirect()->back()->with('success', 'Work hours points calculated!');
    }

    public function evaluatePerformance($userId, $startDate, $endDate)
{
    $attendances = Attendance::where('user_id', $userId)
                             ->whereBetween('created_at', [$startDate, $endDate])
                             ->get();

    $totalPoints = $attendances->sum(function ($attendance) {
        return $attendance->clock_in_points 
             + $attendance->clock_out_points 
             + $attendance->work_hour_points;
    });

    $totalPossiblePoints = $attendances->count() * 60; // 20 + 20 + 20 points per day

    $performanceScore = ($totalPoints / $totalPossiblePoints) * 100;

    return ($performanceScore >= 80) ? 'Good Performance' : 'Bad Performance';
}

}
