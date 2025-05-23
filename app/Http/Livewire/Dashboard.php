<?php

namespace App\Http\Livewire;

use App\Models\Attendance;
use App\Models\Comment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    use WithPagination;

    public User $user;
    public $usersOnPage = [];
    public $userReports = [];
    public $badUsers = [];
    public $goodUsers = [];
    public $locations = [];
    public $contactLink;

    protected $rules = [
        'usersOnPage.*.id' => 'required|integer',
        'usersOnPage.*.name' => 'required|string',
        'usersOnPage.*.email' => 'required|email',
        'usersOnPage.*.locations' => 'nullable|array',
        'usersOnPage.*.locations.*.created_at' => 'nullable|date',
        'usersOnPage.*.locations.*.updated_at' => 'nullable|date',
        'usersOnPage.*.locations.*.status' => 'nullable|string',
    ];

    public function showAttendanceLog($userId)
    {
        $this->user = User::find($userId);

        if ($this->user) {
            // Retrieve locations and simplify the data
            $locations = $this->user->locations()->latest()->paginate(10);

            // Convert paginator to simple array
            $this->locations = $locations->items(); // This gives just the collection of location items

            // Optionally transform each location
            $this->locations = collect($this->locations)->map(function ($location) {
                return [
                    'date' => $location->created_at->format('Y-m-d'),
                    'time' => $location->created_at->format('H:i:s'),
                    'user_id' => $location->user_id,
                    'name' => $this->user->name,
                    'latitude' => $location->latitude,
                    'longitude' => $location->longitude,
                    'location' => $this->getPlace($location->latitude, $location->longitude),
                ];
            });
        } else {
            $this->locations = collect(); // Empty collection if user not found
        }
    }

    public function getPlace($latitude, $longitude)
    {
        if (!$latitude || !$longitude) {
            return 'N/A';
        }

        $url = 'https://maps.googleapis.com/maps/api/geocode/json';
        $params = [
            'latlng' => "{$latitude},{$longitude}",
            'sensor' => 'false',
            'key' => env('GOOGLE_MAP_KEY'),
        ];

        $response = Http::get($url, $params);

        if ($response->ok()) {
            $data = $response->json();

            if (!empty($data['results'][0]['address_components'])) {
                $components = $data['results'][0]['address_components'];
                $city = collect($components)->firstWhere(fn($comp) => in_array('locality', $comp['types']))['long_name'] ?? null;
                $state = collect($components)->firstWhere(fn($comp) => in_array('administrative_area_level_1', $comp['types']))['long_name'] ?? null;

                return "{$state}, {$city}";
            }
        }

        return 'N/A';
    }

    public function editContactLink($userid)
    {
        $this->user = User::find($userid);
        $this->contactLink = $this->user->contact_link;
    }

    public function saveContactLink()
    {
        // dd($this->user, $this->contactLink);
        $this->user->update([
            'contact_link' => $this->contactLink,
        ]);
        session()->flash('message', 'Contact link saved successfully!');
    }

    public function userNotification($status, $username)
    {
        if ($status == 'online') {
            flash()->info($username . ' is now online..');
        } elseif ($status == 'offline') {
            flash()->warning($username . ' is now offline..');
            User::where('name', $username)->update(['last_online' => Carbon::now()]);
        } elseif ($status == 'in range') {
            flash()->success($username . ' is now in range..');
        } elseif ($status == 'out of range') {
            flash()->error($username . ' is out of range!');
        } else {
            flash()->error('An error has occured');
        }
    }

    public function syncUserData($users)
    {
        $companyId = Auth::user()->company_id;
        $userIds = collect($users)->pluck('id');

        $this->usersOnPage = User::whereIn('id', $userIds)
        ->where('company_id', $companyId)
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
                    'contact_link' => $user->contact_link,
                    'last_online' => $user->last_online,
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

    // Simulate adding a new row with dummy data
    public $showOfflineUser = false;
    
    public $offlineUsers = [];

    public function viewOfflineUsers()
    {
        // dd($this->usersOnPage);

        $this->showOfflineUser = true;

         $companyId = Auth::user()->company_id;

        // Extract the user IDs from $usersOnPage
        $userIdsOnPage = collect($this->usersOnPage)
            ->pluck('id')
            ->toArray();

        // $users = User::whereNotIn('id', $userIdsOnPage)
            $this->offlineUsers = User::where('company_id', $companyId)        
            ->whereNotIn('id', $userIdsOnPage)
            ->orderBy('last_online', 'desc') // Sort by last_online in descending order
            ->get(['id', 'name', 'email', 'contact_link', 'last_online']);

        // Assign the result to offlineUsers
        // $this->offlineUsers = $users;
    }

    public function showReport()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
         $companyId = Auth::user()->company_id;

        // Fetch all users with their weekly points and weekly status
        $this->userReports = User::where('company_id',$companyId)
        ->with([

            'locations' => function ($query) use ($startOfWeek, $endOfWeek) {
                $query->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
            },
        ])
            ->get()
            ->map(function ($user) use ($startOfWeek, $endOfWeek) {
                $weeklyPoints = $user->locations->sum('total_points');
                $weeklyStatus = $this->getWeeklyStatus($weeklyPoints);

                // Categorize users based on their weekly status
                if ($weeklyStatus == 'Bad') {
                    // Add to badUsers array
                    $this->badUsers[] = [
                        'user' => $user,
                        'weekly_points' => $weeklyPoints,
                        'weekly_status' => $weeklyStatus,
                    ];
                } else {
                    // Add to goodUsers array (Good or Excellent)
                    $this->goodUsers[] = [
                        'user' => $user,
                        'weekly_points' => $weeklyPoints,
                        'weekly_status' => $weeklyStatus,
                    ];
                }
            });

        // Sort badUsers by weekly_points (ascending) and keep the bottom 3
        $this->badUsers = collect($this->badUsers)
            ->sortBy('weekly_points') // Sort by points in ascending order
            ->take(3) // Take only the bottom 3 users
            ->values() // Reindex the array to maintain a clean numeric index
            ->toArray(); // Convert the collection back to a regular array

        // Sort goodUsers by weekly_points (descending) and keep the top 3
        $this->goodUsers = collect($this->goodUsers)
            ->sortByDesc('weekly_points') // Sort by points in descending order
            ->take(3) // Take only the top 3 users
            ->values() // Reindex the array to maintain a clean numeric index
            ->toArray(); // Convert the collection back to a regular array
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

    public function render()
    {
        $this->showReport();

        // Pass the user reports to the view
        return view('livewire.admin.dashboard.show', [
            'usersOnPage' => $this->usersOnPage,
            'goodUsers' => $this->goodUsers,
            'badUsers' => $this->badUsers,
            'showOfflineUser' => $this->showOfflineUser,
            'offlineUsers' => $this->offlineUsers,
            'locations' => $this->locations,
            'contactLink' => $this->contactLink,
        ]);
    }
}
