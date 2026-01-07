<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class InsuranceDecisionTreeService
{
    public function evaluate(array $data): array
    {
        /**
         * STEP 1: Claim Eligibility
         */
        if ($data['policy_status'] !== 'Active') {
            return [
                'approved' => false,
                'reason' => 'Policy is not active'
            ];
        }

        if ($data['claim_amount'] > $data['policy_limit']) {
            return [
                'approved' => false,
                'reason' => 'Claim amount exceeds policy limit'
            ];
        }

        /**
         * STEP 2: Premium Calculation
         */
        $premium = $data['base_premium'];

        if ($data['client_age'] > 50) {
            $premium += $premium * 0.20;
        }

        if ($data['policy_type'] === 'Health') {
            $premium += $premium * 0.10;
        }

        /**
         * STEP 3: Claim State Decision
         */
        $state = 'Pending';

        if ($data['action'] === 'Approve') {
            $state = 'Approved';
        } elseif ($data['action'] === 'Reject') {
            $state = 'Rejected';
        } elseif ($data['action'] === 'Settle' && $state === 'Approved') {
            $state = 'Settled';
        }

        Log::info('Insurance decision tree evaluated', [
            'premium' => $premium,
            'state' => $state
        ]);

        return [
            'approved' => true,
            'premium' => round($premium, 2),
            'claim_state' => $state
        ];
    }
}
