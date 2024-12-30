<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class child_parentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('child_parent')->insert([
            [
                'parent_id'=>1,
                'child_id'=>1,
            ],
            [
                'parent_id'=>2,
                'child_id'=>2,
            ],
        ]);
    }
}
