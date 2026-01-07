<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScrunitinySeeder extends Seeder
{
    public function run(): void
    {
        $scrunities = [
            [
                'claim_no_id' => 1,       // must exist in claim_registers
                'member_id' => 1,         // must exist in members
                'member_policy_id' => 1,  // must exist in member_policies
                'relative_id' => null,    // nullable, safe
                'status' => 'Draft',      // simple status
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'claim_no_id' => 2,
                'member_id' => 2,
                'member_policy_id' => 2,
                'relative_id' => 1,
                'status' => 'Request',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'claim_no_id' => 3,
                'member_id' => 3,
                'member_policy_id' => 3,
                'relative_id' => null,
                'status' => 'Verified',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('scrunities')->insert($scrunities);
    }
}
