<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerinatalHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('perinatal_history')->insert([
            [
                "child_id"=> 1,
                "doctor_id"=> 2,
                "data"=> json_encode([
                    "preConception" => "Planned pregnancy with prenatal vitamins",
                    "antenatalHistory" => "Routine antenatal visits with no complications",
                    "parity" => "1",
                    "gestation" => "Full term (40 weeks)",
                    "labour" => "Normal progression, 8 hours",
                    "delivery" => "Vaginal delivery",
                    "agarScore" => "9 at 1 minute, 10 at 5 minutes",
                    "bwt" => "3.5 kg",
                    "bFeeding" => "Initiated within the first hour",
                    "hypoglaecemia" => "No signs",
                    "siezures" => "None",
                    "juandice" => "Mild, resolved without treatment",
                    "rds" => "None",
                    "sepsis" => "Negative blood cultures"
                ]),
            ],
            [
                "child_id"=> 2,
                "doctor_id"=> 2,
                "data"=> json_encode([
                    "preConception" => "Unplanned but healthy pregnancy",
                    "antenatalHistory" => "Gestational diabetes managed with diet",
                    "parity" => "2",
                    "gestation" => "Preterm (35 weeks)",
                    "labour" => "Induced due to complications",
                    "delivery" => "Cesarean section",
                    "agarScore" => "7 at 1 minute, 8 at 5 minutes",
                    "bwt" => "2.8 kg",
                    "bFeeding" => "Delayed due to NICU stay",
                    "hypoglaecemia" => "Monitored, resolved within 24 hours",
                    "siezures" => "None observed",
                    "juandice" => "Phototherapy required",
                    "rds" => "Moderate, treated with CPAP",
                    "sepsis" => "Prophylactic antibiotics given"
                ]),
            ],
        ]);
    }
}