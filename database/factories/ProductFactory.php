<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
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
            'description' => fake()->unique()->sentences(2, true),
            'is_active' => fake()->boolean(),
            'rating' => fake()->numberBetween(50, 100),
            'added_by' => $user->id
        ];
    }
}
