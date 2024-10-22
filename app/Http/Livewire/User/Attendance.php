<?php

namespace App\Http\Livewire\User;

use App\Models\Location;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Component;

class Attendance extends Component
{
    public $clockInTime;
    public $clockOutTime;
    public $isClockInDisabled = true;
    public $isClockOutDisabled = true;
    public $attendanceSession = 'inactive';
    public $homeLocationLat;
    public $homeLocationLng;

    //CHECK FOR ACTIVE SESSION, (TAKSIAP, MUST ADD TODAY'S DATE CONSIDERATION AND CLOCK OUT CONSIDERATION)
    public function checkClockStatus()
    {

        $userId = auth()->id();
        $today = now()->toDateString();
        // Check if a location record for today exists
        $location = Location::where('user_id', $userId)
            ->whereDate('created_at', $today) // Filter records created today
            ->latest()
            ->first(); // Retrieve the first record

        $this->homeLocationLat = User::where('id', $userId)->pluck('home_lat')->first();
        $this->homeLocationLng = User::where('id', $userId)->pluck('home_lng')->first();

        if ($location) {
            //RUN IF USER HAS ONLY CLOCKED IN
            if ($location->type == 'in' || $location->type == 'active') {
                $this->attendanceSession = 'active';
                $this->isClockInDisabled = true;
                $this->isClockOutDisabled = false;
                $this->clockInTime = $location->created_at->format('g:i A, d F Y'); // Format as "5:30 PM, 16 October 2024"
                return ['locationType' => $location->type, 'homeLat' => $this->homeLocationLat, 'homeLng' => $this->homeLocationLng];
                //RUN IF USER HAS CLOCKED OUT (INFORM USER ATTENDANCE SESSION FOR TODAY HAS BEEN RECORDED)
            } elseif ($location->type == 'out') {
                $this->attendanceSession = 'ended';
                $this->isClockInDisabled = true;
                $this->isClockOutDisabled = true;
                $this->clockOutTime = $location->created_at->format('g:i A, d F Y'); // Format as "5:30 PM, 16 October 2024"
                $clockInTime = Location::where('user_id', $userId)->whereDate('created_at', $today)->where('type', 'in')->first();
                $this->clockInTime = $clockInTime->created_at->format('g:i A, d F Y');
                return null;
            }
        }
        $this->isClockInDisabled = false;
        return null;
    }

    public function checkLocation($userLat, $userLng)
    {
        $userLatRad = deg2rad($userLat);
        $userLngRad = deg2rad($userLng);

        $userId = auth()->id();
        //Testing: IN DB, current home location is SMKPA3
        $this->homeLocationLat = User::where('id', $userId)->pluck('home_lat')->first();
        $this->homeLocationLng = User::where('id', $userId)->pluck('home_lng')->first();

        $homeLocationLatRad = deg2rad($this->homeLocationLat);
        $homeLocationLngRad = deg2rad($this->homeLocationLng);

        $earthRad = 6371000;

        //Calculate distance
        $latDiff = $userLatRad - $homeLocationLatRad;
        $lngDiff = $userLngRad - $homeLocationLngRad;

        $a = sin($latDiff / 2) * sin($latDiff / 2) + cos($userLatRad) * cos($homeLocationLatRad) * sin($lngDiff / 2) * sin($lngDiff / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // Calculate the distance
        $distance = $earthRad * $c;

        // If distance is within 50 meters, return success, otherwise fail
        //return $distance <= 50 ? 'User in range' : 'User out of range';
        if ($distance <= 50) {
                $this->attendanceSession = 'active';
                return true;
        } else {
            return false;
        }
    }

    // Clock-in button method
    public function clockIn()
    {
        $this->dispatch('check-location-clockin');
        $this->clockInTime = Carbon::now()->format('g:i A , d F Y');
    }

    // Clock-out button method
    public function clockOut()
    {
        $this->dispatch('check-location-clockout');
        $this->clockOutTime = Carbon::now()->format('g:i A , d F Y');

    }

    public function render()
    {
        // Pass the latitude and longitude to the view
        return view('livewire.user.attendance.show');
    }
}
