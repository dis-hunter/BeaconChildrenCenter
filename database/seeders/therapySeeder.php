<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class therapySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('therapy')->insert([
            ['therapy_type'=>'Occupational Therapy'],
            ['therapy_type'=>'Physiotherapy'],
            ['therapy_type'=>'Speech Therapy'],
            ['therapy_type'=>'Psychotherapy'],
            ['therapy_type'=>'Nutritionist'],
        ]);
    }
}