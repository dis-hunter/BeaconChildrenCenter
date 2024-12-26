<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('doctors')->insert([
            [
                'staff_id' => 1,
                'specialization' => "Pediatrician",
                'created_at' => now(),
                'updated_at' => now(),
                
            ],
            [
                'staff_id' => 2,
                'specialization' => "Occupational Therapist",
                'created_at' => now(),
                'updated_at' => now(),
                
            ],
            [
                'staff_id' => 3,
                'specialization' => "Speech Therapist",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_id' => 4,
                'specialization' => "Physiotherapist",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_id' => 5,
                'specialization' => "Nutritionist",
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
