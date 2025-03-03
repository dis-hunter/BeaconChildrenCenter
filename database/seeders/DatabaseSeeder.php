<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\rolesSeeder;
use Database\Seeders\genderSeeder;
use Database\Seeders\relationshipsSeeder;
use Database\Seeders\specializationSeeder;
use Database\Seeders\therapySeeder;
use Database\Seeders\triage_assesmentSeeder;
use Database\Seeders\visit_typeSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            rolesSeeder::class,
            genderSeeder::class,
            relationshipsSeeder::class,
            specializationSeeder::class,
            therapySeeder::class,
            triage_assesmentSeeder::class,
            visit_typeSeeder::class,


        ]);
    }
}
