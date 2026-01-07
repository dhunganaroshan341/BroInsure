<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FiscalYearsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fiscalYears = [
            [
                'name' => '२०७६/०७७',
                'start_date' => '2019-07-17',
                'end_date' => '2020-07-16',
                'status' => 'N', // Not active
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '२०७७/०७८',
                'start_date' => '2020-07-16',
                'end_date' => '2021-07-15',
                'status' => 'N', // Not active
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '२०७८/०७९',
                'start_date' => '2021-07-16',
                'end_date' => '2022-07-15',
                'status' => 'N', // Not active
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '२०७९/०८०',
                'start_date' => '2022-07-16',
                'end_date' => '2023-07-15',
                'status' => 'N', // Not active
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '२०८०/०८१',
                'start_date' => '2023-07-16',
                'end_date' => '2024-07-15',
                'status' => 'Y', // Active
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '२०८१/०८२',
                'start_date' => '2024-07-16',
                'end_date' => '2025-07-15',
                'status' => 'N', // Not active yet
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '२०८२/०८३',
                'start_date' => '2025-07-16',
                'end_date' => '2026-07-15',
                'status' => 'N', // Not active yet
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('fiscal_years')->insert($fiscalYears);
    }
}
