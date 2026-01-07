<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RetailPolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('member_policies')->insert([
            'policy_no' => 'POL-' . Str::upper(Str::random(8)),

            'actual_issue_date' => Carbon::now()->subDays(10),
            'issue_date' => Carbon::now(),
            'valid_date_type' => 'days',

            'colling_period' => 15,
            'valid_date' => Carbon::now()->addYear(),

            'imitation_days' => 365,

            'nepal_ri' => 10,
            'himalayan_ri' => 5,
            'retention' => 20,
            'quota' => 15,

            'surplus_i' => 10,
            'surplus_ii' => 5,

            'auto_fac' => 5,
            'facultative' => 10,
            'co_insurance' => 20,

            'xol_i' => 5,
            'xol_ii' => 5,
            'xol_iii' => 5,
            'xol_iiii' => 5,

            'pool' => 10,

            'excess_value' => 2,
            'excess_type' => 'percentage',

            'premium_amount' => 15000.50,
            'insured_amount' => 1000000.00,

            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
