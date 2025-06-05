<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Attendance;
use App\Models\UserLocation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class AttendanceController extends Controller
{
    // Clock-in logic
    public function clockIn(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = Auth::user();
        $now = Carbon::now();

        $location = Location::create([
            'user_id' => $user->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'type' => 'clock-in',
            'status' => 'Captured',
            'created_at' => $now,
        ]);

        Attendance::updateOrCreate(
            ['user_id' => $user->id, 'date' => $now->toDateString()],
            ['clock_in' => $now->toTimeString()]
        );

        return response()->json([
            'message' => 'Clocked in successfully.',
            'location' => [
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
                'type' => $location->type,
                'timestamp' => $location->created_at,
            ]
        ]);
    }

    // Clock-out logic
    public function clockOut(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = Auth::user();
        $now = Carbon::now();

        $location = Location::create([
            'user_id' => $user->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'type' => 'clock-out',
            'status' => 'Captured',
            'created_at' => $now,
        ]);

        Attendance::updateOrCreate(
            ['user_id' => $user->id, 'date' => $now->toDateString()],
            ['clock_out' => $now->toTimeString()]
        );

        return response()->json([
            'message' => 'Clocked out successfully.',
            'location' => [
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
                'type' => $location->type,
                'timestamp' => $location->created_at,
            ]
        ]);
    }

    // Update location session
    public function updateLocationSession(Request $request)
    {
        $user = auth()->user();

        // Force "in range" no matter the actual location
        $inRange = true;

        $user->locationLogs()->create([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'in_range' => $inRange,
        ]);

        return response()->json(['success' => true, 'in_range' => $inRange]);
    }

    //----- Attendance report admin ------
    public function attendanceReport(Request $request)
    {
<<<<<<< HEAD
<<<<<<< HEAD
        $query = Location::with('user');
=======
        $query = UserLocation::with('user');
>>>>>>> bf7d4fe (Revert "merge")
=======
        $query = DB::table('user_locations')
            ->join('users', 'user_locations.user_id', '=', 'users.id')
            ->select(
                'user_locations.*',
                'users.name as user_name',
                DB::raw('DATE(user_locations.created_at) as date')
            );
>>>>>>> 039ec79 (Reapply "merge")

        if ($request->filled('name')) {
            $query->where('users.name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('month')) {
            $query->whereMonth('user_locations.created_at', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('user_locations.created_at', $request->year);
        }

        $query->orderBy('user_locations.created_at', 'desc');
        $userLocations = $query->paginate(10)->withQueryString();

        // Get all records without pagination for chart calculation
        $chartQuery = DB::table('user_locations')
            ->join('users', 'user_locations.user_id', '=', 'users.id')
            ->select(
                'user_locations.*',
                'users.name as user_name',
                DB::raw('DATE(user_locations.created_at) as date')
            );

        if ($request->filled('name')) {
            $chartQuery->where('users.name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('month')) {
            $chartQuery->whereMonth('user_locations.created_at', $request->month);
        }

        if ($request->filled('year')) {
            $chartQuery->whereYear('user_locations.created_at', $request->year);
        }

        $allRecords = $chartQuery->get();

        // Status distribution calculation
        $statusCounts = [
            'Attendance Complete' => 0,
            'Late Arrival' => 0,
            'Attendance Incomplete' => 0,
        ];

        foreach ($allRecords as $record) {
            $clockIn = $record->created_at;
            $clockOut = $record->updated_at;

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
                }
            }

            if (!$clockOut) {
                $statusCounts['Attendance Incomplete']++;
            } elseif ($clockInPoints < 50) {
                $statusCounts['Late Arrival']++;
            } else {
                $statusCounts['Attendance Complete']++;
            }
        }

        $total = array_sum($statusCounts);
        $statusPercentages = [];
        foreach ($statusCounts as $status => $count) {
            $statusPercentages[$status] = $total > 0 ? round(($count / $total) * 100, 2) : 0;
        }

        return view('livewire.admin.attendance-report', [
            'userLocations' => $userLocations,
            'statusPercentages' => $statusPercentages,
            'selectedYear' => $request->year,
        ]);
    }

        public function index()
        {
            return $this->attendanceReport(request());
        }

    //----- Attendance status admin ------
    public function attendanceStatus(Request $request)
    {
<<<<<<< HEAD
<<<<<<< HEAD
          $admin = auth()->user();
=======
        $admin = auth()->user();
>>>>>>> bf7d4fe (Revert "merge")
        $companyId = $admin->company_id;

=======
>>>>>>> 039ec79 (Reapply "merge")
        $selectedWeek = $request->input('week', null);
        $selectedMonth = $request->input('month', null);
        $selectedYear = $request->input('year', null);
        $selectedDate = $request->input('date');

        $query = Location::select('user_id', DB::raw('SUM(total_points) as total_points'))
<<<<<<< HEAD
            
        ->with('user')
        ->whereHas('user',function ($q)use ($companyId) {
            $q->where('company_id',$companyId);
            })
            
=======
            ->with('user')
<<<<<<< HEAD
            ->whereHas('user',function ($q)use ($companyId) {
            $q->where('company_id',$companyId);
            })
>>>>>>> bf7d4fe (Revert "merge")
=======
>>>>>>> 039ec79 (Reapply "merge")
            ->groupBy('user_id');
            

        if ($selectedWeek) {
            $query->whereRaw('WEEK(created_at, 1) = ?', [$selectedWeek]);
        }

        if ($selectedMonth) {
            $query->whereMonth('created_at', $selectedMonth);
        }

        if ($selectedYear) {
            $query->whereYear('created_at', $selectedYear);
        }

        if ($selectedDate) {
            $query->whereDate('created_at', $selectedDate);
        }

        $staffRecords = $query->get();

        $totalWeeklyPoints = $this->calculateTotalPointsForWeek($selectedWeek);
        $totalMonthlyPoints = $this->calculateTotalPointsForMonth($selectedMonth);

        // Assign status labels to each staff record
        $staffRecords->each(function ($record) {
            $record->weeklyStatus = $this->getWeeklyStatus((int) $record->total_points);
            $record->monthlyStatus = $this->getMonthlyStatus((int) $record->total_points);
        });

        $calculatedWeeklyStatus = $this->getWeeklyStatus($totalWeeklyPoints);
        $calculatedMonthlyStatus = $this->getMonthlyStatus($totalMonthlyPoints);

        // Pie chart data calculation
        $statusCounts = [
            'Excellent' => 0,
            'Good' => 0,
            'Bad' => 0
        ];

        foreach ($staffRecords as $record) {
            $status = $record->weeklyStatus ?? 'Bad';
            if (array_key_exists($status, $statusCounts)) {
                $statusCounts[$status]++;
            }
        }

        $totalStaff = $staffRecords->count();
        $statusPercentages = [];
        foreach ($statusCounts as $status => $count) {
            $statusPercentages[$status] = $totalStaff > 0 ? round(($count / $totalStaff) * 100, 2) : 0;
        }

        return view('livewire.admin.attendance-status', compact(
            'staffRecords',
            'calculatedWeeklyStatus',
            'calculatedMonthlyStatus',
            'selectedWeek',
            'selectedMonth',
            'selectedYear',
            'selectedDate',
            'statusPercentages'
        ));
    }

    //---- Calculation Points-----
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

    private function calculateTotalPointsForWeek($selectedWeek)
    {
        if (!$selectedWeek) return 0;

        return Location::whereRaw('WEEK(created_at, 1) = ?', [$selectedWeek])
            ->sum('total_points');
    }

    private function calculateTotalPointsForMonth($selectedMonth)
    {
        if (!$selectedMonth) return 0;

        return Location::whereMonth('created_at', $selectedMonth)
            ->sum('total_points');
    }

    // Download attendance report
    public function downloadPdf(Request $request)
    {
        $query = Location::with('user')->latest();

        if ($request->filled('name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $allUserLocations = $query->get();

        $pdf = Pdf::loadView('attendance.report-pdf', compact('allUserLocations'));
        return $pdf->download('attendance_report.pdf');
    }
}