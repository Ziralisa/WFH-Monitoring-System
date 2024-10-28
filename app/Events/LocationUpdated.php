<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel; // This import is used for private channel broadcasting
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LocationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $locationStatus; // This will hold the location status data

    /**
     * Create a new event instance.
     *
     * @param array $locationStatus
     * @return void
     */
    public function __construct(array $locationStatus) // Constructor to initialize data
    {
        $this->locationStatus = $locationStatus; // Assign the data to the property
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        // Define the broadcasting channel (PrivateChannel for restricted access)
        return new PrivateChannel('location-status');
    }

    /**
     * Get the event's name for broadcasting.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'location.updated'; // The name used when broadcasting the event
    }
}