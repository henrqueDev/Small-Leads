<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\User;
use App\Models\Lead;
use App\Models\Tag;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->count(1)->create([
            'password' => env('TEST_USERS_PASSWORD', 'secret')
        ]);

        Company::factory()->count(1)->create();
        
        Lead::factory()->count(3)->create();
    }
}
