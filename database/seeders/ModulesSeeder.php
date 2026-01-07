<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Dashboard
            ['Insurance Dashboard', 'dashboard', 'fas fa-tachometer-alt', 1, 0],

            // Client
            ['Clients', 'clients', 'fas fa-user-tie', 2, 0],

            // Insurance Policy
            ['Insurance Policies', 'groups', 'fa fa-user-friends', 3, 0],
            // ['Retail Policy', 'retail-policy', 'fas fa-wallet', 1, 3],
            ['Manage Policy', 'groups', 'fas fa-chart-bar', 2, 3],

            // Members / Identity
            ['Members', 'members', 'fas fa-user-tie', 4, 0],
            ['Manage Members', 'member-groups', 'fas fa-list', 1, 6],
            // ['Individual', 'members', 'fas fa-list', 2, 6],

            // Claims
            // ['Insurance Claims', '', 'fas fa-file-archive', 5, 0],
            ['Claim Intimation', 'claimsubmissions', 'fas fa-file-archive', 1, 9],
            ['Claim List', 'claimlist', 'fas fa-list', 2, 9],
            ['Claim Registration', 'claimregistration', 'fas fa-file-archive', 3, 9],
            ['Claim Screening', 'claimscreening', 'fas fa-file-archive', 4, 9],
            ['Claim Verification', 'claimverification', 'fas fa-file-archive', 5, 9],
            ['Claim Approval', 'claimapproval', 'fas fa-file-archive', 6, 9],

            // Premium
            ['Premium', 'premium', 'fas fa-wallet', 6, 0],

            // Users
            ['Users', 'user', 'fa fa-user-friends', 7, 0],

            // System
            ['Fiscal Year', 'fiscal-years', 'fas fa-calendar', 8, 0],
        ];

        foreach ($data as $item) {
            $exists = DB::table('modules')
                ->where('modulename', $item[0])
                ->first();

            if (!$exists) {
                DB::table('modules')->insert([
                    'modulename'      => $item[0],
                    'url'             => $item[1],
                    'icon'            => $item[2],
                    'orderby'         => $item[3],
                    'parentmoduleid'  => $item[4],
                ]);
            }
        }
    }
}
