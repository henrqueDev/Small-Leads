<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class LeadFactory extends Factory
{
    protected static ?string $user_id;
    protected static ?int $company_id;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'last_name' => fake()->name(),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
            'converted' => false,
            'is_paying' => false,
            'user_id' => static::$user_id ??= 'aaaaaaaa-bbbb-1ccc-8ddd-eeeeeeeeeeee',
            'company_id' => static::$company_id ??= 1
        ];
    }
}
