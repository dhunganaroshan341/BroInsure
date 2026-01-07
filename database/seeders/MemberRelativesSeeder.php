<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MemberRelativesSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $memberRelatives = [
            [
                'member_id' => 1,
                'rel_name' => 'गीता शर्मा',
                'rel_dob' => '2000-05-23',
                'rel_gender' => 'female',
                'rel_relation' => 'spouse',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'member_id' => 1,
                'rel_name' => 'अनिश शर्मा',
                'rel_dob' => '2021-11-30',
                'rel_gender' => 'male',
                'rel_relation' => 'child1',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'member_id' => 1,
                'rel_name' => 'प्रिया शर्मा',
                'rel_dob' => '2023-08-05',
                'rel_gender' => 'female',
                'rel_relation' => 'child2',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'member_id' => 2,
                'rel_name' => 'राजेन्द्र श्रेष्ठ',
                'rel_dob' => '1978-09-25',
                'rel_gender' => 'male',
                'rel_relation' => 'father',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'member_id' => 2,
                'rel_name' => 'लक्ष्मी श्रेष्ठ',
                'rel_dob' => '1982-01-19',
                'rel_gender' => 'female',
                'rel_relation' => 'mother',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'member_id' => 3,
                'rel_name' => 'रानी देवी यादव',
                'rel_dob' => '1998-04-11',
                'rel_gender' => 'female',
                'rel_relation' => 'spouse',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'member_id' => 3,
                'rel_name' => 'राहुल यादव',
                'rel_dob' => '2018-06-22',
                'rel_gender' => 'male',
                'rel_relation' => 'child1',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'member_id' => 3,
                'rel_name' => 'प्रियंका यादव',
                'rel_dob' => '2022-11-07',
                'rel_gender' => 'female',
                'rel_relation' => 'child2',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'member_id' => 4,
                'rel_name' => 'दिलबहादुर गुरुङ',
                'rel_dob' => '1975-12-02',
                'rel_gender' => 'male',
                'rel_relation' => 'father',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'member_id' => 4,
                'rel_name' => 'कुमारी गुरुङ',
                'rel_dob' => '1979-08-08',
                'rel_gender' => 'female',
                'rel_relation' => 'mother',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'member_id' => 5,
                'rel_name' => 'सुशिला खड्का',
                'rel_dob' => '1999-01-26',
                'rel_gender' => 'female',
                'rel_relation' => 'spouse',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'member_id' => 5,
                'rel_name' => 'अजय खड्का',
                'rel_dob' => '2020-02-18',
                'rel_gender' => 'male',
                'rel_relation' => 'child1',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'member_id' => 5,
                'rel_name' => 'आरती खड्का',
                'rel_dob' => '2023-05-13',
                'rel_gender' => 'female',
                'rel_relation' => 'child2',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('member_relatives')->insert($memberRelatives);
    }
}
