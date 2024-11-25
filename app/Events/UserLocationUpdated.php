<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserLocationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public function __construct()
    {
        //
    }

    public function broadcastOn(): array
    {

        logger()->info('Broadcasting to presence-onthispage!');


        return [
            new PresenceChannel('presence-onthispage'),
        ];
    }

    public function broadcastAs() {
        return 'user-location-updated';
    }

}
