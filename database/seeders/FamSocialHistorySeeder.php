<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FamSocialHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('family_social_history')->insert([
            [
                "visit_id"=> 1,
                "child_id"=> 1,
                "doctor_id"=> 2,
                "data"=> json_encode([
                    "FamilyComposition" => "Mother, Father, 2 siblings\nClose-knit family\nLives in an urban area",
                    "FamilyHealthSocial" => "No history of genetic disorders\nOccasional illnesses like colds\nSupportive extended family",
                    "Schooling" => "Attends local elementary school\nGrade 3\nEnjoys learning and participates in extracurricular activities"
                ]),
            ],
            [
                "visit_id"=> 1,
                "child_id"=> 1,
                "doctor_id"=> 2,
                "data"=> json_encode([
                    "FamilyComposition" => "Single parent (mother)\n2 children\nSupport from grandparents",
                    "FamilyHealthSocial" => "Asthma runs in the family\nFrequent visits to the clinic for check-ups\nModerate social connections",
                    "Schooling" => "Homeschooling due to health reasons\nLearning at grade 2 level\nLoves arts and crafts"                
                ]),
            ],
        ]);
    }
}