<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    protected static ?int  $user_id;
    protected static ?string  $id;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => 'aaaaaaaa-bbbb-1ccc-8ddd-eeeeeeeeeeee',
            'name' => fake()->unique()->name(),
            'user_id' => static::$user_id ??= 1
        ];
    }
}
