<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PremiumCalculation;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PremiumCalculationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('premium_calculations')->insert([
            'base_rate'=>20,
            'dependent_factor'=>2,
            'age_factor'=>18,
            'period_factor'=>2
        ]);
    }
}
