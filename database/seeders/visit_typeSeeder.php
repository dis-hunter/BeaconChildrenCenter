<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class visit_typeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('visit_type')->insert([
            ['visit_type' => 'Paediatric Consultation'],
            ['visit_type' => 'General Consultation'],
            ['visit_type' => 'Developmental Assessment'],
            ['visit_type' => 'Occupational Therapy'],
            ['visit_type' => 'Physiotherapy'],
            ['visit_type' => 'Speech Therapy'],
            ['visit_type' => 'Psychotherapy'],
            ['visit_type' => 'Nutritionist'],
            ['visit_type' => 'Medical Reports'],
            ['visit_type' => 'Therapy Reports'],
            ['visit_type' => 'Review'],
            ['visit_type' => 'Other'],
        ]);
    }
}
