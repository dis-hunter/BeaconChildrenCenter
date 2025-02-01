<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ChildSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create(); // Create an instance of Faker

        $children = [];

        for ($i = 1; $i <= 100; $i++) {
            $children[] = [
                'fullname' => json_encode([
                    'first_name' => $faker->firstName,
                    'middle_name' => $faker->lastName, // Using lastName as middle name
                    'last_name' => $faker->lastName
                ]),
                'dob' => $faker->date($format = 'Y-m-d', $max = 'now'), // Random date of birth
                'birth_cert' => 'BC/' . $faker->numberBetween(100000, 999999), // Random birth certificate number
                'gender_id' => $faker->numberBetween(1, 2), // Random gender (1 or 2)
                'registration_number' => 'REG-' . $faker->unique()->numberBetween(1000, 9999), // Unique registration number
            ];
        }

        DB::table('children')->insert($children); // Insert all 100 records at once
    }
}
