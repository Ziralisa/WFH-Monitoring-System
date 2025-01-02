<?php

namespace App\Http\Livewire;

use App\Models\Attendance;
use App\Models\Comment;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public $usersOnPage = [];
    public $userReports = [];
    public $badUsers = [];
    public $goodUsers = [];

    protected $rules = [
        'usersOnPage.*.id' => 'required|integer',
        'usersOnPage.*.name' => 'required|string',
        'usersOnPage.*.email' => 'required|email',
        'usersOnPage.*.locations' => 'nullable|array',
        'usersOnPage.*.locations.*.created_at' => 'nullable|date',
        'usersOnPage.*.locations.*.updated_at' => 'nullable|date',
        'usersOnPage.*.locations.*.status' => 'nullable|string',
    ];

    public $commentContent;
    public $comments = [];
    public function storeComment()
    {
        // Validation
        $this->validate([
            'commentContent' => 'required|string|max:500',
        ]);

        // Store the comment
        Comment::create([
            'content' => $this->commentContent,
            'user_id' => auth()->id(), // Assuming the user is logged in
        ]);

        // Flash the message
        flash()->success('Comment added successfully!');

        // Redirect to the dashboard
        return redirect()->route('dashboard');
    }

    public function deleteComment($commentid)
    {
        // Find and delete the comment
        $comment = Comment::find($commentid);

        if ($comment) {
            $comment->delete();

            // Optionally refresh the comments list
            $this->comments = Comment::latest()->get();

            // Provide feedback to the user
            flash()->success('Comment removed successfully!');
            // Redirect to the dashboard
            return redirect()->route('dashboard');
        } else {
            flash()->error('Comment not found!');
        }
    }
    public function mount()
    {
        $this->comments = Comment::get(); // Load comments on mount
    }

    public function userNotification($status, $username)
    {
        if ($status == 'online') {
            flash()->info($username . ' is now online..');
        } elseif ($status == 'offline') {
            flash()->warning($username . ' is now offline..');
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

    // Simulate adding a new row with dummy data
    public $showOfflineUser = false;
    public $offlineUsers = [];

    public function viewOfflineUsers()
    {

        $this->showOfflineUser = true;
        $users = User::whereHas('locations', function ($query) {
            $query->where('status', 'inactive');
        })
        ->get()
        ->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'locations' => $user->locations->map(function ($location) {
                    return [
                        'created_at' => $location->created_at,
                        'updated_at' => $location->updated_at,
                        'type' => $location->type,
                        'status' => $location->status,
                        'in_range' => $location->in_range,
                    ];
                }),
            ];
        });

        $this->offlineUsers = $users;

    }


    public function showReport()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Fetch all users with their weekly points and weekly status
        $this->userReports = User::with([
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
        // Call the report method to generate the user reports
        $this->showReport();

        // Pass the user reports to the view
        return view('livewire.admin.dashboard.show', [
            'usersOnPage' => $this->usersOnPage,
            'goodUsers' => $this->goodUsers,
            'badUsers' => $this->badUsers,
            'comments' => $this->comments,
            'showOfflineUser' => $this->showOfflineUser,
            'offlineUsers' => $this->offlineUsers,
        ]);
    }
}
