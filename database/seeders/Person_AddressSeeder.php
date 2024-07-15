<?php

namespace Database\Seeders;

use App\Models\Person_Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Person_AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        for ($i = 1; $i <= 20; $i++) {
            Person_Address::factory(1)
            ->create();
        }

        //! cette méthode possede des probleme car elle stocke les model à la fin et non pas un par un
        // Person_Address::factory()
        //     ->count(20)
        //     ->create();
    }
}
