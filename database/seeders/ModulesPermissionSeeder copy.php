<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ModulesPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('module_permission')->truncate();
        $data = [
            ['modulesid' => 1, 'usertypeid' => 1],
            ['modulesid' => 2, 'usertypeid' => 1],
            ['modulesid' => 3, 'usertypeid' => 1],
            ['modulesid' => 4, 'usertypeid' => 1],
            ['modulesid' => 5, 'usertypeid' => 1],
            ['modulesid' => 6, 'usertypeid' => 1],
            ['modulesid' => 7, 'usertypeid' => 1],
            ['modulesid' => 8, 'usertypeid' => 1],
            ['modulesid' => 9, 'usertypeid' => 1],
            ['modulesid' => 10, 'usertypeid' => 1],
            ['modulesid' => 11, 'usertypeid' => 1],
            ['modulesid' => 12, 'usertypeid' => 1],
            ['modulesid' => 13, 'usertypeid' => 1],
            ['modulesid' => 14, 'usertypeid' => 1],
            ['modulesid' => 15, 'usertypeid' => 1],
            ['modulesid' => 16, 'usertypeid' => 1],
            ['modulesid' => 17, 'usertypeid' => 1],
            ['modulesid' => 18, 'usertypeid' => 1],
            ['modulesid' => 19, 'usertypeid' => 1],
            ['modulesid' => 20, 'usertypeid' => 1],
            ['modulesid' => 21, 'usertypeid' => 1],
            ['modulesid' => 22, 'usertypeid' => 1],
            ['modulesid' => 23, 'usertypeid' => 1],
            ['modulesid' => 24, 'usertypeid' => 1],
            ['modulesid' => 25, 'usertypeid' => 1],
            ['modulesid' => 26, 'usertypeid' => 1],
            ['modulesid' => 27, 'usertypeid' => 1],
            ['modulesid' => 28, 'usertypeid' => 1],
            ['modulesid' => 29, 'usertypeid' => 1],
            ['modulesid' => 30, 'usertypeid' => 1],
            ['modulesid' => 31, 'usertypeid' => 1],
            ['modulesid' => 32, 'usertypeid' => 1],

        ];

        foreach ($data as $item) {
            DB::table('module_permission')->insert($item);
        }
    }
}
