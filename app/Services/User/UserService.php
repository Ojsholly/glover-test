<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\Service;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use Throwable;

class UserService extends Service
{
    /**
     * @param array $data
     * @param string $role
     * @return mixed
     * @throws Throwable
     */
    public function store(array $data, string $role = 'user'): mixed
    {
        $user = User::create($data + ['reference' => Str::random(10)]);

        throw_if(!$user, new Exception("Error creating account.", 500));

        dispatch(function () use ($user, $role){
            $user->assignRole($role);

            event(new Registered($user));
        });

        return $user;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws Throwable
     */
    public function show(array $data): mixed
    {
        $user = User::where($data)->first();

        throw_if(!$user, new ModelNotFoundException("Requested user account not found"));

        return $user;
    }
}
