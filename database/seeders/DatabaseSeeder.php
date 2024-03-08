<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->count(3)->has(Company::factory()->count(5)->state(function (array $attributes, User $user) {
            return ['user_id' => $user->id];
        }))->create([
             'password' => env('TEST_USERS_PASSWORD')
         ]);

    }
}
