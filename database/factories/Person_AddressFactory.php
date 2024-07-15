<?php

namespace Database\Factories;

use App\Models\Person;
use App\Models\Address;
use App\Models\Person_Address;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person_Address>
 */

class Person_AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {

        $people = Person::all();
        $addresses = Address::all();

        do {

            $person = $people->random();
            $address = $addresses->random();

        } while (Person_Address::where('person_id', $person->id)->where('address_id', $address->id)->exists());

        return [
            'person_id' => $person->id,
            'address_id' => $address->id,
            'is_active' => fake()->boolean(),
            'is_default' => fake()->boolean()
        ];
    }
}
