<?php

namespace Database\Seeders;

use App\Models\Update;
use Illuminate\Database\Seeder;

class UpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Update::factory(50)->create();
    }
}
