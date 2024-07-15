<?php

namespace Database\Factories;

use App\Models\Person;
use App\Models\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $person = Person::doesntHave('user')->inRandomOrder()->first();

        if ($person !== null) {

            $usersRoles = UserRole::all();
            $userRole = $usersRoles->random();

            return [
                'person_id' => $person->id,
                'userrole_id' => $userRole->id,
            ];
        } else {
            return [];
        }
    }
}
