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
            ['specialization'=>'Peadiatrician'],
            ['specialization'=>'Developmental Paediatrician'],
            ['specialization'=>'Medical Officer'],
            ['specialization'=>'Psychotherapist'],
            ['specialization'=>'Occupational Therapist'],
            ['specialization'=>'Speech Therapist'],
            ['specialization'=>'Physiotherapist'],
            ['specialization'=>'Nutritionist'],
           
        ]);
    }
}