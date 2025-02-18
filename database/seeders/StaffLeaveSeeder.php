<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StaffLeaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Inserting leave record for staff_id 14
        DB::table('staff_leave')->insert([
            'staff_id' => 14,  // Staff ID
            'leave_type' => 'Sick Leave',  // Type of leave
            'start_date' => Carbon::parse('2025-02-01'),  // Start date of leave
            'end_date' => Carbon::parse('2025-02-03'),  // End date of leave
            'status' => 'Approved',  // Leave status
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('staff_leave')->insert([
            'staff_id' => 14,  // Staff ID
            'leave_type' => 'Vacation Leave',  // Type of leave
            'start_date' => Carbon::parse('2025-02-10'),  // Start date of leave
            'end_date' => Carbon::parse('2025-02-20'),  // End date of leave
            'status' => 'Pending',  // Leave status
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
