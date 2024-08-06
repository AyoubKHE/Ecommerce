<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductCategory>
 */
class ProductCategoryFactory extends Factory
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
            'ordering' => fake()->unique()->numberBetween(),
            'is_active' => fake()->boolean(),
            'added_by' => $user->id
        ];
    }
}
