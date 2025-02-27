<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentModes extends Seeder
{

    public function run(): void
    {
        $paymentModes = [
            ['name' => 'INSURANCE'],
            ['name' => 'NCPWD'],
            ['name' => 'CASH'],
            ['name'=> 'PROBONO'],
            ['name' => 'OTHER'],
        ];

        DB::table('payment_modes')->insert($paymentModes);
    }
}
