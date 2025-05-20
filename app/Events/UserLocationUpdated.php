<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserLocationUpdated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function broadcastOn(): array
    {
        logger()->info('Broadcasting to presence-onthispage!');
        return [new PresenceChannel('presence-onthispage')];
    }

    public function broadcastAs()
    {
        return 'user-location-updated';
    }

    public function broadcastWith(): array
    {
        // Safely retrieve the first location for the user
        $latestLocation = $this->user->locations()
        ->whereDate('created_at', today())
        ->latest('created_at')
        ->first();

        return [
            'in_range' => $latestLocation->in_range,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
        ];
    }
}
