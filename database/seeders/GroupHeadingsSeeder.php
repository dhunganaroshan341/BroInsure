<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupHeadingsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('group_headings')->insert([
            [
                'group_id' => 1,
                'heading_id' => 1,
                'amount' => '5000000',
                'imitation_days' => 365,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group_id' => 2,
                'heading_id' => 2,
                'amount' => '2000000',
                'imitation_days' => 365,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group_id' => 3,
                'heading_id' => 3,
                'amount' => '1500000',
                'imitation_days' => 365,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
