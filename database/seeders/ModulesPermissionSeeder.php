<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModulesPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing permissions
        DB::table('module_permission')->truncate();

        $modules = DB::table('modules')->pluck('id');
        $userTypes = DB::table('usertype')->pluck('id'); // adjust table name if needed

        $data = [];

        foreach ($modules as $moduleId) {
            foreach ($userTypes as $userTypeId) {
                $data[] = [
                    'modulesid' => $moduleId,
                    'usertypeid' => $userTypeId,
                ];
            }
        }

        DB::table('module_permission')->insert($data);
    }
}
