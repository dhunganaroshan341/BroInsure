<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1️⃣ User / Roles
        $this->call(UserTypeSeeder::class);
        $this->call(UserSeeder::class);

        // 2️⃣ Modules / Permissions
        $this->call(ModulesSeeder::class);
        $this->call(ModulesPermissionSeeder::class);
        $this->call(FormPermissionSeeder::class);

        // 3️⃣ Locations
        $this->call(CountrySeeder::class);
        $this->call(StateSeeder::class);
        $this->call(DistrictSeeder::class);
        $this->call(VdcmcptSeeder::class);

        // 4️⃣ Clients & Groups
        $this->call(ClientSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(FiscalYearsSeeder::class);

        // 5️⃣ Insurance Headings
        $this->call(InsuranceHeadingsSeeder::class);
        $this->call(InsuranceSubHeadingsSeeder::class);
        $this->call(GroupHeadingsSeeder::class);

 // 7️⃣ Company / Policies
         $this->call(CompanyPoliciesSeeder::class);
        // $this->call(RetailPolicySeeder::class);

        $this->call(MemberSeeder::class);
        $this->call(MemberDetailsSeeder::class);
        $this->call(MemberRelativesSeeder::class);
        $this->call(MemberPoliciesSeeder::class);

       
       

        // 8️⃣ Claims
        $this->call(ClaimRegisterSeeder::class);
        $this->call(ScrunitinySeeder::class);
        $this->call(InsuranceClaimsSeeder::class);

        // 9️⃣ Notifications / Setup
        $this->call(NotificationsSeeder::class);
        $this->call(SetUpSeeder::class);

        // 🔟 Premium calculations
        $this->call(PremiumCalculationSeeder::class);
    }
}
