<?php

namespace App\Services\Auth;

use App\Services\Service;
use App\Services\User\UserService;
use Illuminate\Auth\Events\Verified;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class AuthService extends Service
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function validateCredentials(string $email, string $role = "admin")
    {
        try {
            $user = $this->userService->show(['email' => $email], $role);
        } catch(ModelNotFoundException | Throwable $exception){
            return null;
        }

        return $user;
    }

    /**
     * @param string $user_id
     * @return mixed
     * @throws Throwable
     */
    public function verify(string $user_id): mixed
    {
        $user = $this->userService->show(['id' => $user_id]);

        if (!$user->hasVerifiedEmail()){
            $user->markEmailAsVerified();
        }

        event(new Verified($user));

        return $user;
    }
}
