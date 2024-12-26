<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('visits')->insert([
            [
                'visit_date' => '2021-05-10',
                'source_type'=> 'MySource',
                'source_contact'=>'1234567890',
                'visit_type' => 1,
                'child_id' => 5,
                'staff_id' => 1,
                'appointment_id' => 3,

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'visit_date' => '2021-05-12',
                'source_type'=> 'MySource',
                'source_contact'=>'9876543210',
                'visit_type' => 2,
                'child_id' => 6,
                'staff_id' => 2,
                'appointment_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
