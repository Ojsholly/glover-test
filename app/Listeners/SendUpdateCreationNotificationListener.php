<?php

namespace App\Listeners;

use App\Events\NewUpdateRequestedEvent;
use App\Mail\NewUpdateRequestedNotificationMail;
use App\Services\Admin\AdminService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendUpdateCreationNotificationListener implements ShouldQueue
{
    private AdminService $adminService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\NewUpdateRequestedEvent  $event
     * @return void
     */
    public function handle(NewUpdateRequestedEvent $event)
    {
        $admins = $this->adminService->findAll();
        $update = data_get($event, 'update');

        $emails = $admins->except(['uuid' => data_get($update, 'requested_by')])->pluck('email');

        $emails->each(function ($email) use ($update){
            Mail::to($email)->send(new NewUpdateRequestedNotificationMail($update));
        });

    }
}
