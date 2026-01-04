<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserTypeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ModulesSeeder::class);
        $this->call(ModulesPermissionSeeder::class);
        $this->call(FormPermissionSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(StateSeeder::class);
        $this->call(DistrictSeeder::class);
        $this->call(VdcmcptSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(SetUpSeeder::class);
        $this->call(PremiumCalculationSeeder::class);
        $this->call(CoreInsuranceSeeder::class);
        $this->call(ClaimAndSettleSeeder::class);
    }
}
