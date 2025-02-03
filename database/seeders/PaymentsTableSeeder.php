<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Add this line
use Carbon\Carbon; // Add this line if not already present

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('payments')->insert([
            [
                'visit_id' => 2,
                'child_id' => 2,
                'staff_id' => 3,
                'payment_mode_id' => 1, // CASH
                'amount' => 1000,
                'payment_date' => Carbon::now()->subDays(5),
                'invoice_numnber' => 3, // Corrected to use the invoice_id (3)
                'receipt_number' => 'REC1001', // Example receipt number
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'visit_id' => 4,
                'child_id' => 1,
                'staff_id' => 3,
                'payment_mode_id' => 2, // INSURANCE
                'amount' => 7000,
                'payment_date' => Carbon::now()->subDays(3),
                'invoice_numnber' => 4, // Corrected to use the invoice_id (4)
                'receipt_number' => 'REC1002', // Example receipt number
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
           
        ]);
    }
}
