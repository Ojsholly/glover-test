<?php

namespace App\Providers;

use App\Events\NewUpdateRequestedEvent;
use App\Events\UpdateApprovedEvent;
use App\Listeners\ImplementUpdateApprovalListener;
use App\Listeners\SendUpdateCreationNotificationListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        NewUpdateRequestedEvent::class => [
          SendUpdateCreationNotificationListener::class,
        ],
        UpdateApprovedEvent::class => [
          ImplementUpdateApprovalListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
