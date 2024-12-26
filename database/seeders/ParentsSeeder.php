<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parents')->insert([
            [
                'fullname' => json_encode(['first_name' => 'Jane', 'middle_name' => '', 'last_name' => 'Smith']),
                'dob' => '1980-03-15',
                'gender_id' => 2, // Assuming 2 is for Female
                'telephone' => '1234567890',
                'email' => 'jane.smith@example.com',
                'national_id' => 'ID12345678',
                'employer' => 'Acme Corp',
                'insurance' => 'Health Insurance Co',
                'referer' => 'Dr. Referer',
                'relationship_id' => 1, // Assuming 1 is for Mother
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fullname' => json_encode(['first_name' => 'David', 'middle_name' => 'Lee', 'last_name' => 'Johnson']),
                'dob' => '1978-11-20',
                'gender_id' => 1, // Assuming 1 is for Male
                'telephone' => '9876543210',
                'email' => 'david.johnson@example.com',
                'national_id' => 'ID98765432',
                'employer' => 'Tech Solutions',
                'insurance' => 'Life Insurance Inc',
                'referer' => null,
                'relationship_id' => 2, // Assuming 2 is for Father
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more parent data here...
        ]);
    }
}
