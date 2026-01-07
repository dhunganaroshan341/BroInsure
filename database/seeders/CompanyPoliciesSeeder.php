<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyPoliciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $policies = [
            [
                'client_id' => 1,
                'policy_no' => 'NP-LIFE-2024-001',
                'issue_date' => '2024-01-15',
                'valid_date' => '2025-01-14',
                'imitation_days' => 365,
                'member_no' => 50,
                'issued_at' => 'काठमाडौं शाखा',
                'f_o_agent' => 'रमेश शर्मा',
                'receipt_no' => 'RCP-2024-001',
                'vat_bill_no' => 'VAT-2024-001',
                'sum_insured' => 5000000,
                'premium' => 25000,
                'issued_by' => 'कृष्ण प्रसाद',
                'approved_by' => 'राजेन्द्र शाह',

                // ✅ Use the JSON 'excess' column instead
                'excess' => json_encode([
                    'type' => 'fix',
                    'amount' => 10000,
                ]),

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'client_id' => 2,
                'policy_no' => 'NP-HEALTH-2024-002',
                'issue_date' => '2024-02-20',
                'valid_date' => '2025-02-19',
                'imitation_days' => 365,
                'member_no' => 25,
                'issued_at' => 'ललितपुर शाखा',
                'f_o_agent' => 'सनिमा श्रेष्ठ',
                'receipt_no' => 'RCP-2024-002',
                'vat_bill_no' => 'VAT-2024-002',
                'sum_insured' => 2000000,
                'premium' => 15000,
                'issued_by' => 'अनिता मगर',
                'approved_by' => 'दिपक खड्का',
                'excess' => json_encode([
                    'type' => 'fix',
                    'amount' => 5000,
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'client_id' => 3,
                'policy_no' => 'NP-VEHICLE-2024-003',
                'issue_date' => '2024-03-10',
                'valid_date' => '2025-03-09',
                'imitation_days' => 365,
                'member_no' => 30,
                'issued_at' => 'पोखरा शाखा',
                'f_o_agent' => 'सारा गुरुङ',
                'receipt_no' => 'RCP-2024-003',
                'vat_bill_no' => 'VAT-2024-003',
                'sum_insured' => 1500000,
                'premium' => 12000,
                'issued_by' => 'मनोज थापा',
                'approved_by' => 'सुशिल कार्की',
                'excess' => json_encode([
                    'type' => 'percentage',
                    'amount' => 10,
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('company_policies')->insert($policies);
    }
}
