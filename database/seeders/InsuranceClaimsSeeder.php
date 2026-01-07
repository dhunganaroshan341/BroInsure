<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsuranceClaimsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $claims = [
            [
                'member_id' => 1,
                'heading_id' => 1,
                'group_id' => 1,
                'sub_heading_id' => 1, // must be NOT NULL
                'relative_id' => 1,    // must be NOT NULL if column requires
                'claim_for' => 'self',
                'document_type' => 'bill',
                'bill_file_name' => 'bill_rajesh.pdf',
                'bill_file_size' => 2048,
                'file_path' => 'uploads/insurance/bill_rajesh.pdf',
                'document_date' => '2024-06-10',
                'remark' => 'Annual checkup',
                'bill_amount' => 5000,
                'clinical_facility_name' => 'City Hospital, Kathmandu',
                'diagnosis_treatment' => 'General health check',
                'claim_type' => 'claim',
                'register_no' => 1,
                'scrutiny_id' => 1,     // must be NOT NULL if column requires
                'status' => 'approved',
                'claim_id' => 1001,
                'created_at' => now(),
            ],
            [
                'member_id' => 2,
                'heading_id' => 1,
                'group_id' => 2,
                'sub_heading_id' => 2,
                'relative_id' => 2,
                'claim_for' => 'other',
                'document_type' => 'prescription',
                'bill_file_name' => 'bill_sanima.pdf',
                'bill_file_size' => 3072,
                'file_path' => 'uploads/insurance/bill_sanima.pdf',
                'document_date' => '2024-07-18',
                'remark' => 'Minor accident repair',
                'bill_amount' => 12000,
                'clinical_facility_name' => 'Lalitpur Auto Service',
                'diagnosis_treatment' => 'Vehicle repair',
                'claim_type' => 'claim',
                'register_no' => 2,
                'scrutiny_id' => 2,
                'status' => 'approved',
                'claim_id' => 1002,
                'created_at' => now(),
            ],
            [
                'member_id' => 3,
                'heading_id' => 2,
                'group_id' => 3,
                'sub_heading_id' => 3,
                'relative_id' => 3,
                'claim_for' => 'self',
                'document_type' => 'report',
                'bill_file_name' => 'bill_ramesh.pdf',
                'bill_file_size' => 1024,
                'file_path' => 'uploads/insurance/bill_ramesh.pdf',
                'document_date' => '2024-08-08',
                'remark' => 'Claim after incident',
                'bill_amount' => 250000,
                'clinical_facility_name' => 'Janakpur Hospital',
                'diagnosis_treatment' => 'N/A',
                'claim_type' => 'claim',
                'register_no' => 3,
                'scrutiny_id' => 3,
                'status' => 'pending',
                'claim_id' => 1003,
                'created_at' => now(),
            ],
        ];

        DB::table('insurance_claims')->insert($claims);
    }
}
