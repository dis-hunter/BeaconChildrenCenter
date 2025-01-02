<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class triage_assessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('triage_assessment')->insert([
            ['assessment'=>'Emergency'],
            ['assessment'=>'Priority'],
            ['assessment'=>'Routine'],
            ['assessment'=>'Other']
        ]);
    }
}
