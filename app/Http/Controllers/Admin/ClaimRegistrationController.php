<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\StoreInsuranceRegisterRequest;
use App\Models\ClaimRegister;
use App\Models\Client;
use App\Models\Group;
use App\Models\InsuranceClaim;
use App\Models\InsuranceHeading;
use App\Models\Member;
use App\Models\User;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClaimRegistrationController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $access = $this->accessCheck('claimregistration');
        $data['access'] = $access;
        if ($request->ajax()) {
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
            ])
                // ->whereNotNull('lot_no')
                // ->where('lot_no', $request->lot_id)
                // ->whereNull('register_no')
                ->when(!is_null($request->employee_id), function ($q) use ($request) {
                    $q->where('member_id', $request->employee_id);
                })
                ->when(!is_null($global_search = $request->global_search), function ($q) use ($global_search) {
                    $q->where(function ($q1) use ($global_search) {
                        $q1
                            // ->where('lot_no', 'ilike', '%' . $global_search . '%')
                            ->orWhereHas('member.user', function ($q3) use ($global_search) {
                                $q3->where('fname', 'ilike', '%' . $global_search . '%')
                                    ->orWhere('lname', 'ilike', '%' . $global_search . '%')
                                    ->orWhere('mname', 'ilike', '%' . $global_search . '%');
                            })
                            ->orWhereHas('relation', function ($q3) use ($global_search) {
                                $q3->where('rel_name', 'ilike', '%' . $global_search . '%');
                            })
                        ;
                    });
                })
                // ->when(!is_null($request->status), function ($q) use ($request) {
                //     $q->where('status', ($request->status == 'Pending' ? null : $request->status));
                // })
                ->where('clam_type', 'claim')
                ->where('status', InsuranceClaim::STATUS_RECEIVED)
                ->when(!is_null($request->group_id), function ($q) use ($request) {
                    $q->whereHas('member.memberPolicy', function ($q) use ($request) {
                        $q->where('group_id', $request->group_id);
                    });
                })
                ->when(!is_null($request->heading_id), function ($q) use ($request) {
                    $q->where('heading_id', $request->heading_id);
                })

                ->when(!is_null($request->from_date) && is_null($request->to_date), function ($q) use ($request) {
                    $q->where('created_at', '>=', $request->from_date);

                })
                ->when(!is_null($request->to_date) && is_null($request->from_date), function ($q) use ($request) {
                    $q->where('created_at', '<=', $request->to_date);

                })
                ->when(!is_null($request->to_date) && !is_null($request->from_date), function ($q) use ($request) {
                    $fromDate = Carbon::parse($request->from_date)->startOfDay();
                    $toDate = Carbon::parse($request->to_date)->endOfDay();
                    $q->whereBetween('created_at', [$fromDate, $toDate]);
                })
                ->get()
            ;
            // dd($claims);
            $filtered_claims = [];
            foreach ($claims->groupBy(function ($item) {
                return $item->claim_id;
            }) as $key => $grouped_claims) {
                $new_claim = $grouped_claims->first();
                $new_claim->bill_amount = $grouped_claims->sum('bill_amount');
                $new_claim->insurance_claim_ids = $grouped_claims->pluck("id");
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
                ->addColumn('submitted_by', function ($row) {
                    return $row?->creator?->fname . ' ' . $row?->creator?->mname . ' ' . $row?->creator?->lname;
                })
                ->addColumn('group', function ($row) {
                    return $row?->member?->memberPolicy?->group?->name;
                })
                ->addColumn('file_no', function ($row) {
                    return $row?->claimRegister?->file_no;
                })
                ->addColumn('action', function ($row) {
                    return "<a href='javascript:void(0)' class='preview btn btn-secondary btn-sm previewData' data-pid='$row->member_id' data-claim_id='$row->claim_id' data-url=" . route('claimsubmissions.show', "$row->id") . "><i class='fas fa-eye'></i> </a>";
                })
                ->addColumn('full_name', function ($row) {
                    return $row->fname . ' ' . $row->lname;
                })

                ->rawColumns(['action', 'is_active'])
                ->make(true);
        }
        $data['title'] = 'Claim Registration';
        $data['extraCss'] = commonDatatableFiles('css');
        $data['extraJs'] = commonDatatableFiles();
        $data['employees'] = Member::with('user')->get();
        $data['extraCss'][] = 'admin/cdns/select2-bootstrap-5/dist/select2-bootstrap-5-theme.min.css';
        $data['extraCss'][] = 'admin/cdns/select2@4.1/dist/css/select2.min.css';
        $data['extraJs'][] = 'admin/cdns/select2@4.1/dist/js/select2.min.js';
        $data['headings'] = InsuranceHeading::where('status', 'Y')->orderBy('name', 'asc')->get(['id', 'name']);
        $data['groups'] = Group::get();
        $data['clients'] = Client::get(['id', 'name']);
        return view('backend.claimregistration.list', $data);
    }

    public function oldindex(Request $request)
    {
        $access = $this->accessCheck('claimregistration');
        $data['access'] = $access;
        if ($request->ajax()) {
            // dump($request->all());
            $members = Member::whereHas('insuranceClaim', function ($q) use ($request) {
                $q->whereNull('register_no')
                    ->where('lot_no', $request->lot_id)
                    ->when($request->has('heading_id') && !is_null($request->heading_id), function ($query) use ($request) {
                        $query->where('heading_id', $request->heading_id);
                    })
                ;
            })->whereHas('memberPolicy', function ($q) use ($request) {
                $q->where('group_id', $request->group_id);
            })
                ->with(['insuranceClaim', 'memberPolicy', 'user'])
                ->get();
            $filtered_members = [];
            $members->map(function ($member) use (&$filtered_members) {
                $insuranceClaims = $member->insuranceClaim->groupBy("relative_id");
                foreach ($insuranceClaims as $relative_id => $claim) {
                    $new_member = $member;
                    $new_member->insuranceClaim = $new_member->insuranceClaim->where("relative_id", $relative_id);
                    $filtered_members[] = $new_member;
                }

            });
            // dd($filtered_members);
            return Datatables::of($filtered_members)
                ->addIndexColumn()
                ->addColumn('member_name', function ($row) {
                    // dd($row->values());
                    // dd($row);
                    $employee = $row?->user;
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
                // ->addColumn('client_name', function ($row) {
                //     return $row?->member?->client?->name;
                // })
                // ->addColumn('designation', function ($row) {
                //     return $row?->member?->designation;
                // })
                // ->addColumn('branch', function ($row) {
                //     return $row?->member?->branch;
                // })
                // ->addColumn('submitted_by', function ($row) {
                //     return $row?->creator?->fname . ' ' . $row?->creator?->mname . ' ' . $row?->creator?->lname;
                // })
                // ->addColumn('group', function ($row) {
                //     return $row?->member?->memberPolicy?->group?->name;
                // })
                // ->addColumn('action', function ($row) {
                //     $btn = '';
                //     $btn = "<a href='javascript:void(0)' class='preview btn btn-secondary btn-sm previewData' data-pid='" . $row->id . "' data-url=" . route('claimsubmissions.show', "$row->id") . "><i class='fas fa-eye'></i> </a>";

                //     $btn .= "<br><a href='javascript:void(0)' class='btn btn-success btn-sm scrutinyBtn' data-pid='" . $row->id . "' ><i class='fas fa-file-medical-alt'></i> </a>";
                //     return $btn;
                // })
                // ->addColumn('full_name', function ($row) {
                //     return $row->fname . ' ' . $row->lname;
                // })

                ->rawColumns(['action', 'is_active'])
                ->make(true);
        }
        $data['title'] = 'Claim Registration';
        $data['extraCss'] = commonDatatableFiles('css');
        $data['extraJs'] = commonDatatableFiles();
        $data['extraCss'][] = 'admin/cdns/select2-bootstrap-5/dist/select2-bootstrap-5-theme.min.css';
        $data['extraCss'][] = 'admin/cdns/select2@4.1/dist/css/select2.min.css';
        $data['extraJs'][] = 'admin/cdns/select2@4.1/dist/js/select2.min.js';
        $data['headings'] = InsuranceHeading::where('status', 'Y')->orderBy('name', 'asc')->get(['id', 'name']);
        $data['groups'] = Group::get();
        $data['clients'] = Client::get(['id', 'name']);
        return view('backend.claimregistration.list', $data);
    }
    public function store(StoreInsuranceRegisterRequest $request)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('claimregistration'), 'isinsert');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();

            $claims = InsuranceClaim::whereIn('id', $validatedData['insurance_claim_id'])
                ->whereNull('register_no')
                ->where('clam_type', 'claim')
                ->get();
            $claims_ids = $claims->pluck('claim_id')->unique();

            foreach ($claims_ids as $claims_id) {
                $initialFileNo = ClaimRegister::count();
                $fileNo = $initialFileNo + 1;
                $register = ClaimRegister::create([
                    'file_no' => 'FN' . $fileNo,
                    'claim_no' => 'CN' . $fileNo
                    // 'FN' . $formattedNumberFileNo
                ]);
                if ($register) {
                    $insuranceClaims = InsuranceClaim::with('member')
                        ->whereIn('id', $validatedData['insurance_claim_id'])
                        ->whereNull('register_no')
                        ->where('clam_type', 'claim')
                        ->where('claim_id', $claims_id)
                        ->get();
                    foreach ($insuranceClaims as $claim) {
                        $claim->update([
                            'register_no' => $register->id,
                            'status' => InsuranceClaim::STATUS_REGISTERED,
                        ]);
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
                    $message = 'The claim status has been changed to ' . InsuranceClaim::STATUS_REGISTERED . ' for Claim ID: ' . $claimIdName . '.';
                    storeNotification('Claim', $uniqueArray, $message, $redirect_url);
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
