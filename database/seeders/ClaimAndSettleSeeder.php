<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\MemberPolicy;
use App\Models\InsuranceClaim;
use App\Models\ClaimRegister;
use App\Models\ClaimNote;
use App\Models\InsuranceClaimLog;
use App\Models\Settlement;
use App\Models\InsuranceHeading;
use App\Models\InsuranceSubHeading;

class ClaimAndSettleSeeder extends Seeder
{
    public function run()
    {
        $members = Member::all();
        $headings = InsuranceHeading::all();

        foreach ($members as $member) {
            $memberPolicies = MemberPolicy::where('member_id', $member->id)->get();

            foreach ($memberPolicies as $policy) {
                // 1️⃣ Create Claim Register
                $claimRegister = ClaimRegister::create([
                    'member_id' => $member->id,
                    'policy_id' => $policy->policy_id,
                    'register_number' => strtoupper('CR' . rand(1000, 9999)),
                ]);

                // 2️⃣ Create 1–2 Insurance Claims per Register
                $claimCount = rand(1, 2);
                for ($i = 0; $i < $claimCount; $i++) {
                    $heading = $headings->random();
                    $subHeading = $heading->sub_headings()->inRandomOrder()->first();

                    $claim = InsuranceClaim::create([
                        'member_id' => $member->id,
                        'register_no' => $claimRegister->id,
                        'heading_id' => $heading->id,
                        'sub_heading_id' => $subHeading->id,
                        'status' => InsuranceClaim::STATUS_RECEIVED,
                        'created_by' => 1, // admin user
                    ]);

                    // 3️⃣ Create Claim Note
                    ClaimNote::create([
                        'claim_no_id' => $claimRegister->id,
                        'member_id' => $member->id,
                        'status' => ClaimNote::STATUS_APPROVED,
                    ]);

                    // 4️⃣ Create Logs
                    $logCount = rand(1, 3);
                    for ($j = 0; $j < $logCount; $j++) {
                        InsuranceClaimLog::create([
                            'insurance_claim_id' => $claim->id,
                            'status' => $claim->status,
                            'note' => "Log entry " . ($j + 1) . " for claim #" . $claim->id
                        ]);
                    }

                    // 5️⃣ Create Settlement for 50% of claims
                    if (rand(0, 1)) {
                        Settlement::create([
                            'member_id' => $member->id,
                            'group_package_heading_id' => null, // optional
                            'claim_id' => $claim->id,
                            'amount' => rand(1000, 20000),
                        ]);
                    }
                }
            }
        }
    }
}
