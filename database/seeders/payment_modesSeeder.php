<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class payment_modesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_modes')->insert([
            ['payment_mode'=>'MPESA'],
            ['payment_mode'=>'CASH'],
            ['payment_mode'=>'BANK'],
            ['payment_mode'=>'Other'],
        ]);
    }
}
