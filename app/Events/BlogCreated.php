<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BlogCreated  implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    
    public $blog;

    /**
     * Create a new event instance.
     */
    public function __construct($blog)
    {
        $this->blog=$blog;
    }

    public function broadcastOn()
    {
        return new Channel('my-channel');
    }

    public function broadcastAs() {
        return 'form-submitted';
    }
}
