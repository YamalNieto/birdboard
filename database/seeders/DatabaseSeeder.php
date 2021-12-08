<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
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
        Project::factory(5)->create();
        $user = User::factory([
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password')
        ])->create();

        Project::factory(5)->create([
            'user_id' => $user->id
        ]);
    }
}
