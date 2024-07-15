<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::all();
        $user = $users->random();

        return [
            'name' => fake()->unique()->word(),
            'description' => fake()->sentences(2, true),
            'is_active' => fake()->boolean(),
            'added_by' => $user->id
        ];
    }
}
