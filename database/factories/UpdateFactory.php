<?php

namespace Database\Factories;

use App\Models\Update;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UpdateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $updateTypes = [Update::CREATE, Update::UPDATE, Update::DELETE];

        $user = User::role('user')->get()->random();
        $admin = User::role('admin')->get()->random();
        $count = count($updateTypes);

        return [
            'user_id' => $user->uuid,
            'requested_by' => $admin->uuid,
            'type' => $updateTypes[mt_rand(0, $count - 1)],
            'details' => $user->only(['first_name', 'last_name', 'email']),
            'confirmed_by' => null,
            'confirmed_at' => null
        ];
    }
}
