<?php

namespace App\Listeners;

use App\Models\Audit;
use App\Models\InsuranceClaim;
use App\Models\InsuranceClaimLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class InsuranceClaimUpdatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle($event)
    {
        // Fetch the latest audit associated with this specific claim
        $audit = $event->auditsData()->latest()->first();
        if ($audit) {
            $remarks = (request()->input('remarks') && !is_array(request()->input('remarks'))) ? request()->input('remarks') : $audit->event;
            $type = $event->status ?? $audit->event;
            $new_status = $event->status;
            $decodedValues = json_decode($audit->old_values, true);
            // Access the 'status' value
            if (isset($decodedValues) && $decodedValues != []) {
                if (isset($decodedValues['status'])) {
                    $previous_status = $decodedValues['status'];
                } else if (isset($decodedValues['is_hold'])) {
                    if ($decodedValues['is_hold'] == 'Y') {
                        $previous_status = InsuranceClaim::STATUS_HOLD;
                        $new_status = InsuranceClaim::STATUS_RELEASE;
                    } else {
                        $previous_status = InsuranceClaim::STATUS_RELEASE;
                        $new_status = InsuranceClaim::STATUS_HOLD;
                    }
                } else {
                    $previous_status = null;
                }
            } else {
                $previous_status = null;
            }
            $claimId = $event->id;
            InsuranceClaimLog::create([
                'insurance_claim_id' => $claimId,
                'audit_id' => $audit->id,
                'type' => $type,
                'remarks' => $remarks,
                'previous_status' => $previous_status,
                'new_status' => $new_status,
            ]);
        }
    }
}
