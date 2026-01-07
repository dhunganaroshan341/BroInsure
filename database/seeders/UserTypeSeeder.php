<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userTypes = [
            ['typename' => 'Super Admin', 'rolecode' => 'SA'],
            ['typename' => 'Admin', 'rolecode' => 'AD'],
            ['typename' => 'Manager', 'rolecode' => 'MG'],
            ['typename' => 'Human Resource', 'rolecode' => 'HR'],
            ['typename' => 'Finance', 'rolecode' => 'FN'],
            ['typename' => 'Claims Officer', 'rolecode' => 'CO'],
            ['typename' => 'Underwriter', 'rolecode' => 'UW'],
            ['typename' => 'Policy Officer', 'rolecode' => 'PO'],
            ['typename' => 'Member', 'rolecode' => 'MB'],
            ['typename' => 'Auditor', 'rolecode' => 'AU'],
        ];

        // Insert dynamically
        foreach ($userTypes as $type) {
            $exists = DB::table('usertype')
                ->where('rolecode', $type['rolecode'])
                ->first();

            if (!$exists) {
                DB::table('usertype')->insert([
                    'typename' => $type['typename'],
                    'rolecode' => $type['rolecode'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
