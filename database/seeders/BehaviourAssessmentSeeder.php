<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BehaviourAssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('behaviour_assessment')->insert([
            [
                "visit_id"=> 1,
                "child_id"=> 1,
                "doctor_id"=> 2,
                "data"=>[
                    "HyperActivity" => "Moderate hyperactivity observed in play",
                    "Attention" => "Short attention span but improves with engagement",
                    "SocialInteractions" => "Interacts well with peers but needs encouragement",
                    "MoodAnxiety" => "Generally happy but occasional signs of anxiety in new situations",
                    "PlayInterests" => "Prefers building blocks and outdoor games",
                    "Communication" => "Speaks in short sentences; improving vocabulary",
                    "RRB" => "Shows repetitive hand movements when excited",
                    "SensoryProcessing" => "Sensitive to loud noises and bright lights",
                    "Sleep" => "Sleeps well but occasional difficulty settling at bedtime",
                    "Adaptive" => "Independent in dressing but needs help with shoe tying"
                ],
            ],
            [
                "visit_id"=> 2,
                "child_id"=> 2,
                "doctor_id"=> 2,
                "data"=> [
                    "HyperActivity" => "Low hyperactivity; calm during structured tasks",
                    "Attention" => "Good focus on tasks of interest; easily distracted otherwise",
                    "SocialInteractions" => "Enjoys group activities but hesitant to initiate interaction",
                    "MoodAnxiety" => "Appears content; no visible signs of anxiety",
                    "PlayInterests" => "Likes puzzles and drawing; enjoys role-play games",
                    "Communication" => "Uses full sentences; clear speech with occasional pauses",
                    "RRB" => "Tends to arrange toys in patterns during play",
                    "SensoryProcessing" => "Avoids sticky textures but tolerates most other sensory inputs",
                    "Sleep" => "Regular sleep patterns with no known disturbances",
                    "Adaptive" => "Manages daily routines well; independent in most activities"
            ],
        ],
        ]);
    }
}
