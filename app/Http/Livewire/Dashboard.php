<?php

namespace App\Http\Livewire;

use App\Models\Location;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{

    public $usersOnPage = []; // Public property as an array

    protected $rules = [
        'usersOnPage.*.id' => 'required|integer',
        'usersOnPage.*.name' => 'required|string',
        'usersOnPage.*.email' => 'required|email',
        'usersOnPage.*.locations' => 'nullable|array',
        'usersOnPage.*.locations.*.created_at' => 'nullable|date',
        'usersOnPage.*.locations.*.updated_at' => 'nullable|date',
        'usersOnPage.*.locations.*.status' => 'nullable|string',
    ];

    public function updateUserData($users)
    {
        $userIds = collect($users)->pluck('id');

        $this->usersOnPage = User::whereIn('id', $userIds)
            ->with(['locations' => function ($query) {
                $query->whereDate('created_at', today())
                      ->orderBy('created_at', 'desc')
                      ->limit(1);
            }])
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
                            'status' => $location->status,
                            'type' => $location ->type,
                            'in_range' => $location->in_range,
                        ];
                    })->toArray(),
                ];
            })->toArray(); // Convert to plain array

        //logger()->info($this->usersOnPage);
    }

    public function render()
    {
        return view('livewire.admin.dashboard.show', ['usersOnPage' => $this->usersOnPage]);
    }
}
