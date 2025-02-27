<?php

namespace Database\Seeders;

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
            ['visit_type' => 'Paediatric Consultation', 'normal_price' => 3000, 'sponsored_price' => 2000],
            ['visit_type' => 'General Consultation', 'normal_price' => 3500, 'sponsored_price' => 2500],
            ['visit_type' => 'Developmental Assessment', 'normal_price' => 4000, 'sponsored_price' => 3000],
            ['visit_type' => 'Occupational Therapy', 'normal_price' => 3800, 'sponsored_price' => 2800],
            ['visit_type' => 'Physiotherapy', 'normal_price' => 3700, 'sponsored_price' => 2700],
            ['visit_type' => 'Speech Therapy', 'normal_price' => 3600, 'sponsored_price' => 2600],
            ['visit_type' => 'Psychotherapy', 'normal_price' => 3400, 'sponsored_price' => 2400],
            ['visit_type' => 'Nutritionist', 'normal_price' => 3300, 'sponsored_price' => 2300],
            ['visit_type' => 'Medical Reports', 'normal_price' => 3200, 'sponsored_price' => 2200],
            ['visit_type' => 'Therapy Reports', 'normal_price' => 3100, 'sponsored_price' => 2100],
            ['visit_type' => 'Review', 'normal_price' => 3050, 'sponsored_price' => 2050],
            ['visit_type' => 'Other', 'normal_price' => 2900, 'sponsored_price' => 2000],
        ]);
    }
}
