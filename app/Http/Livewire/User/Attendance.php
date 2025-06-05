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

        $location = Location::where('user_id', $userId)->whereDate('created_at', $today)->latest()->first();

        $this->homeLocationLat = User::where('id', $userId)->value('home_lat');
        $this->homeLocationLng = User::where('id', $userId)->value('home_lng');

        if ($location) {
            if ($location->type == 'clock_in' && $location->status == 'active') {
                $this->attendanceSession = 'active';
                $this->dispatch('start-attendance-session', 'active');
                $this->isClockInDisabled = true;
                $this->isClockOutDisabled = false;
                $this->clockInTime = $location->created_at;
            } elseif ($location->type == 'clock_out') {
                $this->attendanceSession = 'ended';
                $this->isClockInDisabled = true;
                $this->isClockOutDisabled = true;
                $this->clockOutTime = $location->updated_at;
                $this->clockInTime = $location->created_at;

                if ($location->created_at->isToday()) {
                    $this->isClockInDisabled = true;
                } else {
                    $this->isClockInDisabled = false;
                }

                $this->calculateTotalHours($location);
            }
        } else {
            $this->isClockInDisabled = false;
            $this->isClockOutDisabled = true;
            $this->attendanceSession = 'inactive';
        }
    }

    // 🔧 Fixed: allow all locations
    public function checkLocation($userLat, $userLng)
    {
        // Always allow clock-in and clock-out from any location
        return true;
    }

    public function clockIn()
    {
        $now = Carbon::now('Asia/Kuala_Lumpur');
        $clockInDeadline = Carbon::today('Asia/Kuala_Lumpur')->setHour(10);
        $clockInPoints = $now->lessThan($clockInDeadline) ? 20 : 10;

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
        }
    }

    public function clockOut()
    {
        $now = Carbon::now('Asia/Kuala_Lumpur');

        if ($this->checkLocation($this->homeLocationLat, $this->homeLocationLng)) {
            $location = Location::where('user_id', Auth::id())->where('type', 'clock_in')->latest()->first();

            if ($location) {
                $workingHours = $location->created_at->diffInHours($now);
                $workingHourPoints = $workingHours >= 9 ? 10 : 0;

                $location->update([
                    'type' => 'clock_out',
                    'status' => 'inactive',
                    'workinghourpoints' => $workingHourPoints,
                ]);

                $this->clockOutTime = $location->fresh()->updated_at;
                $this->isClockOutDisabled = true;
                $this->attendanceSession = 'ended';
                $this->calculateTotalPoints($location);

            }
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

            return response()->json(['success' => true, 'message' => 'Location updated successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'No clock-in record found.'], 404);
        }
    }

    public function calculateTotalPoints($location)
    {
        $totalPoints = ($location->clockinpoints ?? 0) + ($location->workinghourpoints ?? 0);
        $location->update(['total_points' => $totalPoints]);
    }

    public function calculateTotalHours($location)
    {
        $this->dispatch('check-location-clockout');
    }

    protected $rules = [
        'usersOnPage.*.id' => 'required|integer',
        'usersOnPage.*.name' => 'required|string',
        'usersOnPage.*.email' => 'required|email',
        'usersOnPage.*.locations' => 'nullable|array',
        'usersOnPage..locations..created_at' => 'nullable|date',
        'usersOnPage..locations..updated_at' => 'nullable|date',
        'usersOnPage..locations..status' => 'nullable|string',
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

    #[On('location-updated')]
    public function callbackMethod()
    {
        $user = auth()->user()->load('locations');
        event(new UserLocationUpdated($user));
    }

    public function showReport(Request $request)
    {
        $selectedWeek = $request->input('week');
        $selectedMonth = $request->input('month');
        $selectedDate = $request->input('date');

        $userLocations = Location::where('user_id', auth()->id());

        if ($selectedWeek) {
            $weekNumber = $selectedWeek;
            $userLocations = $userLocations->whereBetween('created_at', [
                Carbon::now()->setISODate(Carbon::now()->year, $weekNumber)->startOfWeek(),
                Carbon::now()->setISODate(Carbon::now()->year, $weekNumber)->endOfWeek(),
            ]);
        }

        if ($selectedMonth) {
            $userLocations = $userLocations->whereMonth('created_at', $selectedMonth);
        }

        if ($selectedDate) {
            $userLocations = $userLocations->whereDate('created_at', $selectedDate);
        }

        $weeklyPoints = $userLocations->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('total_points');
        $weeklyStatus = $this->getWeeklyStatus($weeklyPoints);

        $monthlyPoints = $userLocations->whereMonth('created_at', Carbon::now()->month)->sum('total_points');
        $monthlyStatus = $this->getMonthlyStatus($monthlyPoints);

        $query = Location::query();

        if ($selectedWeek) {
            $query->whereRaw('WEEK(created_at, 1) = ?', [$selectedWeek]);
        }

        if ($selectedMonth) {
            $query->whereMonth('created_at', $selectedMonth);
        }

        $userLocations = $query
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $currentWeek = Carbon::now()->format('W');
        $currentMonth = Carbon::now()->format('F');

        return view('livewire.staff.report', compact(
            'userLocations',
            'weeklyStatus',
            'monthlyStatus',
            'selectedWeek',
            'selectedMonth',
            'selectedDate',
            'currentWeek',
            'currentMonth'
        ));
    }

    private function getWeeklyStatus($points)
    {
        if ($points >= 30) return 'Excellent';
        if ($points >= 10) return 'Good';
        return 'Bad';
    }

    private function getMonthlyStatus($points)
    {
        if ($points >= 100) return 'Excellent';
        if ($points >= 50) return 'Good';
        return 'Bad';
    }

    public function attendanceReport()
    {
         $admin = auth()->user(); // Get the logged-in admin
        $companyId = $admin->company_id;

        $allUserLocations = Location::with('user')
            ->whereHas('user',function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })
        ->orderBy('created_at', 'desc')->paginate(10);
        return view('livewire.admin.attendance-report', compact('allUserLocations'));
    }

    public function render()
    {
        $userLocations = Location::where('user_id', Auth::id());
        $weeklyPoints = $userLocations->where('created_at', '>=', Carbon::now()->startOfWeek())
            ->where('created_at', '<=', Carbon::now()->endOfWeek())
            ->sum('total_points');
        $weeklyStatus = $this->getWeeklyStatus($weeklyPoints);

        $location = $userLocations->latest()->first();

        return view('livewire.user.attendance.show', [
            'weeklyStatus' => $weeklyStatus,
            'clockInTime' => $location?->created_at,
            'clockOutTime' => $location?->updated_at,
        ]);
    }
}