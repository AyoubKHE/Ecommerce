<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Person;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        for ($i = 1; $i <= 3; $i++) {

            if (!empty(User::factory()->raw())) {
                User::factory(1)
                    ->create();
            }
        }
    }

    // public function run(): void
    // {
    //     User::factory()
    //     ->count(3)
    //     ->for(Person::factory())
    //     ->for(UserRole::factory())
    //     ->create();
    // }
}
