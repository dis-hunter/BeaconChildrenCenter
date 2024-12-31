<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class cnsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cns')->insert([
            [
                "visit_id"=> 1,
                "child_id"=> 1,
                "doctor_id"=> 2,
                "data"=> json_encode([
                    "avpu" => "A", // Alert
                    "vision" => "Normal; no issues reported",
                    "hearing" => "Normal; responds well to sound",
                    "cranialNerves" => "All functions within normal limits",
                    "ambulation" => "Yes; walks independently with steady gait",
                    "cardiovascular" => "Normal heart rate and rhythm; no murmurs detected",
                    "respiratory" => "Clear breath sounds; no wheezing or stridor",
                    "musculoskeletal" => "Full range of motion; no pain or swelling observed"
                ]),
            ],
            [
                "visit_id"=> 2,
                "child_id"=> 2,
                "doctor_id"=> 2,
                "data"=> json_encode([
                    "avpu" => "V", // Responds to Verbal stimuli
                    "vision" => "Mild myopia; corrected with glasses",
                    "hearing" => "Moderate hearing loss in left ear; requires further evaluation",
                    "cranialNerves" => "Cranial nerve VII (facial) shows slight weakness",
                    "ambulation" => "Yes; slight limp observed on the right leg",
                    "cardiovascular" => "Elevated heart rate; follow-up recommended",
                    "respiratory" => "Mild wheezing on exertion; asthma suspected",
                    "musculoskeletal" => "Minor joint stiffness in the morning; improves with movement"
                ]),
            ],
        ]);
    }
}
