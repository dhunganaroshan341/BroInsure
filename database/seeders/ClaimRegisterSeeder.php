<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClaimRegisterSeeder extends Seeder
{
    public function run(): void
    {
        $registers = [
            ['claim_no' => 'CLM001', 'file_no' => 'F001', 'created_at' => now(), 'updated_at' => now()],
            ['claim_no' => 'CLM002', 'file_no' => 'F002', 'created_at' => now(), 'updated_at' => now()],
            ['claim_no' => 'CLM003', 'file_no' => 'F003', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('claim_registers')->insert($registers);
    }
}
