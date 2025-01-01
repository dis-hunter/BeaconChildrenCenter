<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class specializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('doctor_specialization')->insert([
            ['specialization'=>'Pediatrician'],
            ['specialization'=>'Occupational Therapy'],
            ['specialization'=>'Speech Therapy'],
            ['specialization'=>'Physiotherapy'],
            ['specialization'=>'Nutrition'],
            ['specialization'=>'ABA'],
            ['specialization'=>'Other'],
        ]);
    }
}
