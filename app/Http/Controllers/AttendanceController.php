<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Location; 
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function clockIn()
    {
        $now = Carbon::now('Asia/Kuala_Lumpur');
        $clockInDeadline = Carbon::today('Asia/Kuala_Lumpur')->setHour(9);

        $isBefore9am = $now->diffInMinutes($clockInDeadline, false) > 0;

        // Assign points based on clock-in time
        $clockInPoints = $isBefore9am ? 20 : 10; //20 points for before 9am, 10 points after 9am

        $attendance = Attendance::create([
            'user_id' => Auth::id(),
            'clock_in' => $now,
            'clock_in_points' => $clockInPoints,
        ]);

        // Calculate total points after clocking in
        $this->calculateTotalPoints($attendance);

        return redirect()->back()->with('success', 'Clocked in successfully!');
    }

    public function clockOut()
    {
        try {
            $now = Carbon::now('Asia/Kuala_Lumpur');
            $endOfDay = Carbon::today('Asia/Kuala_Lumpur')->setHour(18); // 6:00 PM

            // Retrieve the latest attendance record for the current user and today's date
            $attendance = Attendance::where('user_id', Auth::id())
                ->whereDate('created_at', Carbon::today())
                ->latest('clock_in')  // Get the latest clock-in
                ->first();

            if (!$attendance) {
                return redirect()->back()->withErrors('Clock-in record not found. Please clock in first.');
            }

            // Calculate total working hours between clock-in and clock-out
            $workingHours = $attendance->clock_in->diffInHours($now);

            // Assign points based on working hours
            $workingHoursPoints = ($workingHours >= 9) ? 10 : 0; // 10 points for >= 9 hours

            // Determine clock-out points based on clock-out time
            $clockOutPoints = ($now->gte($endOfDay)) ? 20 : 10; //20 points for 6pm above, 10 points for lesst than 6pm

            // Update the attendance record with clock-out and working hours details
            $attendance->update([
                'clock_out' => $now,
                'clock_out_points' => $clockOutPoints,
                'working_hours_points' => $workingHoursPoints,
            ]);

            // Calculate total points after clocking out
            $this->calculateTotalPoints($attendance);

            return redirect()->back()->with('success', 'Clocked out successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Error: ' . $e->getMessage());
        }
    }

    public function calculateTotalPoints(Attendance $attendance)
    {
        $totalPoints = $attendance->clock_in_points
            + ($attendance->clock_out_points ?? 0)
            + ($attendance->working_hours_points ?? 0);

        $attendance->update(['total_points' => $totalPoints]);
    }

    public function showReport()
    {
        // Paginate attendance records for the authenticated user (e.g., 10 records per page)
        $attendances = Attendance::where('user_id', Auth::id())->paginate(10);
        return view('livewire.staff.report', compact('attendances'));
    }

    public function showDashboard()
    {
        // Retrieve the last 5 attendance records for the authenticated user
        $attendances = Attendance::where('user_id', Auth::id())->latest()->take(5)->get();

        // Check if the user has clocked in today
        $hasClockedIn = $attendances->where('created_at', today())->whereNull('clock_out')->isNotEmpty();

        // Check if the user has clocked out today
        $hasClockedOut = $attendances->where('created_at', today())->whereNotNull('clock_out')->isNotEmpty();

        // Return the dashboard view with attendance data
        return view('dashboard1', compact('attendances', 'hasClockedIn', 'hasClockedOut'));
    }

    //ATTENDANCE STATUS ADMIN
    public function attendanceStatus(Request $request)
    {
        // Retrieve filters from the request
        $selectedWeek = $request->input('week', null);
        $selectedMonth = $request->input('month', null);
        $selectedDate = $request->input('date');

        // Query to fetch all location records for admin view
        $query = Location::select('user_id', DB::raw('SUM(total_points) as total_points'))
        ->with('user')
        ->groupBy('user_id');
        
        // Apply week filter
        if ($selectedWeek) {
        $query->whereRaw('WEEK(created_at,1)=?', $selectedWeek);
        }

        // Apply month filter
        if ($selectedMonth) {
        $query->whereMonth('created_at', $selectedMonth);
        }

        // Apply date filter
        if ($selectedDate) {
        $query->whereDate('created_at', $selectedDate);
        }

        // Fetch the records with pagination
        $staffRecords = $query->get(); 
        
        // Calculate total points
        $totalWeeklyPoints = 0; // Default to 0 if no week is selected
        if ($selectedWeek) {
            $totalWeeklyPoints = Location::whereRaw('WEEK(created_at, 1) = ?', [$selectedWeek])
                ->sum('total_points');
        }

        $totalMonthlyPoints = 0; // Default to 0 if no month is selected
        if ($selectedMonth) {
            $totalMonthlyPoints = Location::whereMonth('created_at', $selectedMonth)
                ->sum('total_points');
        }     

        // Calculate statuses for each staff record
        $staffRecords->each(function ($record) {
        $record->weeklyStatus = $this->getWeeklyStatus((int) $record->total_points);
        $record->monthlyStatus = $this->getMonthlyStatus((int) $record->total_points);
        });

        // Calculate overall statuses (for the entire week or month)
        $calculatedWeeklyStatus = $this->getWeeklyStatus($totalWeeklyPoints);
        $calculatedMonthlyStatus = $this->getMonthlyStatus($totalMonthlyPoints);

        // Return the view with data
        return view('livewire.admin.attendance-status', compact(
            'staffRecords',
            'calculatedWeeklyStatus',
            'calculatedMonthlyStatus',
            'selectedWeek',
            'selectedMonth',
            'selectedDate'
            
        ));

        
    }

    private function getWeeklyStatus($points)
    {
        if ($points >= 30) {
            return 'Excellent';
        } elseif ($points >= 10) {
            return 'Good';
        } else {
            return 'Bad'; 
        }
    }

    private function getMonthlyStatus($points)
    {
        if ($points >= 100) {
            return 'Excellent';
        } elseif ($points >= 50) {
            return 'Good';
        } else {
            return 'Bad';
        }
    }

}