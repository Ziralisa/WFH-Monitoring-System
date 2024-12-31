<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class GetPlace extends Component
{
    public $latitude;
    public $longitude;
    public $town;
    public $country;

    public function getPlace()
{
    if (!$this->latitude || !$this->longitude) {
        session()->flash('error', 'Latitude and Longitude are required.');
        return;
    }

    // Build the URL
    $url = "https://maps.googleapis.com/maps/api/geocode/json";
    $params = [
        'latlng' => "{$this->latitude},{$this->longitude}",
        'sensor' => 'false',
        'key' => env('GOOGLE_MAP_KEY'), // Add your API key here
    ];

    // Make the API call
    $response = Http::get($url, $params);

    if ($response->ok()) {

        $data = $response->json();

        // Check if the results are available
        if (!empty($data['results'][0]['address_components'])) {
            $components = $data['results'][0]['address_components'];

            // Retrieve the town (locality) using 'locality' type
            $this->town = collect($components)->firstWhere(function ($component) {
                return in_array('locality', $component['types']);
            })['long_name'] ?? null;

            // Retrieve the state using 'administrative_area_level_1' type (state/region)
            $this->state = collect($components)->firstWhere(function ($component) {
                return in_array('administrative_area_level_1', $component['types']);
            })['long_name'] ?? null;

            // Flash success message with state and town details
            session()->flash('success', 'Location fetched successfully! State: ' . $this->state . ' Town: ' . $this->town);
        } else {
            session()->flash('error', 'No results found.');
        }
    } else {
        session()->flash('error', 'Failed to fetch location.');
    }
}



    public function render()
    {
        return view('livewire.get-place');
    }
}
