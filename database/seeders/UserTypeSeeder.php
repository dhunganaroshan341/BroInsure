<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array=[
            [
                'typename' => 'Super Admin',
                'rolecode' => 'SA'
            ],[
                'typename' => 'Member',
                'rolecode' => 'MB'
            ],[
                'typename' => 'Human Resource',
                'rolecode' => 'HR'
            ]
            ];
        DB::table('usertype')->insert($array);



    }
}
