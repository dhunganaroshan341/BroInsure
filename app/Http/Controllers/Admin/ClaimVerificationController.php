<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ClaimVerification\MakeVerificationIndividualRequest;
use Carbon\Carbon;
use App\Models\Group;
use App\Models\Client;
use App\Models\Member;
use App\Models\Scrunity;
use App\Models\MemberPolicy;
use Illuminate\Http\Request;
use App\Models\InsuranceClaim;
use App\Models\InsuranceHeading;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\BaseController;
use App\Http\Requests\ClaimVerification\GetScrutinyDetailsRequest;
use App\Http\Requests\ClaimVerification\MakeVerificationRequest;
use App\Models\ClaimNote;
use App\Models\ClaimRegister;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClaimVerificationController extends BaseController
{
    public function index(Request $request)
    {
        $access = $this->accessCheck('claimscreening');
        $data['access'] = $access;
        if ($request->ajax()) {
            // dd($request->all());
            $claims = InsuranceClaim::with([
                'heading:id,name',
                'claimRegister',
                'member.currentMemberPolicy' => function ($query) use ($request) {
                    $query->when(!is_null($request->group_id), function ($q) use ($request) {
                        $q->where('group_id', $request->group_id);
                    });
                },
                'member.user',
                'relation:rel_name,rel_relation,id,rel_dob',
                'creator:id,fname,mname,lname',
                // 'lot'
            ])
                // ->where('lot_no', $request->lot_id)
                ->when(!is_null($request->claim_id), function ($q) use ($request) {
                    $q->where('claim_id', $request->claim_id);
                })
                // ->where('register_no', $request->claim_no)

                ->when(!is_null($request->heading_id), function ($q) use ($request) {
                    $q->where('heading_id', $request->heading_id);
                })

                ->when(!is_null($request->from_date) && is_null($request->to_date), function ($q) use ($request) {
                    $q->whereDate('created_at', '>=', $request->from_date);
                })
                ->when(!is_null($request->to_date) && is_null($request->from_date), function ($q) use ($request) {
                    $q->whereDate('created_at', '<=', $request->to_date);
                })
                ->when(!is_null($request->to_date) && !is_null($request->from_date), function ($q) use ($request) {
                    $fromDate = Carbon::parse($request->from_date)->startOfDay();
                    $toDate = Carbon::parse($request->to_date)->endOfDay();
                    $q->whereBetween('created_at', [$fromDate, $toDate]);
                })
                ->where('status', InsuranceClaim::STATUS_SCRUNITY)
                ->whereHas('scrunity', function ($query) {
                    $query->where('status', '!=', Scrunity::STATUS_DRAFT);
                })
                ->get();
            // dd($claims);
            $filtered_claims = [];
            foreach ($claims->groupBy(function ($item) {
                return $item->claim_id;
            }) as $key => $grouped_claims) {
                $new_claim = $grouped_claims->first();
                $new_claim->bill_amount = $grouped_claims->sum('bill_amount');
                $filtered_claims[] = $new_claim;
            }
            return Datatables::of($filtered_claims)
                ->addIndexColumn()
                ->addColumn('member_name', function ($row) {
                    $employee = $row?->member?->user;
                    return $employee?->fname . ' ' . $employee?->mname . ' ' . $employee?->lname;
                })
                ->addColumn('dependent_name', function ($row) {
                    return ($row->relative_id) ? $row?->relation?->rel_name : 'Self';
                })
                ->addColumn('relation', function ($row) {
                    return ($row->relative_id) ? $row?->relation?->rel_relation : '';
                })
                ->addColumn('dob', function ($row) {
                    return ($row->relative_id) ? $row?->relation?->rel_dob : $row?->member?->date_of_birth_ad;
                })
                ->addColumn('claim_title', function ($row) {
                    return $row?->heading?->name;
                })
                ->addColumn('claim_date', function ($row) {
                    return Carbon::parse($row->created_at)->toDateString();
                })
                ->addColumn('client_name', function ($row) {
                    return $row?->member?->client?->name;
                })
                ->addColumn('designation', function ($row) {
                    return $row?->member?->designation;
                })
                ->addColumn('branch', function ($row) {
                    return $row?->member?->branch;
                })
                ->addColumn('file_no', function ($row) {
                    return $row?->claimRegister?->file_no;
                })
                ->addColumn('submitted_by', function ($row) {
                    return $row?->creator?->fname . ' ' . $row?->creator?->mname . ' ' . $row?->creator?->lname;
                })
                ->addColumn('group', function ($row) {
                    return $row?->member?->memberPolicy?->group?->name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    $btn = "<a href='javascript:void(0)' class='preview btn btn-secondary btn-sm previewData' data-claim_id='" . $row->claim_id . "' data-pid='" . $row->member_id . "' data-url=" . route('claimsubmissions.show', "$row->id") . "><i class='fas fa-eye'></i></a>";

                    $btn .= "<br><a href='javascript:void(0)' class='btn btn-success btn-sm scrutinyBtn' data-claim_id='" . $row->claim_id . "' data-pid='" . $row?->member->id . "' data-relative_id='" . $row->relative_id . "' ><i class='fas fa-file-medical-alt'></i></a>";
                    return $btn;
                })
                ->addColumn('full_name', function ($row) {
                    return $row->fname . ' ' . $row->lname;
                })

                ->rawColumns(['action', 'is_active'])
                ->make(true);
        }
        $data['title'] = 'Claim Verification';
        $data['extraCss'] = commonDatatableFiles('css');
        $data['extraJs'] = commonDatatableFiles();
        $data['extraCss'][] = 'admin/cdns/select2-bootstrap-5/dist/select2-bootstrap-5-theme.min.css';
        $data['extraCss'][] = 'admin/cdns/select2@4.1/dist/css/select2.min.css';
        $data['extraJs'][] = 'admin/cdns/select2@4.1/dist/js/select2.min.js';
        $data['headings'] = InsuranceHeading::where('status', 'Y')->orderBy('name', 'asc')->get(['id', 'name']);
        $data['groups'] = Group::get();
        $data['clients'] = Client::get(['id', 'name']);
        return view('backend.claimverification.list', $data);
    }

    public function getScrutiny(GetScrutinyDetailsRequest $request)
    {
        $member_id = request()->query("member_id");
        $lot_id = request()->query("lot_id");
        $relative_id = request()->query("relative_id");

        $member = Member::where('id', $member_id)->with(['currentMemberPolicy.group.headings'])->first();
        // $memberPolicy = MemberPolicy::
        //     // whereHas('member',function($q) use($request){
        //     //     $q->
        //     // })->
        //     where('member_id', $member_id)
        //     ->where('group_id', $member->group_package[0]->group_id)
        //     ->where('package_id', $member->group_package[0]->package_id)->first();
        $memberPolicy = $member->memberPolicy;
        $scrutiny = Scrunity::with("details")
            ->where([
                // 'lot_id' => $lot_id,
                'member_id' => $member_id,
                'relative_id' => $relative_id,
                'member_policy_id' => $memberPolicy->id,
            ])
            ->whereHas('claims', function ($q) use ($request) {
                $q->where('claim_id', $request->claim_id);
            })
            ->first();
        $details_html = View::make("backend.claimregistration.add_amount_tbody", [
            "details" => $scrutiny->details
        ])->render();
        return $this->sendResponse([
            "html" => $details_html,
            "serial_no" => $scrutiny->details->count() + 1
        ], "");
    }

    public function store(MakeVerificationRequest $request)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('claimverification'), 'isinsert');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        try {
            DB::beginTransaction();
            foreach ($request->data as $k => $item) {
                $member = Member::where('id', $item["member_id"])->with(['currentMemberPolicy.group.headings'])->first();

                Scrunity::query()
                    ->where([
                        'claim_no_id' => $item["claim_no"],
                        'member_id' => $item["member_id"],
                        'relative_id' => $item["relative_id"] ?? null,
                        'member_policy_id' => $member->currentMemberPolicy->id,
                    ])
                    ->update([
                        "status" => Scrunity::STATUS_VERIFIED
                    ]);
                $insuranceClaims = InsuranceClaim::query()
                    ->where([
                        'member_id' => $item["member_id"],
                        'relative_id' => $item["relative_id"] ?? null,
                    ])
                    ->whereRelation('claimRegister', 'id', $item['claim_no'])
                    ->get();
                foreach ($insuranceClaims as $claim) {
                    $claim->update([
                        "status" => InsuranceClaim::STATUS_VERIFIED
                    ]);
                }


                // $scrutiny->update(["status" => Scrunity::STATUS_REQUEST]);

                ClaimNote::create([
                    'claim_no_id' => $item["claim_no"],
                    'client_id' => $member->client_id,
                ]);
            }

            DB::commit();
            return $this->sendResponse(true, getMessageText('insert'));
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->sendError(getMessageText('insert', false));
        }
        return $this->sendResponse([], "Success");
    }
    public function storeIndividual(MakeVerificationIndividualRequest $request)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('claimverification'), 'isinsert');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        try {
            DB::beginTransaction();
            $item = $request->validated();
            $member = Member::where('id', $item["member_id"])->with(['currentMemberPolicy.group.headings'])->first();
            if ($item["type"] == 'verify_request') {
                $scrunityStatus = Scrunity::STATUS_VERIFIED;
                $claimStatus = InsuranceClaim::STATUS_VERIFIED;
            } else if ($item["type"] == 'reject_request') {
                $scrunityStatus = Scrunity::STATUS_REJECTED;
                $claimStatus = InsuranceClaim::STATUS_REGISTERED;
            }
            Scrunity::query()
                ->where([
                    'claim_no_id' => $item["claim_no"],
                    'member_id' => $item["member_id"],
                    'relative_id' => $item["relative_id"] ?? null,
                    'member_policy_id' => $member->currentMemberPolicy->id,
                ])
                ->update([
                    "status" => $scrunityStatus
                ]);
            $insuranceClaims = InsuranceClaim::with('member')
                ->where([
                    'member_id' => $item["member_id"],
                    'relative_id' => $item["relative_id"] ?? null,
                ])
                ->whereRelation('claimRegister', 'id', $item['claim_no'])
                ->get();
            foreach ($insuranceClaims as $claim) {
                $claim->update([
                    "status" => $claimStatus
                ]);
            }


            // $scrutiny->update(["status" => Scrunity::STATUS_REQUEST]);
            if ($item["type"] == 'verify_request') {
                // ClaimNote::create([
                //     'claim_no_id' => $item["claim_no"],
                //     'client_id' => $member->client_id,
                // ]);
                ClaimNote::updateOrCreate(
                    ['claim_no_id' => $item["claim_no"], 'client_id' => $member->client_id], // Condition to find the record
                    [
                    ]
                );

            }
            $current_user = getUserDetail();
            $firstClaim = $insuranceClaims[0];
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
            if ($item["type"] == 'verify_request') {
                $message = 'The claim scrutiny has been ' . Scrunity::STATUS_VERIFIED . ' for Claim ID: ' . $claimIdName . '.';
            } else if ($item["type"] == 'reject_request') {
                $message = 'The claim scrutiny has been ' . Scrunity::STATUS_REJECTED . ' for Claim ID: ' . $claimIdName . '.';
            }
            storeNotification('Claim', $uniqueArray, $message, $redirect_url);
            DB::commit();
            return $this->sendResponse(true, getMessageText('insert'));
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->sendError(getMessageText('insert', false));
        }
        return $this->sendResponse([], "Success");
    }
    public function getClaimRegisterByLog(int $lot_id)
    {
        $claim_registers = ClaimRegister::query()
            ->where("lot_id", $lot_id)
            ->get(['id', 'claim_no']);
        return $this->sendResponse($claim_registers);
    }
}
