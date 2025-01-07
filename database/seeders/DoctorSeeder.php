<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('doctors')->insert([
            [
                'staff_id' => 1,
                'specialization_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                
            ],
            [
                'staff_id' => 2,
                'specialization_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                
            ],
            [
                'staff_id' => 3,
                'specialization_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_id' => 4,
                'specialization_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_id' => 5,
                'specialization_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
