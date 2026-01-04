<?php

namespace Database\Seeders;
use DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states =[
            [1,'KOSHI','149',0]	,
            [2,'MADHESH','149',0]	,
            [3,'BAGMATI','149',1]	,
            [4,'GANDAKI','149',0]	,
            [5,'LUMBINI','149',0]	,
            [6,'KARNALI','149',0]	,
            [7,'SUDURPASHCHIM','149',0]	,
            [8, 'ANDAMAN AND NICOBAR ISLANDS', 99, 0],
            [9, 'ANDHRA PRADESH', 99, 0],
            [10, 'ARUNACHAL PRADESH', 99, 0],
            [11, 'ASSAM', 99, 0],
            [12, 'BIHAR', 99, 0],
            [13, 'CHANDIGARH', 99, 0],
            [14, 'CHHATTISGARH', 99, 0],
            [15, 'DADRA AND NAGAR HAVELI AND DAMAN AND DIU', 99, 0],
            [16, 'DELHI', 99, 0],
            [17, 'GOA', 99, 0],
            [18, 'GUJARAT', 99, 0],
            [19, 'HARYANA', 99, 0],
            [20, 'HIMACHAL PRADESH', 99, 0],
            [21, 'JAMMU AND KASHMIR', 99, 0],
            [22, 'JHARKHAND', 99, 0],
            [23, 'KARNATAKA', 99, 0],
            [24, 'KERALA', 99, 0],
            [25, 'LADAKH', 99, 0],
            [26, 'LAKSHADWEEP', 99, 0],
            [27, 'MADHYA PRADESH', 99, 0],
            [28, 'MAHARASHTRA', 99, 0],
            [29, 'MANIPUR', 99, 0],
            [30, 'MEGHALAYA', 99, 0],
            [31, 'MIZORAM', 99, 0],
            [32, 'NAGALAND', 99, 0],
            [33, 'ODISHA', 99, 0],
            [34, 'PUDUCHERRY', 99, 0],
            [35, 'PUNJAB', 99, 0],
            [36, 'RAJASTHAN', 99, 0],
            [37, 'SIKKIM', 99, 0],
            [38, 'TAMIL NADU', 99, 0],
            [39, 'TELANGANA', 99, 0],
            [40, 'TRIPURA', 99, 0],
            [41, 'UTTAR PRADESH', 99, 0],
            [42, 'UTTARAKHAND', 99, 0],
            [43, 'WEST BENGAL', 99, 0]
        ];

        foreach ($states as $state) {
            DB::table('states')->insert([
                'id' => $state[0],
                'name' => $state[1],
                'country_id' => $state[2],
                'is_default' => $state[3],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
