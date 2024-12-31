<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TriageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * 
     */
    public function run()
    {
        DB::table('triage')->insert([
            [

                'visit_id' => 3,
                'child_id' => 5,
                'staff_id' => 1,
                'data' => json_encode([
                    'temperature' => 37.5,
                    'weight' => 12.5,
                    'height' => 0.75,
                    'head_circumference' => 0.45,
                    'blood_pressure' => '120/80',
                    'pulse_rate' => 80,
                    'respiratory_rate' => 20,
                    'oxygen_saturation' => 98,
                    'MUAC' => 11.5,
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'visit_id' => 4,
                'child_id' => 6,
                'staff_id' => 2,
                'data' => json_encode([
                    'temperature' => 38.0,
                    'weight' => 10.5,
                    'height' => 0.65,
                    'HC' => 0.40,
                    'blood_pressure' => '110/70',
                    'pulse_rate' => 90,
                    'respiratory_rate' => 25,
                    'oxygen_saturation' => 95,
                    'MUAC' => 12.5,
                    
                ]),
                'created_at' => now(),
                'updated_at' => now(),  
            ]
            ]);
                
    }
}
