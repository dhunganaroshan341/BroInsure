<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SetUpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $headings=[

            ['name'=>'DOMICILARY'],
            ['name'=>'HOSPITALISATION'],
            ['name'=>'MATERNITY'],
            ['name'=>'DENTAL'],
            ['name'=>'OPTICAL'],
        ];
        foreach ($headings as $item) {
            DB::table('insurance_headings')->insert($item);
        }
        $subheadings=[
            ['heading_id'=>'4','name'=>'All kind of Dental Injury'],
            ['heading_id'=>'5','name'=>'General Eye Checkup'],
            ['heading_id'=>'5','name'=>'General EYE checkup and glass lens'],
            ['heading_id'=>'2','name'=>'IPD and Surgeries'],
            ['heading_id'=>'1','name'=>'OPD consultation and all kind of investigations'],
            ['heading_id'=>'1','name'=>'OPD Consultation, investigations, OPD Procedures and Medicines'],
            ['heading_id'=>'1','name'=>'OPD Consultation Only'],

        ];
        foreach ($subheadings as $item) {
            DB::table('insurance_sub_headings')->insert($item);
        }

        
    }
}
