<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Attendance;

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

    //----------------- ATTENDANCE REPORT FILTERING STAFF -----------------
    public function attendanceReport(Request $request)
    {
        $query = UserLocation::with('user');

        // Filter by name (from related user table)
        if ($request->filled('name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        // Filter by month (e.g. 1 = January)
        if ($request->filled('month')) {
            $query->whereMonth('created_at', (int)$request->month);
        }

        // *Filter by year*
        if ($request->filled('year')) {
            $query->whereYear('created_at', (int)$request->year);
        }

        // Filter by specific date (format: YYYY-MM-DD)
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Optional: Filter by week (assumes you calculate the week number elsewhere)
        if ($request->filled('week')) {
            $query->whereRaw('WEEK(created_at, 1) = ?', [(int)$request->week]); // WEEK mode 1 = ISO-8601 (Monday-based)
        }

        // Order by full date (latest first), then by total points descending
        $query->orderBy('created_at', 'desc')
              ->orderBy('total_points', 'desc');

        // Paginate and preserve filters
        $userLocations = $query->paginate(10)->appends($request->query());

        // Get current week and month (for display)
        $currentWeek = now()->isoWeek();
        $currentMonth = now()->month;

        // Pass selected filters (if any)
        $selectedWeek = $request->week ?? null;
        $selectedMonth = $request->month ?? null;
        $selectedYear = $request->year ?? null;

        // Calculate weekly and monthly performance (you can customize this logic)
        $weeklyStatus = 'N/A';
        $monthlyStatus = 'N/A';

        // Example logic (customize based on your point system)
        $weeklyTotal = $userLocations->whereBetween('created_at', [
            now()->startOfWeek(), now()->endOfWeek()
        ])->sum('total_points');

        $monthlyTotal = $userLocations->whereMonth('created_at', $currentMonth)->sum('total_points');

        $weeklyStatus = $weeklyTotal >= 50 ? ($weeklyTotal >= 80 ? 'Excellent' : 'Good') : 'Bad';
        $monthlyStatus = $monthlyTotal >= 200 ? 'Excellent' : ($monthlyTotal >= 120 ? 'Good' : 'Bad');

        return view('report', compact(
            'userLocations',
            'currentWeek',
            'currentMonth',
            'selectedWeek',
            'selectedMonth',
            'selectedYear',
            'weeklyStatus',
            'monthlyStatus'
        ));
    }

    //-------------- ATTENDANCE REPORT ADMIN---------------------
    public function index(Request $request)
    {
        $query = Attendance::with('user');

        // Filter by staff name (partial match)
        if ($request->filled('name')) {
            $name = $request->input('name');
            $query->whereHas('user', function ($q) use ($name) {
                $q->where('name', 'like', "%{$name}%");
            });
        }

        // Filter by month (1-12)
        if ($request->filled('month')) {
            $month = (int) $request->input('month');
            $query->whereMonth('created_at', $month);
        }

        // Filter by year (4-digit)
        if ($request->filled('year')) {
            $year = (int) $request->input('year');
            $query->whereYear('created_at', $year);
        }

        // Optional: filter by date (exact date)
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Default order by date descending
        $query->orderBy('created_at', 'desc');

        // Pagination with filters preserved in query string
        $attendances = $query->paginate(10)->withQueryString();

        return view('attendance-report.index', compact('attendances'));
    }


    //----------------- ATTENDANCE STATUS ADMIN -----------------

    public function attendanceStatus(Request $request)
    {
        $admin = auth()->user();
        $companyId = $admin->company_id;

        $selectedWeek = $request->input('week', null);
        $selectedMonth = $request->input('month', null);
        $selectedYear = $request->input('year', null);
        $selectedDate = $request->input('date');

        $query = Location::select('user_id', DB::raw('SUM(total_points) as total_points'))
            ->with('user')
            ->whereHas('user',function ($q)use ($companyId) {
            $q->where('company_id',$companyId);
            })
            ->groupBy('user_id');
            

        if ($selectedWeek) {
            $query->whereRaw('WEEK(created_at,1)=?', $selectedWeek);
        }

        if ($selectedMonth) {
            $query->whereMonth('created_at', $selectedMonth);
        }

        // *Filter by year*
        if ($selectedYear) {
            $query->whereYear('created_at', $selectedYear);
        }

        if ($selectedDate) {
            $query->whereDate('created_at', $selectedDate);
        }

        $staffRecords = $query->get();

        $totalWeeklyPoints = $this->calculateTotalPointsForWeek($selectedWeek);
        $totalMonthlyPoints = $this->calculateTotalPointsForMonth($selectedMonth);

        $staffRecords->each(function ($record) {
            $record->weeklyStatus = $this->getWeeklyStatus((int) $record->total_points);
            $record->monthlyStatus = $this->getMonthlyStatus((int) $record->total_points);
        });

        $calculatedWeeklyStatus = $this->getWeeklyStatus($totalWeeklyPoints);
        $calculatedMonthlyStatus = $this->getMonthlyStatus($totalMonthlyPoints);

        return view('livewire.admin.attendance-status', compact(
            'staffRecords',
            'calculatedWeeklyStatus',
            'calculatedMonthlyStatus',
            'selectedWeek',
            'selectedMonth',
            'selectedYear',
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