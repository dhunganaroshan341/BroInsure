<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('groups')->insert([
            [
                'client_id' => 1,
                'name' => 'Corporate Employees Group',
                'code' => 'CORP-EMP',
                'status' => 'Y',
                'insurance_amount' => '5000000',
                'is_amount_different' => 'N',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'client_id' => 1,
                'name' => 'Management Staff Group',
                'code' => 'MGMT',
                'status' => 'Y',
                'insurance_amount' => '3000000',
                'is_amount_different' => 'N',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'client_id' => 2,
                'name' => 'Field Employees Group',
                'code' => 'FIELD',
                'status' => 'Y',
                'insurance_amount' => '2000000',
                'is_amount_different' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
