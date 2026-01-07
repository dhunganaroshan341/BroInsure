<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsuranceHeadingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $headings = [
            [
                'name' => 'जीवन बीमा',
                'code' => 'LIFE',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'स्वास्थ्य बीमा',
                'code' => 'HEALTH',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'वाहन बीमा',
                'code' => 'VEHICLE',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'घर बीमा',
                'code' => 'HOME',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'यात्रा बीमा',
                'code' => 'TRAVEL',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'दुर्घटना बीमा',
                'code' => 'ACCIDENT',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'सम्पत्ति बीमा',
                'code' => 'PROPERTY',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'शिक्षा बीमा',
                'code' => 'EDUCATION',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'कृषि बीमा',
                'code' => 'AGRICULTURE',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'व्यापार बीमा',
                'code' => 'BUSINESS',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('insurance_headings')->insert($headings);
    }
}
