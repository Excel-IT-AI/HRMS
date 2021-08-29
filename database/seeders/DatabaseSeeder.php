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
        // \App\Models\User::factory(10)->create();
        // \App\Models\Department::factory(10)->create();
        \App\Models\LeaveType::factory(10)->create();
        \App\Models\Leave::factory(50)->create();
    }
}