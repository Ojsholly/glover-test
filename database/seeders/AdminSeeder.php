<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin1 = User::create([
            'first_name' => "John",
            'last_name' => "Doe",
            'uuid' => Str::uuid(),
            'reference' => Str::random(10),
            'email' => 'johndoe@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10)
        ]);

        $admin2 = User::create([
            'first_name' => "Jane",
            'last_name' => "Doe",
            'email' => 'janedoe@gmail.com',
            'reference' => Str::random(10),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10)
        ]);

        $admin1->assignRole('admin');
        $admin2->assignRole('admin');
    }
}
