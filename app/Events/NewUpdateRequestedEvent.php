<?php

namespace App\Events;

use App\Models\Update;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewUpdateRequestedEvent
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
