<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;

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
                'fullname' => json_encode(['first_name' => 'Nurse']),
                'telephone' => '000000000',
                'email' =>  'nurse@gmail.com',
                'password' => Hash::make('password'),
                'staff_no' => 1,
                'gender_id' => 1,
                'role_id' => 1,
 
            ],
            [
                'fullname' => json_encode(['first_name' => 'Doctor']),
                'telephone' => '1111111111',
                'email' =>  'doctor@gmail.com',
                'password' => Hash::make('password'),
                'staff_no' => 2,
                'gender_id' => 1,
                'role_id' => 2,
                'specialization_id'=>1, 
            ],
            [
                'fullname' => json_encode(['first_name' =>'Receptionist']),
                'telephone' => '2222222222',
                'email' => 'receptionist@gmail.com',
                'password' => Hash::make('password'),
                'staff_no' => 3,
                'gender_id' => 2,
                'role_id' => 3,
            ],
            [
                'fullname' => json_encode(['first_name' => 'Admin']),
                'telephone' => '3333333333',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'staff_no' => 4,
                'gender_id' => 1,
                'role_id' => 4,
            ],
        ]);
    }
}
