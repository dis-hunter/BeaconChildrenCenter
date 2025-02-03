<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChildSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        DB::table('children')->insert([
            [
                'fullname' => json_encode(['first_name' => 'Emmanuel', 'middle_name' => 'Oringe', 'last_name' => 'Doe']),
                'dob' => '1990-04-20',
                'birth_cert' => 'BC/123457',
                'gender_id' => 1,
                'registration_number' => 'REG-003',
            ],
            [
                'fullname' => json_encode(['first_name' => 'Grace', 'middle_name' => 'Chipo', 'last_name' => 'Mwamba']),
                'dob' => '1985-06-11',
                'birth_cert' => 'BC/123458',
                'gender_id' => 2,
                'registration_number' => 'REG-004',
            ],
            [
                'fullname' => json_encode(['first_name' => 'Daniel', 'middle_name' => 'Oscar', 'last_name' => 'Ngugi']),
                'dob' => '1992-08-14',
                'birth_cert' => 'BC/123459',
                'gender_id' => 1,
                'registration_number' => 'REG-005',
            ],
            [
                'fullname' => json_encode(['first_name' => 'Mary', 'middle_name' => 'Akinyi', 'last_name' => 'Adongo']),
                'dob' => '1995-03-22',
                'birth_cert' => 'BC/123460',
                'gender_id' => 2,
                'registration_number' => 'REG-006',
            ],
            [
                'fullname' => json_encode(['first_name' => 'John', 'middle_name' => 'Musa', 'last_name' => 'Ochieng']),
                'dob' => '1990-09-17',
                'birth_cert' => 'BC/123461',
                'gender_id' => 1,
                'registration_number' => 'REG-007',
            ],
            [
                'fullname' => json_encode(['first_name' => 'Rebecca', 'middle_name' => 'Lena', 'last_name' => 'Mwangi']),
                'dob' => '1989-12-05',
                'birth_cert' => 'BC/123462',
                'gender_id' => 2,
                'registration_number' => 'REG-008',
            ],
            [
                'fullname' => json_encode(['first_name' => 'Nashit', 'middle_name' => 'David', 'last_name' => 'Okoth']),
                'dob' => '1993-05-23',
                'birth_cert' => 'BC/123463',
                'gender_id' => 1,
                'registration_number' => 'REG-009',
            ],
            [
                'fullname' => json_encode(['first_name' => 'Sharon', 'middle_name' => 'Mary', 'last_name' => 'Wambui']),
                'dob' => '1998-02-12',
                'birth_cert' => 'BC/123464',
                'gender_id' => 2,
                'registration_number' => 'REG-010',
            ],
            [
                'fullname' => json_encode(['first_name' => 'Michael', 'middle_name' => 'Isaac', 'last_name' => 'Ngugi']),
                'dob' => '1988-10-07',
                'birth_cert' => 'BC/123465',
                'gender_id' => 1,
                'registration_number' => 'REG-011',
            ],
            [
                'fullname' => json_encode(['first_name' => 'Jasper', 'middle_name' => 'Leo', 'last_name' => 'Karanja']),
                'dob' => '1996-07-19',
                'birth_cert' => 'BC/123466',
                'gender_id' => 1,
                'registration_number' => 'REG-012',
            ],
            [
                'fullname' => json_encode(['first_name' => 'Sarah', 'middle_name' => 'Kendi', 'last_name' => 'Gichuru']),
                'dob' => '1994-01-30',
                'birth_cert' => 'BC/123467',
                'gender_id' => 2,
                'registration_number' => 'REG-013',
            ],
            [
                'fullname' => json_encode(['first_name' => 'Abdi', 'middle_name' => 'Ali', 'last_name' => 'Mohammed']),
                'dob' => '1987-11-15',
                'birth_cert' => 'BC/123468',
                'gender_id' => 1,
                'registration_number' => 'REG-014',
            ],
            [
                'fullname' => json_encode(['first_name' => 'Lucy', 'middle_name' => 'Muthoni', 'last_name' => 'Wambui']),
                'dob' => '1999-06-23',
                'birth_cert' => 'BC/123469',
                'gender_id' => 2,
                'registration_number' => 'REG-015',
            ],
            [
                'fullname' => json_encode(['first_name' => 'George', 'middle_name' => 'James', 'last_name' => 'Onyango']),
                'dob' => '1992-02-01',
                'birth_cert' => 'BC/123470',
                'gender_id' => 1,
                'registration_number' => 'REG-016',
            ],
            [
                'fullname' => json_encode(['first_name' => 'Amina', 'middle_name' => 'Fatuma', 'last_name' => 'Hassan']),
                'dob' => '1994-04-28',
                'birth_cert' => 'BC/123471',
                'gender_id' => 2,
                'registration_number' => 'REG-017',
            ],
            [
                'fullname' => json_encode(['first_name' => 'Victor', 'middle_name' => 'Henry', 'last_name' => 'Mwenda']),
                'dob' => '1989-05-13',
                'birth_cert' => 'BC/123472',
                'gender_id' => 1,
                'registration_number' => 'REG-018',
            ],
            [
                'fullname' => json_encode(['first_name' => 'Ruth', 'middle_name' => 'Judy', 'last_name' => 'Njeri']),
                'dob' => '1996-08-21',
                'birth_cert' => 'BC/123473',
                'gender_id' => 2,
                'registration_number' => 'REG-019',
            ],
            [
                'fullname' => json_encode(['first_name' => 'Wycliffe', 'middle_name' => 'Kimani', 'last_name' => 'Njuguna']),
                'dob' => '1993-04-18',
                'birth_cert' => 'BC/123474',
                'gender_id' => 1,
                'registration_number' => 'REG-020',
            ],
            [
                'fullname' => json_encode(['first_name' => 'Martha', 'middle_name' => 'Njeri', 'last_name' => 'Mutisya']),
                'dob' => '1991-07-09',
                'birth_cert' => 'BC/123475',
                'gender_id' => 2,
                'registration_number' => 'REG-021',
            ]
        ]);
    }
}
