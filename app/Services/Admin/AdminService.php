<?php

namespace App\Services\Admin;

use App\Services\Service;
use App\Services\User\UserService;
use Throwable;

class AdminService extends Service
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws Throwable
     */
    public function register(array $data)
    {
        return $this->userService->store($data, 'admin');
    }
}
