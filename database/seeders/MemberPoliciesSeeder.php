<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberPoliciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $memberPolicies = [
            [
                'member_id' => 1,
                'policy_id' => 1,
                'group_id' => 1, // assign a valid group
                'individual_policy_no' => 'NP-LIFE-2024-001-M001',
                'issue_date' => '2024-01-20',
                'valid_date' => '2025-01-19',
                'status' => 'active',
                'start_date' => '2024-01-20',
                'end_date' => '2025-01-19',
                'is_current' => 'Y',
                'is_active' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'member_id' => 2,
                'policy_id' => 2,
                'group_id' => 2,
                'individual_policy_no' => 'NP-HEALTH-2024-002-M001',
                'issue_date' => '2024-02-25',
                'valid_date' => '2025-02-24',
                'status' => 'active',
                'start_date' => '2024-02-25',
                'end_date' => '2025-02-24',
                'is_current' => 'Y',
                'is_active' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'member_id' => 3,
                'policy_id' => 3,
                'group_id' => 3,
                'individual_policy_no' => 'NP-VEHICLE-2024-003-M001',
                'issue_date' => '2024-03-15',
                'valid_date' => '2025-03-14',
                'status' => 'active',
                'start_date' => '2024-03-15',
                'end_date' => '2025-03-14',
                'is_current' => 'Y',
                'is_active' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('member_policies')->insert($memberPolicies);
    }
}
    