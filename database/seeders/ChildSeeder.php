<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Import the DB facade

class ChildSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('children')->insert([
            [
                'fullname' => json_encode(['first_name' => 'John', 'middle_name' => 'Doe', 'last_name' => 'Smith']),
                'dob' => '2018-05-10', 
                'birth_cert' => 'BC/123456', 
                'gender_id' => 1, 
                'registration_number' => 'REG-001', 
                'parent_id' => 1, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fullname' => json_encode(['first_name' => 'Alice', 'middle_name' => 'Wilson', 'last_name' => 'Johnson']),
                'dob' => '2020-01-22',
                'birth_cert' => 'BC/789012',
                'gender_id' => 2, 
                'registration_number' => 'REG-002',
                'parent_id' => 2, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);//
    }
}
