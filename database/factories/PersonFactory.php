<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->name(),
            'last_name' => fake()->name(),
            'username' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make(fake()->password()),
            'phone' => fake()->phoneNumber(),
            'birth_date' => fake()->date(format: 'Y-m-d', max: 'now - 18 years'), /*$max = now()->subYears(18)->toDateString()*/
            'is_active' => fake()->boolean(),
        ];
    }
}
