<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ClaimReceiveRequest;
use App\Models\Group;
use App\Models\InsuranceClaim;
use App\Models\InsuranceHeading;
use App\Models\Member;
use App\Models\Package;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use App\Http\Requests\StoreInsuranceInitiateRequest;
use App\Models\InsuranceLot;

class ClaimReceivedController extends BaseController
{
    public $folder;
    public function __construct()
    {

        $this->folder = 'backend.claimreceived';
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $access = $this->accessCheck('claimreceived');
        if ($request->ajax()) {
            // Fetch members with their related user and insuranceClaim data
            $members = Member::with([
                'user:id,fname,lname,mname',
                'insuranceClaim.relation:id,rel_name',
                'insuranceClaim' =>
                    function ($q) use ($request) {
                        $this->addDateFilters($q, $request);
                    }
            ])
                ->whereHas('insuranceClaim', function ($q) use ($request) {
                    $this->addDateFilters($q, $request);
                })
                ->when($request->is_all == 'false' && $request->employee_id, function ($q) use ($request) {
                    $q->where('id', $request->employee_id);
                })
                ->when($request->is_all == 'false' && $request->group_id, function ($q) use ($request) {
                    $q->whereHas('memberPolicy', function ($q2) use ($request) {
                        $q2->where('group_id', $request->group_id);
                    });
                })
                ->get();

            // Group each member's insuranceClaim by relative_id
            $groupedMembers = $members->map(function ($member) {
                $groupedClaims = $member->insuranceClaim->groupBy(function ($claim) {
                    return $claim->relative_id ?? 'self';
                });

                return [
                    'full_name' => preg_replace('/\s+/', ' ', trim($member?->user?->fname . ' ' . $member?->user?->mname . ' ' . $member?->user?->lname)),
                    'id' => $member['id'],
                    'client_id' => $member['client_id'],
                    'user_id' => $member['user_id'],
                    'date_of_birth_bs' => $member['date_of_birth_bs'],
                    'date_of_birth_ad' => $member['date_of_birth_ad'],
                    'marital_status' => $member['marital_status'],
                    'gender' => $member['gender'],
                    'perm_province' => $member['perm_province'],
                    'perm_district' => $member['perm_district'],
                    'perm_city' => $member['perm_city'],
                    'perm_ward_no' => $member['perm_ward_no'],
                    'perm_street' => $member['perm_street'],
                    'perm_house_no' => $member['perm_house_no'],
                    'is_address_same' => $member['is_address_same'],
                    'present_province' => $member['present_province'],
                    'present_district' => $member['present_district'],
                    'present_city' => $member['present_city'],
                    'present_ward_no' => $member['present_ward_no'],
                    'present_street' => $member['present_street'],
                    'present_house_no' => $member['present_house_no'],
                    'mail_address' => $member['mail_address'],
                    'phone_number' => $member['phone_number'],
                    'employee_id' => $member['employee_id'],
                    'branch' => $member['branch'],
                    'designation' => $member['designation'],
                    'date_of_join' => $member['date_of_join'],
                    'mobile_number' => $member['mobile_number'],
                    'email' => $member['email'],
                    'total_amount' => $member->insuranceClaim->sum('bill_amount'),
                    'groupedClaims' => $groupedClaims,
                ];
            });

            // Convert the collection to an array if needed
            $data['members'] = $groupedMembers;
            $data['access'] = $access;

            // Return Blade view HTML
            return View::make($this->folder . '.intimate-claim', $data)->render();
        }
        $data['folder'] = $this->folder;
        $data['access'] = $access;
        $data['title'] = 'Claim Received';
        $data['extraCss'] = commonDatatableFiles('css');
        $data['extraJs'] = commonDatatableFiles();
        $data['extraCss'][] = 'admin/cdns/select2-bootstrap-5/dist/select2-bootstrap-5-theme.min.css';
        $data['extraCss'][] = 'admin/cdns/select2@4.1/dist/css/select2.min.css';
        $data['extraJs'][] = 'admin/cdns/select2@4.1/dist/js/select2.min.js';
        $data['employees'] = Member::with('user')->get();
        $data['groups'] = Group::get();
        return view($this->folder . '.list', $data);
    }

    // Function to add date filters to the query
    function addDateFilters($q, $request)
    {
        $q->where('clam_type', 'claim')
            ->whereNull('lot_no')
            ->when($request->is_all == 'false' && !is_null($request->from_date) && is_null($request->to_date), function ($q) use ($request) {
                $q->where('created_at', '>=', $request->from_date);
            })
            ->when($request->is_all == 'false' && !is_null($request->to_date) && is_null($request->from_date), function ($q) use ($request) {
                $q->where('created_at', '<=', $request->to_date);
            })
            ->when($request->is_all == 'false' && !is_null($request->to_date) && !is_null($request->from_date), function ($q) use ($request) {
                $fromDate = Carbon::parse($request->from_date)->startOfDay();
                $toDate = Carbon::parse($request->to_date)->endOfDay();
                $q->whereBetween('created_at', [$fromDate, $toDate]);
            });
    }
    public function store(StoreInsuranceInitiateRequest $request)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('claimreceived'), 'isinsert');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            $parts = explode('__', $validatedData['employee_id'][0]);
            if (count($parts) !== 2) {
                return false;
            }

            $member_id = $parts[0];
            $data = Member::select('id', 'client_id')->with('memberPolicy:id,group_id,member_id')->find($member_id);
            if (isset($data->id)) {
                $lot = InsuranceLot::create([
                    'group_id' => $data?->memberPolicy?->group_id,
                    'client_id' => $data->client_id,
                    'status' => 'Registered',
                ]);
            }
            if ($lot) {
                foreach ($validatedData['employee_id'] as $key => $value) {
                    // Split employee_id into member_id and relative_id
                    $parts = explode('__', $value);
                    if (count($parts) !== 2) {
                        return false;
                    }

                    $member_id = $parts[0];
                    $relative_id = $parts[1] == "" ? null : $parts[1];
                    // Check if both member_id and relative_id exist in insurance_claims
                    $claims = InsuranceClaim::where('member_id', $member_id)
                        ->where('relative_id', $relative_id)
                        ->whereNull('lot_no')
                        ->where('clam_type', 'claim')
                        ->get();
                    foreach ($claims as $claim) {
                        $claim->update([
                            'lot_no' => $lot->id,
                            'status' => InsuranceClaim::STATUS_RECEIVED
                        ]);
                    }
                }
            }
            DB::commit();
            return $this->sendResponse(true, getMessageText('insert'));
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->sendError(getMessageText('insert', false));
        }
    }
}
