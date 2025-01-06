<?php

namespace App\Http\Livewire;

use App\Models\User;
use Http;
use Livewire\Component;
use Livewire\WithPagination;
use Log;

class AttendanceLog extends Component
{
    use WithPagination;

    public User $user;

    public function getPlace($latitude, $longitude)
    {
        if (!$latitude || !$longitude) {
            return 'N/A';
        }

        $url = "https://maps.googleapis.com/maps/api/geocode/json";
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

    public function render()
    {
        $locations = $this->user->locations()->latest()->paginate(10);

        $locations->getCollection()->transform(function ($location) {
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

        return view('livewire.attendance-log', [
            'locations' => $locations,
        ]);
    }
}

