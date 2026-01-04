<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InsuranceHeading;
use App\Models\InsuranceSubHeading;
use App\Models\PackageHeading;
use App\Models\Package;
use App\Models\Client;
use App\Models\CompanyPolicy;
use App\Models\Member;
use App\Models\MemberPolicy;

class CoreInsuranceSeeder extends Seeder
{
    public function run()
    {
        // 1️⃣ Insurance Headings
        $headings = [
            'LIFE INSURANCE',
            'HEALTH INSURANCE',
            'VEHICLE INSURANCE',
            'TRAVEL INSURANCE',
            'PROPERTY INSURANCE',
            'ACCIDENT INSURANCE'
        ];

        $headingRecords = [];
        foreach ($headings as $heading) {
            $headingRecords[$heading] = InsuranceHeading::create(['name' => $heading]);
        }

        // 2️⃣ Insurance Sub-Headings
        $subHeadings = [
            'LIFE INSURANCE' => ['Term Life', 'Whole Life', 'Endowment Plan'],
            'HEALTH INSURANCE' => ['Individual Health', 'Family Health', 'Critical Illness'],
            'VEHICLE INSURANCE' => ['Third Party Liability', 'Comprehensive'],
            'TRAVEL INSURANCE' => ['Domestic Travel', 'International Travel'],
            'PROPERTY INSURANCE' => ['Home Insurance', 'Business Insurance'],
            'ACCIDENT INSURANCE' => ['Personal Accident', 'Group Accident']
        ];

        foreach ($subHeadings as $headingName => $subs) {
            $heading = $headingRecords[$headingName];
            foreach ($subs as $sub) {
                InsuranceSubHeading::create([
                    'heading_id' => $heading->id,
                    'name' => $sub
                ]);
            }
        }

        // 3️⃣ Package Headings
        $packageHeadings = ['Standard Plans', 'Premium Plans', 'Corporate Plans', 'Family Plans'];
        foreach ($packageHeadings as $pkgHeading) {
            PackageHeading::create(['name' => $pkgHeading]);
        }

        // 4️⃣ Packages
        $packages = [
            'Basic Life Plan' => 'LIFE INSURANCE',
            'Comprehensive Health Plan' => 'HEALTH INSURANCE',
            'Car Insurance Standard' => 'VEHICLE INSURANCE',
            'Nepal Travel Secure' => 'TRAVEL INSURANCE'
        ];

        $packageRecords = [];
        foreach ($packages as $pkgName => $headingName) {
            $heading = $headingRecords[$headingName];
            $pkg = Package::create(['name' => $pkgName]);
            $pkg->headings()->attach($heading->id);
            $packageRecords[] = $pkg;
        }

        // 5️⃣ Company Policies
        $clients = Client::all();
        $companyPolicies = [];
        foreach ($clients as $client) {
            foreach ($packageRecords as $package) {
                $companyPolicies[] = CompanyPolicy::create([
                    'client_id' => $client->id,
                    'package_id' => $package->id,
                    'policy_number' => strtoupper('POL' . rand(1000, 9999)),
                    'imitation_days' => rand(15, 60)
                ]);
            }
        }

        // 6️⃣ Member Policies
        $members = Member::all();
        foreach ($members as $member) {
            $policy = $companyPolicies[array_rand($companyPolicies)];
            MemberPolicy::create([
                'member_id' => $member->id,
                'policy_id' => $policy->id,
                'group_id' => null, // optional
            ]);
        }
    }
}
