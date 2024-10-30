<?php

namespace App\Http\Livewire\User;

use App\Models\Location;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Attendance extends Component
{
    public $clockInTime;
    public $clockOutTime;
    public $totalHours;
    public $isClockInDisabled = true;
    public $isClockOutDisabled = true;
    public $attendanceSession = 'inactive';
    public $homeLocationLat;
    public $homeLocationLng;

    public function mount()
    {
        $this->checkClockStatus();
    }

    public function checkClockStatus()
{
    $userId = auth()->id();
    $today = now()->toDateString();
    
    // Check if a location record for today exists
    $location = Location::where('user_id', $userId)
        ->whereDate('created_at', $today)
        ->latest()
        ->first();

    // Fetch user's home location
    $this->homeLocationLat = User::where('id', $userId)->value('home_lat');
    $this->homeLocationLng = User::where('id', $userId)->value('home_lng');

    if ($location) {
        if ($location->type == 'clock_in' && $location->status == 'active') {
            $this->attendanceSession = 'active';
            $this->isClockInDisabled = true;  // Disable Clock In
            $this->isClockOutDisabled = false; // Enable Clock Out
            $this->clockInTime = $location->created_at;
        } elseif ($location->type == 'clock_out') {
            $this->attendanceSession = 'ended';
            $this->isClockInDisabled = true;  // Disable Clock In
            $this->isClockOutDisabled = true;  // Disable Clock Out
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

        return $distance <= 50; // within 50 meters
    }
    public function clockIn()
    {
        $now = Carbon::now('Asia/Kuala_Lumpur');
        $clockInDeadline = Carbon::today('Asia/Kuala_Lumpur')->setHour(9);
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
        }
    }
    

    public function clockOut()
{
    $now = Carbon::now('Asia/Kuala_Lumpur');

    if ($this->checkLocation($this->homeLocationLat, $this->homeLocationLng)) {
        $location = Location::where('user_id', Auth::id())
            ->where('type', 'clock_in')
            ->latest()
            ->first();

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
            logger()->warning("No clock-in record found for user ID " . Auth::id() . " to clock out.");
        }
    } else {
        logger()->warning("Clock-out location check failed for user ID " . Auth::id());
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

    public function render()
{
    // Fetch the latest location record for the user
    $location = Location::where('user_id', Auth::id())->latest()->first();

    return view('livewire.user.attendance.show', [
        'clockInTime' => $location && $location->type === 'clock_in' ? $location->created_at->format('Y-m-d H:i:s') : 'N/A',
        'clockOutTime' => $this->clockOutTime ? $this->clockOutTime->format('g:i A , d F Y') : 'N/A',
        'clockInPoints' => $location->clockinpoints ?? 'N/A',
        'workingHourPoints' => $location->workinghourpoints ?? 'N/A',
        'totalPoints' => $location->total_points ?? 'N/A',
        'isClockInDisabled' => $this->isClockInDisabled,
        'isClockOutDisabled' => $this->isClockOutDisabled,
    ]);
}

    
    
    public function showReport()
    {
        // Fetch data from the Location model instead of Attendance model
        $userLocations = Location::where('user_id', Auth::id()) // Filter by logged-in user
                                  ->orderBy('created_at', 'desc') // Order by most recent
                                  ->paginate(10); // Adjust pagination as needed
    
        return view('livewire.user.attendance.show', [
            'userLocations' => $userLocations,
        ]);
    }
    
}
