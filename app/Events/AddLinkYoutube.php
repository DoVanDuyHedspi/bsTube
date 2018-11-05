<?php

namespace App\Events;

use App\Link;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AddLinkYoutube implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $link;

    public function __construct(Link $link)
    {
        $this->link = $link;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('add-link');
    }
}
