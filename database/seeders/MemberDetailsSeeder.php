<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MemberDetailsSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $memberDetails = [
            [
                'member_id' => 1,
                'citizenship_no' => '12-345-67890',
                'citizenship_district' => 'काठमाडौं',
                'citizenship_issued_date' => '2010-05-12',
                'idcard_no' => 'ID123456',
                'idcard_issuing_authority' => 'Nepal Gov',
                'idcard_issuedate' => '2010-05-15',
                'idcard_valid_till' => '2030-05-15',
                'income_source' => 'बैंक कर्मचारी',
                'occupation' => 'बैंक कर्मचारी',
                'occupation_other' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'member_id' => 2,
                'citizenship_no' => '23-456-78901',
                'citizenship_district' => 'ललितपुर',
                'citizenship_issued_date' => '2012-03-20',
                'idcard_no' => 'ID234567',
                'idcard_issuing_authority' => 'Nepal Gov',
                'idcard_issuedate' => '2012-03-22',
                'idcard_valid_till' => '2032-03-22',
                'income_source' => 'शिक्षिका',
                'occupation' => 'शिक्षिका',
                'occupation_other' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'member_id' => 3,
                'citizenship_no' => '34-567-89012',
                'citizenship_district' => 'धनुषा',
                'citizenship_issued_date' => '2008-11-10',
                'idcard_no' => 'ID345678',
                'idcard_issuing_authority' => 'Nepal Gov',
                'idcard_issuedate' => '2008-11-15',
                'idcard_valid_till' => '2028-11-15',
                'income_source' => 'व्यापारी',
                'occupation' => 'व्यापारी',
                'occupation_other' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'member_id' => 4,
                'citizenship_no' => '45-678-90123',
                'citizenship_district' => 'कास्की',
                'citizenship_issued_date' => '2015-02-05',
                'idcard_no' => 'ID456789',
                'idcard_issuing_authority' => 'Nepal Gov',
                'idcard_issuedate' => '2015-02-10',
                'idcard_valid_till' => '2035-02-10',
                'income_source' => 'टुरिस्ट गाइड',
                'occupation' => 'टुरिस्ट गाइड',
                'occupation_other' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'member_id' => 5,
                'citizenship_no' => '56-789-01234',
                'citizenship_district' => 'रुपन्देही',
                'citizenship_issued_date' => '2009-09-12',
                'idcard_no' => 'ID567890',
                'idcard_issuing_authority' => 'Nepal Gov',
                'idcard_issuedate' => '2009-09-15',
                'idcard_valid_till' => '2029-09-15',
                'income_source' => 'उद्योगी',
                'occupation' => 'उद्योगी',
                'occupation_other' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('member_details')->insert($memberDetails);
    }
}
