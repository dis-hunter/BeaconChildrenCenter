<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DevelopmentAssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('development_assessment')->insert([
            [
                "visit_id"=> 1,
                "child_id"=> 1,
                "doctor_id"=> 2,
                "data"=> [
                    "grossMotor" => "Able to walk independently; runs with balance",
                    "fineMotor" => "Can hold a pencil and draw simple shapes",
                    "speech" => "Speaks in short sentences; vocabulary improving",
                    "selfCare" => "Can dress with minimal assistance; feeds independently",
                    "cognitive" => "Recognizes shapes, colors, and basic numbers",
                    "grossDevAge" => "4", // Gross motor skills development age
                    "fineDevAge" => "3.5", // Fine motor skills development age
                    "speechDevAge" => "4", // Speech skills development age
                    "selfDevAge" => "4", // Self-care skills development age
                    "cognitiveDevAge" => "4.5" // Cognitive skills development age
                ],
            ],
            [
                "visit_id"=> 2,
                "child_id"=> 2,
                "doctor_id"=> 2,
                "data"=> [
                    "grossMotor" => "Walks with support; difficulty running or jumping",
                    "fineMotor" => "Can stack blocks but struggles with precise tasks",
                    "speech" => "Limited vocabulary; uses gestures to communicate",
                    "selfCare" => "Needs help with dressing and feeding",
                    "cognitive" => "Understands simple instructions; enjoys solving puzzles",
                    "grossDevAge" => "2.5", // Gross motor skills development age
                    "fineDevAge" => "2", // Fine motor skills development age
                    "speechDevAge" => "2.5", // Speech skills development age
                    "selfDevAge" => "2", // Self-care skills development age
                    "cognitiveDevAge" => "3" // Cognitive skills development age
                ],
            ],
        ]);
    }
}