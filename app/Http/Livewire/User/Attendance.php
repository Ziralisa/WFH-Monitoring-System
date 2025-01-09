<?php

namespace App\Http\Livewire\User;

use App\Events\MyEvent;
use App\Events\UserLocationUpdated;
use App\Models\Location;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Http\Request;

class Attendance extends Component
{
    public $clockInTime, $clockOutTime, $totalHours,  $homeLocationLat, $homeLocationLng;
    public $isClockInDisabled = true;
    public $isClockOutDisabled = true;
    public $attendanceSession = 'active';
    public $usersOnPage = [];

    public function mount()
    {
        $this->checkClockStatus();
    }

    public function checkClockStatus()
    {
        $userId = auth()->id();
        $today = now()->toDateString();

        // Check if a location record for today exists
        $location = Location::where('user_id', $userId)->whereDate('created_at', $today)->latest()->first();

        // Fetch user's home location
        $this->homeLocationLat = User::where('id', $userId)->value('home_lat');
        $this->homeLocationLng = User::where('id', $userId)->value('home_lng');

        if ($location) {
            if ($location->type == 'clock_in' && $location->status == 'active') {
                $this->attendanceSession = 'active';
                $this->dispatch('start-attendance-session', 'active');
                $this->isClockInDisabled = true; // Disable Clock In
                $this->isClockOutDisabled = false; // Enable Clock Out
                $this->clockInTime = $location->created_at;
            } elseif ($location->type == 'clock_out') {
                $this->attendanceSession = 'ended';
                $this->isClockInDisabled = true; // Disable Clock In
                $this->isClockOutDisabled = true; // Disable Clock Out
                $this->clockOutTime = $location->updated_at;
                $this->clockInTime = $location->created_at;

                // Check if it's a new day
                if ($location->created_at->isToday()) {
                    $this->isClockInDisabled = true; // Disable Clock In for today
                } else {
                    $this->isClockInDisabled = false; // Enable Clock In for the new day
                }

                $this->calculateTotalHours($location);
            }
        } else {
            // No attendance record today, so enable Clock In
            $this->isClockInDisabled = false;
            $this->isClockOutDisabled = true; // Disable Clock Out
            $this->attendanceSession = 'inactive'; // No active session
        }
    }

    public function checkLocation($userLat, $userLng)
    {
        $homeLat = deg2rad($this->homeLocationLat);
        $homeLng = deg2rad($this->homeLocationLng);
        $userLat = deg2rad($userLat);
        $userLng = deg2rad($userLng);
        $earthRadius = 6371000;

        $latDiff = $userLat - $homeLat;
        $lngDiff = $userLng - $homeLng;

        $a = sin($latDiff / 2) ** 2 + cos($homeLat) * cos($userLat) * sin($lngDiff / 2) ** 2;
        $distance = 2 * atan2(sqrt($a), sqrt(1 - $a)) * $earthRadius;

        // Log for debugging
        logger()->info('Distance: ' . $distance);
        logger()->info('Home Location Lat: ' . $this->homeLocationLat);
        logger()->info('Home Location Lng: ' . $this->homeLocationLng);

        return $distance <= 50; // within 50 meters
    }

    //--------CLOCK IN FUNCTION-----------
    public function clockIn()
    {
        logger()->info('Inside clockIn()!');

        $now = Carbon::now('Asia/Kuala_Lumpur');
        $clockInDeadline = Carbon::today('Asia/Kuala_Lumpur')->setHour(9);
        $clockInPoints = $now->lessThan($clockInDeadline) ? 20 : 10;

        // Debugging log
        logger()->info('Clocking in, current time: ' . $now);
        logger()->info('Clock-in deadline: ' . $clockInDeadline);

        if ($this->checkLocation($this->homeLocationLat, $this->homeLocationLng)) {
            Location::create([
                'user_id' => Auth::id(),
                'latitude' => $this->homeLocationLat,
                'longitude' => $this->homeLocationLng,
                'type' => 'clock_in',
                'status' => 'active',
                'clockinpoints' => $clockInPoints,
            ]);

            $this->clockInTime = $now;
            $this->isClockInDisabled = true;
            $this->isClockOutDisabled = false;
            $this->attendanceSession = 'active';
            $this->dispatch('start-attendance-session', 'clock_in');
        } else {
            logger()->warning('User is out of range for clock-in.');
        }
    }

    //--------CLOCK OUT FUNCTION-----------
    public function clockOut()
    {
        $now = Carbon::now('Asia/Kuala_Lumpur');

        if ($this->checkLocation($this->homeLocationLat, $this->homeLocationLng)) {
            $location = Location::where('user_id', Auth::id())->where('type', 'clock_in')->latest()->first();

            if ($location) {
                // Calculate working hours
                $workingHours = $location->created_at->diffInHours($now);
                $workingHourPoints = $workingHours >= 9 ? 10 : 0;

                $location->update([
                    'type' => 'clock_out',
                    'status' => 'inactive',
                    'workinghourpoints' => $workingHourPoints,
                ]);

                // Set clockOutTime to the updated_at timestamp after the update
                $this->clockOutTime = $location->fresh()->updated_at; // Use fresh() to get the latest updated_at

                $this->isClockOutDisabled = true; // Disable the Clock Out button
                $this->attendanceSession = 'ended'; // Update attendance session state

                $this->calculateTotalPoints($location);
            } else {
                logger()->warning('No clock-in record found for user ID ' . Auth::id() . ' to clock out.');
            }
        } else {
            logger()->warning('Clock-out location check failed for user ID ' . Auth::id());
        }
    }

    public function updateLocationSession(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'in_range' => 'required|integer|in:0,1',
        ]);

        $location = Location::where('user_id', Auth::id())->where('type', 'clock_in')->latest()->first();

        if ($location) {
            $location->update([
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'in_range' => $validated['in_range'],
            ]);

            logger()->info('User location updated successfully.', [
                'user_id' => Auth::id(),
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'in_range' => $validated['in_range'],
            ]);

            return response()->json(['success' => true, 'message' => 'Location updated successfully.']);

        } else {
            logger()->warning('Update user location failed. No clock-in record found.', [
                'user_id' => Auth::id(),
            ]);
            return response()->json(['success' => false, 'message' => 'No clock-in record found.'], 404);
        }
    }

    //------TOTAL POINT CALCULATION------------
    public function calculateTotalPoints($location)
    {
        $totalPoints = ($location->clockinpoints ?? 0) + ($location->workinghourpoints ?? 0);
        $location->update(['total_points' => $totalPoints]);
    }

    //--------TOTAL HOUR CALCULATION----------
    public function calculateTotalHours($location)
    {
        $this->dispatch('check-location-clockout');
    }

    //-------To update user data for admin's live monitoring--------
    protected $rules = [
        'usersOnPage.*.id' => 'required|integer',
        'usersOnPage.*.name' => 'required|string',
        'usersOnPage.*.email' => 'required|email',
        'usersOnPage.*.locations' => 'nullable|array',
        'usersOnPage.*.locations.*.created_at' => 'nullable|date',
        'usersOnPage.*.locations.*.updated_at' => 'nullable|date',
        'usersOnPage.*.locations.*.status' => 'nullable|string',
    ];

    public function syncUserData($users)
    {
        $userIds = collect($users)->pluck('id');

        $this->usersOnPage = User::whereIn('id', $userIds)
            ->with([
                'locations' => function ($query) {
                    $query->whereDate('created_at', today())->orderBy('created_at', 'desc')->limit(1);
                },
            ])
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'locations' => $user->locations
                        ->map(function ($location) {
                            return [
                                'created_at' => $location->created_at,
                                'updated_at' => $location->updated_at,
                                'status' => $location->status,
                                'type' => $location->type,
                                'in_range' => $location->in_range,
                            ];
                        })
                        ->toArray(),
                ];
            })
            ->toArray();
    }

    //Receives location-updated event from map.blade.php, and then broadcast another event to pass user details to Pusher presence channel.
    #[On('location-updated')]
    public function callbackMethod()
    {
        // Ensure that 'location' is eager loaded before dispatching the event
        $user = auth()->user()->load('locations');

        // Dispatch the event with the fully loaded user
        event(new UserLocationUpdated($user));
    }

    //---------ATTENDANCE REPORT FOR STAFF SIDE--------
    public function showReport(Request $request)
    {
        // Retrieve filters from the request
        $selectedWeek = $request->input('week', null); // Default to null (show all records initially)
        $selectedMonth = $request->input('month', null); // Default to null (show all records initially)
        $selectedDate = $request->input('date');

        // Get the current user's attendance records (user-specific data)
        $userLocations = Location::where('user_id', auth()->id()); // Restrict to the authenticated user's locations

        // Handle week filter
        if ($selectedWeek) {
            $weekNumber = $selectedWeek;
            $userLocations = $userLocations->whereBetween('created_at', [
                Carbon::now()
                    ->setISODate(Carbon::now()->year, $weekNumber)
                    ->startOfWeek(),
                Carbon::now()
                    ->setISODate(Carbon::now()->year, $weekNumber)
                    ->endOfWeek(),
            ]);
        }

        // Handle month filter
        if ($selectedMonth) {
            $monthNumber = $selectedMonth;
            $userLocations = $userLocations->whereMonth('created_at', $monthNumber);
        }

        // Handle specific date filter
        if ($selectedDate) {
            $userLocations = $userLocations->whereDate('created_at', $selectedDate);
        }

        // Calculate Weekly Status (based on points)
        $weeklyPoints = $userLocations->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('total_points');

        $weeklyStatus = $this->getWeeklyStatus($weeklyPoints);

        // Calculate Monthly Status (based on points)
        $monthlyPoints = $userLocations->whereMonth('created_at', Carbon::now()->month)->sum('total_points');

        $monthlyStatus = $this->getMonthlyStatus($monthlyPoints);

        // Query to fetch location data (general report)
        $query = Location::query();

        // Apply same week/month filters for general report (you can remove this part if not needed)
        if ($selectedWeek) {
            $query->whereRaw('WEEK(created_at, 1) = ?', [$selectedWeek]);
        }

        if ($selectedMonth) {
            $query->whereMonth('created_at', $selectedMonth);
        }

        // Fetch location data for the report (can be paginated or without pagination based on needs)
        // For staff, we want their own data only, so we need to limit the query to the authenticated user's data
        $userLocations = $query
            ->where('user_id', auth()->id()) // Restrict to the authenticated user's data
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get current week number and current month (month name)
        $currentWeek = Carbon::now()->format('W');
        $currentMonth = Carbon::now()->format('F');

        // Return the data to the view
        return view('livewire.staff.report', compact('userLocations', 'weeklyStatus', 'monthlyStatus', 'selectedWeek', 'selectedMonth', 'selectedDate', 'currentWeek', 'currentMonth'));
    }

    //--------WEEKLY STATUS CALCULATION-----------
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

    //--------MONTHLY STATUS CALCULATION-----------
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

    //--------ATTENDANCE REPORT ADMIN SIDE---------
    public function attendanceReport()
    {
        // Fetch all user locations (admin can see all)
        $allUserLocations = Location::with('user') // Use relationships if `Location` belongs to `User`
            ->orderBy('created_at', 'desc') // Order by most recent
            ->paginate(10); // Adjust pagination as needed

        return view('livewire.admin.attendance-report', compact('allUserLocations'));
    }

    
    public function render()
    {
        // Get attendance records for the current user
        $userLocations = Location::where('user_id', Auth::id());

        // Calculate weekly points (sum of points for the current week)
        $weeklyPoints = $userLocations->where('created_at', '>=', Carbon::now()->startOfWeek())->where('created_at', '<=', Carbon::now()->endOfWeek())->sum('total_points');

        // Get the weekly status based on the points
        $weeklyStatus = $this->getWeeklyStatus($weeklyPoints);

        // Get the most recent location record for the user (clock-in/out)
        $location = Location::where('user_id', Auth::id())->latest()->first();

        // Pass data to the view
        return view('livewire.user.attendance.show', [
            'weeklyStatus' => $weeklyStatus, // Pass weekly status to the view
            'clockInTime' => $location && $location->type === 'clock_in' ? $location->created_at->format('Y-m-d H:i:s') : 'N/A',
            'clockOutTime' => $this->clockOutTime ? $this->clockOutTime->format('g:i A , d F Y') : 'N/A',
            'clockInPoints' => $location->clockinpoints ?? 'N/A',
            'workingHourPoints' => $location->workinghourpoints ?? 'N/A',
            'totalPoints' => $location->total_points ?? 'N/A',
            'isClockInDisabled' => $this->isClockInDisabled,
            'isClockOutDisabled' => $this->isClockOutDisabled,
            'attendanceSession' => $this->attendanceSession,
        ]);
    }
}
