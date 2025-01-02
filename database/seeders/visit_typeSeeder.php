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
            ['visit_type' => 'Consultation'],
            ['visit_type' => 'Follow-Up'],
            ['visit_type' => 'Emergency'],
            ['visit_type' => 'Walk-In'],
            ['visit_type'=>'Other'],
        ]);
    }
}
