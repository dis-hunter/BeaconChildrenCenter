<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DevMilestonesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('development_milestones')->insert([
            [
                "visit_id"=> 1,
                "child_id"=> 1,
                "doctor_id"=> 2,
                "data"=> json_encode([
                        "Neck Support" => "3", // Early neck support development, starting to hold up head
                        "Sitting" => "6", // Can sit without support
                        "Crawling" => "8", // Crawls confidently
                        "Standing" => "10", // Can stand with support
                        "Walking" => "12", // Starts walking independently
                        "Cooing/Babbling" => "4", // Begins vocal experimentation
                        "First Word" => "10", // Says first recognizable word
                        "Vocabulary" => "15", // Uses a few words meaningfully
                        "Phrase Speech" => "20", // Combines words into short phrases
                        "Conversational" => "24", // Starts basic conversations
                        "Smiling/Laughing" => "2", // Smiles responsively
                        "Attachments" => "6", // Forms strong attachments to caregivers
                        "Feeding" => "12", // Can eat independently with minor mess
                        "Elimination" => "18", // Starts toilet training
                        "Teething" => "6" // First teeth emerge
                    ]),
                ],
            [
                "visit_id"=> 2,
                "child_id"=> 2,
                "doctor_id"=> 2,
                "data" =>json_encode([
                    "Neck Support" => "4", // Holds head up steadily
                    "Sitting" => "7", // Sits with minimal wobbling
                    "Crawling" => "9", // Crawls quickly and explores surroundings
                    "Standing" => "11", // Pulls to stand with support
                    "Walking" => "14", // Walks with improved coordination
                    "Cooing/Babbling" => "5", // Makes a variety of sounds
                    "First Word" => "11", // Speaks first clear word
                    "Vocabulary" => "18", // Learns new words rapidly
                    "Phrase Speech" => "22", // Constructs simple sentences
                    "Conversational" => "30", // Engages in simple back-and-forth talk
                    "Smiling/Laughing" => "3", // Laughs aloud
                    "Attachments" => "5", // Prefers familiar people
                    "Feeding" => "10", // Handles finger foods well
                    "Elimination" => "20", // Nearly toilet-trained
                    "Teething" => "7" // Teething well underway
                ]),
            ]
        ]);
    }
}
