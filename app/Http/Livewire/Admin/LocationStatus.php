<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Pusher\Pusher;

class LocationStatus extends Component
{
    public $locations = [];

    public function mount()
    {
        // Initial fetching of locations (fetch from your database)
        $this->locations = $this->fetchLocations();
    }

    public function render()
    {
        return view('livewire.location-status');
    }

    public function fetchLocations()
    {
        // Fetch location data from your database
        // Example:
        return [
            ['name' => 'Staff A', 'status' => 'At Home'],
            ['name' => 'Staff B', 'status' => 'Meeting with Client'],
            ['name' => 'Staff C', 'status' => 'Excused with Permission'],
            ['name' => 'Staff D', 'status' => 'Out of Range'],
            // Add more staff data
        ];
    }

    public function updatedLocations($locations)
    {
        // Broadcast updated locations to Pusher
        broadcast(new \App\Events\LocationUpdated($locations));
    }
}