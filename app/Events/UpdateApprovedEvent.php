<?php

namespace App\Events;

use App\Models\Update;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateApprovedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Update $update;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Update $update)
    {
        $this->update = $update;
    }
}
