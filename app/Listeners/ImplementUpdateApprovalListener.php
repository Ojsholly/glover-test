<?php

namespace App\Listeners;

use App\Events\UpdateApprovedEvent;
use App\Models\Update;
use App\Services\User\UserService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ImplementUpdateApprovalListener implements ShouldQueue
{
    private UserService $userService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UpdateApprovedEvent  $event
     * @return void
     */
    public function handle(UpdateApprovedEvent $event)
    {
        $update = data_get($event, 'update');

        DB::transaction(function () use ($update){

            return match ($update->type){
                Update::CREATE => $this->userService->store($update->details + ['password' => Hash::make(Str::random())]),
                Update::UPDATE => $this->userService->update($update->details, $update->user_id),
                Update::DELETE => $this->userService->delete($update->user_id)
            };

        });
    }

}
