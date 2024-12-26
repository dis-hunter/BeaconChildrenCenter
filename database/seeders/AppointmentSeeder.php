<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('appointments')->insert([
            [
                'child_id' => 5,
                'doctor_id' => 1,
                'staff_id'=>1,
                'appointment_date' => '2021-05-10',
                'appointment_time'=>'10:00:00',
                'status'=>'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'child_id' => 6,
                'doctor_id' => 2,
                'staff_id'=>2,
                'appointment_date' => '2021-05-12',
                'appointment_time'=>'11:00:00',
                'status'=>'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]
            ]);
    }
}
