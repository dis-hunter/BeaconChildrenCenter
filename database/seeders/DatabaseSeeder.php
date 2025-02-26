<?php
use Illuminate\Database\Seeder;

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
