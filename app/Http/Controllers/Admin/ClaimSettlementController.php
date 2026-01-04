<?php

namespace App\Http\Controllers\Admin;

use App\Models\InsuranceHeading;
use App\Models\Scrunity;
use Carbon\Carbon;
use App\Models\ClaimNote;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\BaseController;
use App\Models\InsuranceClaim;
use App\Models\User;
use App\Services\ClaimSettlementService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\View;

class ClaimSettlementController extends BaseController
{
    public function index(Request $request, ClaimSettlementService $service)
    {
        $access = checkAccessPrivileges('clients');
        if ($request->ajax()) {
            // lot_id, claim_no, client_id, from_date, to_date
            return $service->getIndexDataTable($request);
        }
        $headings = InsuranceHeading::where('status', 'Y')->orderBy('name', 'asc')->get(['id', 'name']);
        return view("backend.claimapproval.list", [
            "title" => "Claim Approval",
            "access" => $access,
            "headings" => $headings,
            "extraCss" => commonDatatableFiles('css'),
            "extraJs" => commonDatatableFiles(),
        ]);
    }

    public function getScrunityTable(int $claim_note_id, ClaimSettlementService $service)
    {
        /** @var ClaimNote */
        $claim_note = ClaimNote::with([
            'claimRegister.scrunities.details',
            'member.user',
            'claimRegister.scrunities.relative',
            'client.policies'
        ])
            ->find($claim_note_id);
        // dd($claim_note);
        if (is_null($claim_note)) {

            return $this->sendError(getMessageText(''));
        }
        $companiesPolicies = $claim_note?->client?->policies[0] ?? [];
        $selectedPolicies = [
            "Nepal Ri" => $companiesPolicies->nepal_ri ?? "0",
            "Himalayan Ri" => $companiesPolicies->himalayan_ri ?? "0",
            "Retention" => $companiesPolicies->retention ?? "10",
            "Quota" => $companiesPolicies->quota ?? "0",
            "I Surplus" => $companiesPolicies->surplus_i ?? "5",
            "II Surplus" => $companiesPolicies->surplus_ii ?? "0",
            "Auto Fac" => $companiesPolicies->auto_fac ?? "0",
            "Facultative" => $companiesPolicies->facultative ?? "0",
            "Co-Insurance" => $companiesPolicies->co_insurance ?? "0",
            "XOL I" => $companiesPolicies->xol_i ?? "0",
            "XOL II" => $companiesPolicies->xol_ii ?? "0",
            "XOL III" => $companiesPolicies->xol_iii ?? "0",
            "XOL IIII" => $companiesPolicies->xol_iiii ?? "0",
            "Pool" => $companiesPolicies->pool ?? "0",
            // "Excess" => json_encode($companiesPolicies->excess ?? ["excess_type" => "percentage", "excess_value" => "10"]),
        ];
        $excess = json_decode($companiesPolicies->excess);
        $totalApprovedAmount = $claim_note->claimRegister->scrunities->sum(function ($scrunity) {
            return $scrunity->details->sum('approved_amount');
        });
        if ($excess->excess_type == 'percentage') {
            $accessAmount = round((($totalApprovedAmount * $excess->excess_value) / 100), 2);
        } else {
            $accessAmount = $excess->excess_value;
        }

        $accessAmount = $accessAmount > 0 ? $accessAmount : 0;
        // dd($totalApprovedAmount, $accessAmount);
        $totalAccessAmount = $totalApprovedAmount - $accessAmount;
        $dataTable = $service->getScrunityTable($claim_note->claimRegister->scrunities, $accessAmount);
        $dataTable->with(['details' => $service->getScrunityDetails($claim_note), 'selectedPolicies' => $selectedPolicies, 'totalAccessAmount' => $totalAccessAmount]);
        return $dataTable->make(true);
    }
    public function updatestatus($id)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('claimapproval'), 'isupdate');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        try {
            DB::beginTransaction();
            $claimapproval = ClaimNote::with('claimRegister.scrunities', 'insuranceCliams')->find($id);
            if ($claimapproval) {
                $claimapproval->update([
                    'status' => ClaimNote::STATUS_APPROVED
                ]);
                foreach ($claimapproval?->insuranceCliams as $claim) {
                    $claim->update([
                        'status' => InsuranceClaim::STATUS_APPROVED
                    ]);
                }
                foreach ($claimapproval?->claimRegister?->scrunities as $scrunity) {
                    $scrunity->update([
                        'status' => Scrunity::STATUS_APPROVED
                    ]);
                }
                $current_user = getUserDetail();
                $firstClaim = $claimapproval?->insuranceCliams[0];
                $claimIdName = $firstClaim->claim_id;
                $claimUserClientId = $firstClaim?->member?->client_id;
                $claimUserMemberId = $firstClaim->member_id;
                $userIds = User::where(function ($q) use ($claimUserClientId, $claimUserMemberId) {
                    // Users who do not have a member
                    $q->whereDoesntHave('member')
                        // Or users who have a member that meets the conditions
                        ->orWhereHas('member', function ($q) use ($claimUserClientId, $claimUserMemberId) {
                            $q->where('client_id', $claimUserClientId)
                                ->where(function ($q2) use ($claimUserMemberId) {
                                    // Either the type is not 'member'
                                    $q2->where('type', '!=', 'member')
                                        // Or it's a 'member' and has the specific member ID
                                        ->orWhere(function ($q3) use ($claimUserMemberId) {
                                        $q3->where('type', 'member')
                                            ->where('id', $claimUserMemberId);
                                    });
                                });
                        });
                })
                    ->pluck('id')
                    ->toArray();

                $uniqueArray = array_unique(array_values(array_diff($userIds, [$current_user->id])));
                $redirect_url = str_replace(url('/'), '', route('claim.list')) . '?claim_id=' . $claimIdName;
                $message = 'The claim has been ' . InsuranceClaim::STATUS_APPROVED . ' for Claim ID: ' . $claimIdName . '.';

                storeNotification('Claim', $uniqueArray, $message, $redirect_url);
            }
            DB::commit();
            return $this->sendResponse(true, getMessageText('update'));
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->sendError(getMessageText('update', false));
        }
    }
}
