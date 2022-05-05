<?php

namespace App\Mail;

use App\Models\Update;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUpdateRequestedNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Update $update;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Update $update)
    {
        $this->update = $update;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("New Update Requested - ".config('app.name'))->view('new-update-notification');
    }
}
