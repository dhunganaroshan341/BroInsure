<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('modules')->truncate();
        $data = [
            ['Dashboard', 'dashboard', 'fas fa-tachometer-alt', 1, 0],
            ['Preview', 'dashboard', 'fas fa-list', 1, 1],
            ['User Types', 'usertype', 'fa fa-user-secret', 2, 0],
            ['Users', 'user', 'fa fa-user-friends', 3, 0],
            ['Access Management', '#', 'fas fa-users-cog', 4, 0],
            ['Menu', 'menu', 'fas fa-list', 1, 5],
            ['Permission', 'permission', 'fas fa-cogs', 2, 5],
            ['Form Permission', 'permission/form', 'fas fa-cogs', 3, 5],
            ['Client', 'clients', 'fas fa-user-tie', 5, 0],
            ['Set up', '#', 'fas fa-cogs', 6, 0],
            ['Heading', 'headings', 'fas fa-list', 1, 10],
            ['Sub Heading', 'sub-headings', 'fas fa-list', 2, 10],
            // ['Packages', 'packages', 'fas fa-file-archive', 7, 0],
            ['Insurance Group', 'groups', 'fa fa-user-friends', 8, 0],
            ['Members', 'members', 'fas fa-user-tie', 9, 0],
            //Claim Submission
            ['Claim Submission', '#', 'fas fa-file-archive', 10, 0],
            ['Claim Intimation', 'claimsubmissions', 'fas fa-file-archive', 1, 15],
            // ['Claim Received', 'claimreceived', 'fas fa-file-archive', 2, 16],
            ['Claim List', 'claimlist', 'fas fa-list', 3, 15],
            //Claim Processing
            ['Claim Processing', '#', 'fas fa-file-archive', 10, 0],
            ['Claim Registration', 'claimregistration', 'fas fa-file-archive', 1, 18],
            ['Claim Screening', 'claimscreening', 'fas fa-file-archive', 2, 18],
            // ['Claim Scrutiny', 'claimscrutiny', 'fas fa-file-archive', 2, 18],
            ['Claim Verification', 'claimverification', 'fas fa-file-archive', 3, 18],
            ['Claim Approval', 'claimapproval', 'fas fa-file-archive', 4, 18],
            ['Fiscal Year', 'fiscal-years', 'fas fa-calendar', 13, 0],
            ['Individual', 'members', 'fas fa-list', 1, 14],
            ['Employee', 'member-groups', 'fas fa-list', 2, 14],
            ['MIS', 'reports', 'fas fa-chart-bar', 14, 0],
            ['Retail', 'retail-groups', 'fas fa-chart-bar', 1, 13],
            ['Company', 'groups', 'fas fa-chart-bar', 2, 13],
            ['Retail Policy', 'retail-policy', 'fas fa-wallet', 9, 0],
            ['Premium', 'premium', 'fas fa-wallet', 15, 0],
        ];

        foreach ($data as $item) {
            if (is_null(DB::table('modules')->where('modulename', $item[0])->select('id')->first())) {
            DB::table('modules')->insert([
                'modulename' => $item[0],
                'url' => $item[1],
                'icon' => $item[2],
                'orderby' => $item[3],
                'parentmoduleid' => $item[4],
            ]);
            }
        }
    }
}
