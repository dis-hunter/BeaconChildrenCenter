<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('staff')->insert([
            [
                'fullname' => json_encode(['first_name' => 'Emmanuel', 'middle_name' => 'Doe', 'last_name' => 'Oringe']),
                'telephone' => '1234567890',
                'email' =>  'emmanueloringe@gmail.com',
                'password' => 'password',
                'staff_no' => 1,
                'gender_id' => 1,
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
 
            ],
            [
                'fullname' => json_encode(['first_name' => 'Mary', 'middle_name' => 'Williams', 'last_name' => 'Johnson']),
                'telephone' => '9876543210',
                'email' => 'eoringe@gmail.com',
                'password' => 'password',
                'staff_no' => 2,
                'gender_id' => 2,
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                
            ],
            [
                'fullname' => json_encode(['first_name' => 'David', 'middle_name' => 'Lee', 'last_name' => 'Johnson']),
                'telephone' => '9876543210',
                'email' => 'rteg@gmail.com',
                'password' => 'password',
                'staff_no' => 3,
                'gender_id' => 1,
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fullname' => json_encode(['first_name' => 'Aisha', 'middle_name' => 'Lee', 'last_name' => 'Kelly']),
                'telephone' => '9876543210',
                'email' => 'rtveg@gmail.com',
                'password' => 'password',
                'staff_no' => 4,
                'gender_id' => 2,
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                'fullname' => json_encode(['first_name' => 'Peter', 'middle_name' => 'Samson', 'last_name' => 'Mahama']),
                'telephone' => '9876543210',
                'email' => 'tyers@gmail.com',
                'password' => 'password',
                'staff_no' => 5,
                'gender_id' => 1,
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
