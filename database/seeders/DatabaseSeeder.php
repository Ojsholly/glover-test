<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            RolePermissionSeeder::class,
        );

        $this->call(
            AdminSeeder::class,
        );

        $this->call(
            UpdateSeeder::class
        );

        \App\Models\User::factory(30)->create();
    }
}
