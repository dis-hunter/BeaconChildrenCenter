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
                'child_id' => 1,
                'doctor_id' => 2,
                'staff_id'=>3,
                'appointment_date' => '2025-01-04',
                'start_time'=>'10:00:00',
                'end_time'=>'11:00:00',
                'status'=>'pending',
            ],
            [
                'child_id' => 2,
                'doctor_id' => 2,
                'staff_id'=>3,
                'appointment_date' => '2024-01-04',
                'start_time'=>'11:00:00',
                'start_time'=>'12:00:00',
                'status'=>'pending',
            ]
            ]);
    }
}
