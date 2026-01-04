<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class FormPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (is_null(DB::table('form_permission')->where('slug', 'user-group')->select('id')->first())) {
            # code...
            DB::table('form_permission')->insert(
                [
                    'formname' => 'User Type',
                    'slug' => 'user-group',
                    'isinsert' => 'Y',
                    'isupdate' => 'Y',
                    'isedit' => 'Y',
                    'isdelete' => 'Y',
                    'usertypeid' => '1'
                ]
            );
        }
        if (is_null(DB::table('form_permission')->where('slug', 'users')->select('id')->first())) {
            DB::table('form_permission')->insert(
                [
                    'formname' => 'Users',
                    'slug' => 'users',
                    'isinsert' => 'Y',
                    'isupdate' => 'Y',
                    'isedit' => 'Y',
                    'isdelete' => 'Y',
                    'usertypeid' => '1'
                ]
            );
        }
        if (is_null(DB::table('form_permission')->where('slug', 'menu')->select('id')->first())) {
            DB::table('form_permission')->insert(
                [
                    'formname' => 'Menu',
                    'slug' => 'menu',
                    'isinsert' => 'Y',
                    'isupdate' => 'Y',
                    'isedit' => 'Y',
                    'isdelete' => 'Y',
                    'usertypeid' => '1'
                ]
            );
        }
        if (is_null(DB::table('form_permission')->where('slug', 'group')->select('id')->first())) {
            DB::table('form_permission')->insert(
                [
                    'formname' => 'Insurance Group',
                    'slug' => 'group',
                    'isinsert' => 'Y',
                    'isupdate' => 'Y',
                    'isedit' => 'Y',
                    'isdelete' => 'Y',
                    'usertypeid' => '1'
                ]
            );
        }
        if (is_null(DB::table('form_permission')->where('slug', 'clients')->select('id')->first())) {
            DB::table('form_permission')->insert(
                [
                    'formname' => 'Client',
                    'slug' => 'clients',
                    'isinsert' => 'Y',
                    'isupdate' => 'Y',
                    'isedit' => 'Y',
                    'isdelete' => 'Y',
                    'usertypeid' => '1'
                ]
            );
        }
        if (is_null(DB::table('form_permission')->where('slug', 'members')->select('id')->first())) {
            DB::table('form_permission')->insert(
                [
                    'formname' => 'Member',
                    'slug' => 'members',
                    'isinsert' => 'Y',
                    'isupdate' => 'Y',
                    'isedit' => 'Y',
                    'isdelete' => 'Y',
                    'usertypeid' => '1'
                ]
            );
        }
        if (is_null(DB::table('form_permission')->where('slug', 'insurance_heading')->select('id')->first())) {
            DB::table('form_permission')->insert(
                [
                    'formname' => 'Insurance Heading',
                    'slug' => 'insurance_heading',
                    'isinsert' => 'Y',
                    'isupdate' => 'Y',
                    'isedit' => 'Y',
                    'isdelete' => 'Y',
                    'usertypeid' => '1'
                ]
            );
        }
        if (is_null(DB::table('form_permission')->where('slug', 'insurance_sub_heading')->select('id')->first())) {
            DB::table('form_permission')->insert(
                [
                    'formname' => 'Insurance Sub Heading',
                    'slug' => 'insurance_sub_heading',
                    'isinsert' => 'Y',
                    'isupdate' => 'Y',
                    'isedit' => 'Y',
                    'isdelete' => 'Y',
                    'usertypeid' => '1'
                ]
            );
        }
        // if (is_null(DB::table('form_permission')->where('slug', 'packages')->select('id')->first())) {
        //     DB::table('form_permission')->insert(
        //         [
        //             'formname' => 'Package',
        //             'slug' => 'packages',
        //             'isinsert' => 'Y',
        //             'isupdate' => 'Y',
        //             'isedit' => 'Y',
        //             'isdelete' => 'Y',
        //             'usertypeid' => '1'
        //         ]
        //     );
        // }
        if (is_null(DB::table('form_permission')->where('slug', 'claimsubmissions')->select('id')->first())) {
            DB::table('form_permission')->insert(
                [
                    'formname' => 'Claim Submission',
                    'slug' => 'claimsubmissions',
                    'isinsert' => 'Y',
                    'isupdate' => 'Y',
                    'isedit' => 'Y',
                    'isdelete' => 'Y',
                    'usertypeid' => '1'
                ]
            );
        }
        // if (is_null(DB::table('form_permission')->where('slug', 'group_package')->select('id')->first())) {
        //     DB::table('form_permission')->insert(
        //         [
        //             'formname' => 'Assign Package To Group',
        //             'slug' => 'group_package',
        //             'isinsert' => 'Y',
        //             'isupdate' => 'Y',
        //             'isedit' => 'Y',
        //             'isdelete' => 'Y',
        //             'usertypeid' => '1'
        //         ]
        //     );
        // }
        if (is_null(DB::table('form_permission')->where('slug', 'claimreceived')->select('id')->first())) {
            DB::table('form_permission')->insert(
                [
                    'formname' => 'Claim Received',
                    'slug' => 'claimreceived',
                    'isinsert' => 'Y',
                    'isupdate' => 'Y',
                    'isedit' => 'Y',
                    'isdelete' => 'Y',
                    'usertypeid' => '1'
                ]
            );
        }
        if (is_null(DB::table('form_permission')->where('slug', 'client_policy')->select('id')->first())) {
            DB::table('form_permission')->insert(
                [
                    'formname' => 'Claim Policy',
                    'slug' => 'client_policy',
                    'isinsert' => 'Y',
                    'isupdate' => 'Y',
                    'isedit' => 'Y',
                    'isdelete' => 'Y',
                    'usertypeid' => '1'
                ]
            );
        }
        if (is_null(DB::table('form_permission')->where('slug', 'claimregistration')->select('id')->first())) {
            DB::table('form_permission')->insert(
                [
                    'formname' => 'Claim Registration',
                    'slug' => 'claimregistration',
                    'isinsert' => 'Y',
                    'isupdate' => 'Y',
                    'isedit' => 'Y',
                    'isdelete' => 'Y',
                    'usertypeid' => '1'
                ]
            );
        }
        if (is_null(DB::table('form_permission')->where('slug', 'claimscreening')->select('id')->first())) {
            DB::table('form_permission')->insert(
                [
                    'formname' => 'Claim Screening',
                    'slug' => 'claimscreening',
                    'isinsert' => 'Y',
                    'isupdate' => 'Y',
                    'isedit' => 'Y',
                    'isdelete' => 'Y',
                    'usertypeid' => '1'
                ]
            );
        }
        if (is_null(DB::table('form_permission')->where('slug', 'claimscrutiny')->select('id')->first())) {
            DB::table('form_permission')->insert(
                [
                    'formname' => 'Claim Scrutiny',
                    'slug' => 'claimscrutiny',
                    'isinsert' => 'Y',
                    'isupdate' => 'Y',
                    'isedit' => 'Y',
                    'isdelete' => 'Y',
                    'usertypeid' => '1'
                ]
            );
        }
        if (is_null(DB::table('form_permission')->where('slug', 'claimverification')->select('id')->first())) {
            DB::table('form_permission')->insert(
                [
                    'formname' => 'Claim Verification',
                    'slug' => 'claimverification',
                    'isinsert' => 'Y',
                    'isupdate' => 'Y',
                    'isedit' => 'Y',
                    'isdelete' => 'Y',
                    'usertypeid' => '1'
                ]
            );
        }
        if (is_null(DB::table('form_permission')->where('slug', 'claimapproval')->select('id')->first())) {
            DB::table('form_permission')->insert(
                [
                    'formname' => 'Claim Approval',
                    'slug' => 'claimapproval',
                    'isinsert' => 'Y',
                    'isupdate' => 'Y',
                    'isedit' => 'Y',
                    'isdelete' => 'Y',
                    'usertypeid' => '1'
                ]
            );
        }
        if (is_null(DB::table('form_permission')->where('slug', 'fiscal_year')->select('id')->first())) {
            DB::table('form_permission')->insert(
                [
                    'formname' => 'Fiscal Year',
                    'slug' => 'fiscal_year',
                    'isinsert' => 'Y',
                    'isupdate' => 'Y',
                    'isedit' => 'Y',
                    'isdelete' => 'Y',
                    'usertypeid' => '1'
                ]
            );
        }
        if (is_null(DB::table('form_permission')->where('slug', 'retail-policy')->select('id')->first())) {
            DB::table('form_permission')->insert(
                [
                    'formname' => 'Retail Policy',
                    'slug' => 'retail-policy',
                    'isinsert' => 'Y',
                    'isupdate' => 'Y',
                    'isedit' => 'Y',
                    'isdelete' => 'Y',
                    'usertypeid' => '1'
                ]
            );
        }

        if (is_null(DB::table('form_permission')->where('slug', 'premium')->select('id')->first())) {
            DB::table('form_permission')->insert(
                [
                    'formname' => 'Premium',
                    'slug' => 'premium',
                    'isinsert' => 'Y',
                    'isupdate' => 'Y',
                    'isedit' => 'Y',
                    'isdelete' => 'Y',
                    'usertypeid' => '1'
                ]
            );
        }
    }
}
