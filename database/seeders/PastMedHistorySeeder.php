<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PastMedHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('past_medical_history')->insert([
            [
                "child_id"=> 1,
                "doctor_id"=> 2,
                "data"=> [
                    "illnesses" => "Frequent colds and flu,Diagnosed with mild asthma,Occasional stomach upsets",
                    "investigations" => "Blood tests for allergies,Chest X-ray for asthma diagnosis,Routine pediatric check-ups",
                    "interventions" => "Inhaler prescribed for asthma,Dietary adjustments for food intolerance,Physiotherapy sessions for improved lung capacity"
                ],
            ],
            [
                "child_id"=> 2,
                "doctor_id"=> 2,
                "data"=> [
                    "illnesses" => "Chickenpox at age 4,Recurring ear infections,Seasonal allergies",
                    "investigations" => "Hearing test after multiple ear infections,Skin prick test for allergy triggers,Comprehensive health screening",
                    "interventions" => "Antibiotics for ear infections,Antihistamines for allergies,Vaccinations updated regularly"                
                ],
            ],
        ]);
    }
}