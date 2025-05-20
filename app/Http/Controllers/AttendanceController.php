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

    //---------------ATTENDANCE STATUS ADMIN-----------------------
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