<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Channel as Cn;

class ChangePermissions implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $status;
    public $channel;

    public function __construct($status, Cn $channel)
    {
        $this->status = $status;
        $this->channel = $channel;
    }

    
    public function broadcastOn()
    {
        return [
            new PresenceChannel('channel.' . $this->channel->name)
        ];
    }
}
