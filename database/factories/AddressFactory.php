<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $countries = Country::all();
        $country = $countries->random();

        return [
            'unit_number' => fake()->numberBetween(),
            'street_number' => fake()->numberBetween(),
            'address_line1' => fake()->sentence(),
            'address_line2' => fake()->sentence(),
            'city' => fake()->city(),
            'region' => fake()->state(),
            'postal_code' => fake()->postcode(),
            'country_id' => $country->id,
        ];
    }
}
