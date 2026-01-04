<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ClaimList\UpdateClaimRequest;
use App\Http\Requests\ClaimResubmissionStoreRequest;
use App\Http\Requests\ClaimStatusChangeRequest;
use App\Http\Requests\ClaimStoreRequest;
use App\Models\InsuranceClaim;
use App\Models\InsuranceHeading;
use App\Models\Member;
use App\Models\MemberPolicy;
use App\Models\User;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClaimSubmissionController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $access = $this->accessCheck('claimsubmissions');
        $user = getUserDetail();
        // dd($user);
        $data['currentUser'] = $user;
        $data['access'] = $access;
        $data['title'] = 'Claim Submission';
        $data['extraCss'] = commonDatatableFiles('css');
        $data['extraJs'] = commonDatatableFiles();
        $data['extraCss'][] = 'admin/cdns/select2-bootstrap-5/dist/select2-bootstrap-5-theme.min.css';
        $data['extraCss'][] = 'admin/cdns/select2@4.1/dist/css/select2.min.css';
        $data['extraJs'][] = 'admin/cdns/select2@4.1/dist/js/select2.min.js';
        $data['extraCss'][] = 'admin/assets/css/nepali-datepicker.min.css';
        $data['extraJs'][] = 'admin/assets/js/nepali-datepicker.min.js';
        $data['headings'] = InsuranceHeading::with(['sub_headings'])->where('status', 'Y')->orderBy('name', 'asc')->get(['id', 'name']);
        $data['employees'] = Member::with('user')->where(function ($q) use ($user) {
            if ($user->rolecode === 'HR') {
                $q->where('client_id', $user->client_id);
            } elseif ($user->rolecode == 'MB') {
                $q->where('id', $user->member_id);
            }
        })
            ->where('is_active', 'Y')
            ->get();

        $data['resubmissions'] = InsuranceClaim::select('claim_id')
            ->where('status', InsuranceClaim::STATUS_RESUBMISSION)
            ->when($user, function ($q) use ($user) {
                if ($user->rolecode === 'HR') {
                    $q->whereHas('member', function ($q1) use ($user) {
                        $q1->where('client_id', $user->client_id);
                    });
                } elseif ($user->rolecode == 'MB') {
                    $q->where('member_id', $user->member_id);
                }
            })
            ->groupBy("claim_id")
            ->get();
        return view('backend.claimsubmission.list', $data);
    }

    public function store(ClaimStoreRequest $request)
    {
        // $accessCheck = $this->checkAccess($this->accessCheck('members'), 'isinsert');
        // if ($accessCheck && $accessCheck['status'] == false) {
        //     return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        // }
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            $folder = 'uploads/claim';
            if ($request->type == 'old') {
                $empgroup = MemberPolicy::where('member_id', $validatedData['member_id'])->where('policy_id', $validatedData['policy_id'])->pluck('group_id')->first();
            } else {
                $empgroup = MemberPolicy::where('member_id', $validatedData['member_id'])->where('is_current', 'Y')->pluck('group_id')->first();
            }
            $member = Member::with('client.insurance_claims')->where('id', $validatedData['member_id'])->first();
            // $claimIdName=$member->client->name.$member->client->insurance_claims->count();
            $claimIdName = 'test' . InsuranceClaim::distinct('claim_id')->count() + 1;
            $save_type = $validatedData['save_type'] ?? 'draft';
            foreach ($validatedData['heading_id'] as $key => $heading) {
                $file = $validatedData['bill_file'][$key];
                $filename = $this->uploadfiles($file, $folder);
                $data = [
                    'member_id' => $validatedData['member_id'],
                    'heading_id' => $heading,
                    'group_id' => $empgroup,
                    'sub_heading_id' => $validatedData['sub_heading_id'][$key],
                    'relative_id' => $validatedData['relative_id'] ?? null,
                    'claim_for' => $validatedData['relative_id'] ? 'other' : 'self',
                    'document_type' => $validatedData['document_type'][$key],
                    'bill_file_name' => $validatedData['bill_file_name'][$key],
                    'bill_file_size' => $validatedData['bill_file_size'][$key],
                    'file_path' => $filename,
                    'status' => InsuranceClaim::STATUS_RECEIVED,
                    'claim_id' => $claimIdName,
                    'document_date' => $validatedData['document_date'][$key],
                    'remark' => $validatedData['remark'][$key] ?? '',
                    'bill_amount' => $validatedData['bill_amount'][$key],
                    'clinical_facility_name' => $validatedData['clinical_facility_name'][$key] ?? '',
                    'diagnosis_treatment' => $validatedData['diagnosis_treatment'][$key] ?? '',
                    'clam_type' => $save_type,
                ];
                InsuranceClaim::create($data);
            }
            if ($save_type == 'claim') {
                $current_user = getUserDetail();
                $claimUserClientId = $member->client_id;
                $claimUserMemberId = $member->id;
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
                $message = 'Claim has been successfully submitted with Claim ID : ' . $claimIdName;
                storeNotification('Claim', $uniqueArray, $message, $redirect_url);
            }
            DB::commit();
            return $this->sendResponse(true, 'Your Claims have been submitted successfully, Your Claim id is ' . $claimIdName);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->sendError(getMessageText('insert', false));
        }
    }

    public function show($id)
    {
        $insuranceClaim = InsuranceClaim::find($id);
        return is_null($insuranceClaim)
            ? $this->sendError("Insurance submission not found")
            : $this->sendResponse($insuranceClaim, "");
    }

    public function claimlist(Request $request)
    {
        // return view('backend.usertype.list2');
        //check button acce ss
        $access = $this->accessCheck('claimsubmissions');
        $currentuser = getUserDetail();
        // dd($currentuser);
        $headings = InsuranceHeading::all();
        if ($request->ajax()) {
            $currentuserId = getUserDetail()->id;
            $claims = InsuranceClaim::with(['heading:id,name', 'sub_heading:id,name', 'member.user', 'member.companyPolicies', 'relation:rel_name,rel_relation,id', 'scrunity.details', 'logs'])
                ->when(!is_null($request->employee_id), function ($q) use ($request) {
                    $q->where('member_id', $request->employee_id);
                })
                ->when(!is_null($request->claim_id), function ($q) use ($request) {
                    $q->where('claim_id', $request->claim_id);
                })
                ->when(!is_null($request->claim_type), function ($q) use ($request) {
                    $q->where('clam_type', $request->claim_type);
                })
                ->when(!is_null($request->from_date) && is_null($request->to_date), function ($q) use ($request) {
                    // dd('here');
                    $q->where('created_at', '>=', $request->from_date);
                })
                ->when(!is_null($request->to_date) && is_null($request->from_date), function ($q) use ($request) {
                    $q->where('created_at', '<=', $request->to_date);
                })->when(in_array($currentuser->rolecode, ['MB', 'HR']), function ($q) use ($currentuser) {
                    if ($currentuser->rolecode == 'MB') {
                        $q->whereHas('member.user', function ($query) use ($currentuser) {
                            $query->where('id', $currentuser->id);
                        });
                    } else {
                        # code...
                    }

                })
                ->when(!is_null($request->to_date) && !is_null($request->from_date), function ($q) use ($request) {
                    $fromDate = Carbon::parse($request->from_date)->startOfDay();
                    $toDate = Carbon::parse($request->to_date)->endOfDay();
                    $q->whereBetween('created_at', [$fromDate, $toDate]);
                });
            if (isset($request->type) && $request->type == 'group') {
                $filtered_claims = [];
                $claims = $claims->get();
                foreach ($claims->groupBy(function ($item) {
                    return $item->claim_id;
                }) as $key => $grouped_claims) {
                    $new_claim = $grouped_claims->first();
                    $new_claim->bill_amount = $grouped_claims->sum('bill_amount');
                    $new_claim->insurance_claim_ids = $grouped_claims->pluck("id");
                    $filtered_claims[] = $new_claim;
                }
            } else {
                $filtered_claims = $claims;
            }
            // dd($filtered_claims[0]->scrunity->details->pluck('remarks')->implode(','));
            return Datatables::of($filtered_claims)
                ->addIndexColumn()
                ->addColumn('member_name', function ($row) {
                    $employee = $row?->member?->user;
                    return $employee?->fname . ' ' . $employee?->mname . ' ' . $employee?->lname;
                })
                ->addColumn('designation', function ($row) {
                    return $row?->member?->designation;
                })
                ->addColumn('branch', function ($row) {
                    return $row?->member?->branch;
                })
                ->addColumn('policy_no', function ($row) {
                    return $row?->group?->policy?->policy_no;
                })
                ->addColumn('heading', function ($row) {
                    return $row?->heading?->name;
                })
                ->addColumn('sub_heading', function ($row) {
                    return $row?->sub_heading?->name;
                })
                ->addColumn('status', function ($row) {
                    return $row?->status ? str_replace('_', ' ', $row?->status) . ($row->status == 'Approved' ? ' (' . $row->scrunity->details->sum('approved_amount') . ')' : '') : 'Pending';
                    // return $row?->lot?->status ?? 'Pending';
                })
                ->addColumn('status_remarks', function ($row) {
                    return $row?->status ? ($row->status == 'Resubmission'||$row->status == 'Rejected' ? $row->logs->where('type', $row->status)->sortByDesc('id')->first()->remarks : ($row->status == 'Approved' ? $row->scrunity->details->pluck('remarks')->implode(',') : '')) : '';
                    // return $row?->lot?->status ?? 'Pending';
                })
                ->addColumn('member', function ($row) {
                    return ($row->relative_id) ? $row?->relation?->rel_name : 'Self';
                })
                ->addColumn('relation', function ($row) {
                    return ($row->relative_id) ? $row?->relation?->rel_relation : '';
                })
                ->addColumn('bill_amount', function ($row) {
                    return 'Rs. '.numberFormatter($row->bill_amount);
                })
                ->addColumn('action', function ($row) use ($access, $currentuserId, $request) {
                    $btn = '';
                    if (isset($request->type) && $request->type == 'group') {
                        $btn .= "<a href='javascript:void(0)' class='preview btn btn-secondary btn-sm previewData'  data-toggle='tooltip' data-placement='top' title='View All Claims' data-claim_id='" . $row->claim_id . "' ><i class='fas fa-eye'></i> </a>";
                    } else {
                        // Claim
                        if ($row->clam_type == 'draft' && $access['isupdate'] == 'Y' && $row->created_by == $currentuserId) {
                            // $btn .= "&nbsp;<a href='javascript:void(0)' class=' btn labelsmaller  btn-success btn-sm makeClaim' data-pid='" . $row->id . "' data-url=" . route('claim.makeClaim', "$row->id") . ">Claim</a>";
                        }
                        // Edit
                        if (($row->status == InsuranceClaim::STATUS_RECEIVED || $row->status == InsuranceClaim::STATUS_DOCUMENT_CORRECTION) && $access['isedit'] == 'Y') {
                            $btn .= "
                            &nbsp;
                            <a href='javascript:void(0)'
                            class='edit btn labelsmaller  btn-primary btn-sm editData'
                            data-imitation_days='" . $row->member->companyPolicies->first()->imitation_days . "'
                            data-pid='" . $row->id . "'
                            data-relative_id='$row->relative_id'
                            data-url=" . route('claimsubmissions.show', "$row->id") . ">
                                <i class='fas fa-edit'></i>
                                Edit
                            </a>";
                        }
                    }
                    return $btn;
                })
                ->addColumn('file', function ($row) {
                    return "<a  target='_blank' href='" . asset($row->file_path) . "' >" . $row->bill_file_name . "</a>";
                })
                ->rawColumns(['action', 'file', 'status_remarks'])
                ->make(true);
        }
        $data['access'] = $access;
        $data['title'] = 'Claim List';
        $data['form_title'] = 'View Claim';
        $data['extraCss'] = commonDatatableFiles('css');
        $data['extraJs'] = commonDatatableFiles();
        $data['extraCss'][] = 'admin/cdns/select2-bootstrap-5/dist/select2-bootstrap-5-theme.min.css';
        $data['extraCss'][] = 'admin/cdns/select2@4.1/dist/css/select2.min.css';
        $data['extraJs'][] = 'admin/cdns/select2@4.1/dist/js/select2.min.js';
        $data['employees'] = Member::with('user')->where(function ($q) use ($currentuser) {
            if ($currentuser->rolecode === 'HR') {
                $q->where('client_id', $currentuser->client_id);
            } elseif ($currentuser->rolecode == 'MB') {
                $q->where('id', $currentuser->member_id);
            }
        })->get();
        $data['headings'] = $headings;
        $data['request_member_id'] = $request->member_id;
        return view('backend.claimsubmission.claimlist', $data);
    }

    public function makeClaim($id)
    {
        $insuranceClaim = InsuranceClaim::find($id);
        $accessCheck = $this->checkAccess($this->accessCheck('claimsubmissions'), 'isupdate');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        if (isset($insuranceClaim->id) && $insuranceClaim->created_by == getUserDetail()->id && $insuranceClaim->clam_type == 'draft') {
            $data_save = $insuranceClaim->update([
                'clam_type' => 'claim'
            ]);

            if ($data_save) {
                return $this->sendResponse(true, getMessageText('update'));
            } else {
                return $this->sendError(getMessageText('update', false));
            }
        } else {
            return $this->sendError('Invalid Action Performed.');
        }
    }

    public function makeClaimByClaimId($claim_id)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('claimsubmissions'), 'isupdate');

        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message']], 403);
        }
        $insuranceClaims = InsuranceClaim::where('claim_id', $claim_id)->get();

        if ($insuranceClaims->isNotEmpty()) {
            // Check if created_by and clam_type conditions are satisfied for any claim
            $isDraftClaim = $insuranceClaims->contains(function ($claim) {
                return $claim->created_by == getUserDetail()->id && $claim->clam_type == 'draft';
            });

            if ($isDraftClaim) {
                // Update all claims that match the condition
                $updatedCount = $insuranceClaims->filter(function ($claim) {
                    return $claim->clam_type == 'draft'; // You can specify the condition if needed
                })->each(function ($claim) {
                    $claim->update(['clam_type' => 'claim']);
                })->count(); // Count how many were updated

                if ($updatedCount > 0) {
                    return $this->sendResponse(true, getMessageText('update'));
                } else {
                    return $this->sendError(getMessageText('update', false));
                }
            } else {
                return $this->sendError('No draft claims found for the current user.');
            }
        } else {
            return $this->sendError('Invalid Action Performed.');
        }

    }

    public function update(UpdateClaimRequest $request, $id)
    {
        $insuranceClaim = InsuranceClaim::find($id);
        if (is_null($insuranceClaim))
            return $this->sendError("Insurance claim not found");
        // $accessCheck = $this->checkAccess($this->accessCheck('members'), 'isinsert');
        // if ($accessCheck && $accessCheck['status'] == false) {
        //     return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        // }
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            $folder = 'uploads/claim';
            $file = $validatedData['bill_file'] ?? null;
            $old_file_path = $insuranceClaim->file_path;

            $data = [
                'member_id' => $validatedData['member_id'],
                'relative_id' => $validatedData['relative_id'] ?? null,
                'heading_id' => $validatedData['heading_id'],
                'sub_heading_id' => $validatedData['sub_heading_id'],
                'document_type' => $validatedData['document_type'],
                'document_date' => $validatedData['document_date'],
                'remark' => $validatedData['remark'],
                'bill_amount' => $validatedData['bill_amount'],
                'clinical_facility_name' => $validatedData['clinical_facility_name'],
                'diagnosis_treatment' => $validatedData['diagnosis_treatment'],
                'bill_file_name' => $validatedData['bill_file_name'],
            ];
            if ($file) {
                $sizeInBytes = $file->getSize();
                $sizeInKB = $sizeInBytes / 1024;

                // Store the size in KB back into the validated data array
                $data['bill_file_size'] = round($sizeInKB, 2) . ' KB';
                $data['file_path'] = $this->uploadfiles($file, $folder);
            }
            $insuranceClaim->update($data);
            if ($file)
                $this->removePublicFile($old_file_path);
            DB::commit();
            return $this->sendResponse(true, getMessageText('insert'));
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->sendError(getMessageText('insert', false));
        }
    }

    public function claimStatusChange(ClaimStatusChangeRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $validatedData = $request->validated();
            $claims = InsuranceClaim::with('member')->where('member_id', $validatedData['member_id'])
                ->where('claim_id', $validatedData['claim_id'])
                ->where('relative_id', $validatedData['relative_id'])
                ->whereIn('status', [InsuranceClaim::STATUS_REGISTERED, InsuranceClaim::STATUS_SCRUNITY, InsuranceClaim::STATUS_VERIFIED])
                ->get();
            if ($claims->count() > 0) {
                $column = 'status';
                if ($validatedData['type'] == 'document_correction') {
                    $validatedData['type'] = InsuranceClaim::STATUS_DOCUMENT_CORRECTION;
                } else if ($validatedData['type'] == 'hold') {
                    $column = 'is_hold';
                    $validatedData['type'] = 'Y';
                } else if ($validatedData['type'] == 'release') {
                    $column = 'is_hold';
                    $validatedData['type'] = 'N';
                } else if ($validatedData['type'] == 'resubmission') {
                    $validatedData['type'] = InsuranceClaim::STATUS_RESUBMISSION;
                } else {
                    $validatedData['type'] = InsuranceClaim::STATUS_REJECTED;
                }
                foreach ($claims as $claim) {
                    $claim->update([$column => $validatedData['type']]);
                }
                $current_user = getUserDetail();
                $firstClaim = $claims[0];
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
                if ($column = 'is_hold' && $validatedData['type'] == 'Y') {
                    $message = 'The claim is on hold for Claim ID: ' . $claimIdName . '.';
                } else if ($column = 'is_hold' && $validatedData['type'] == 'N') {
                    $message = 'The claim has been released from hold for Claim ID: ' . $claimIdName . '.';
                } else {
                    $message = 'The claim status has been changed to ' . $validatedData['type'] . ' for Claim ID: ' . $claimIdName . '.';
                }
                $uniqueArray = array_unique(array_values(array_diff($userIds, [$current_user->id])));
                $redirect_url = str_replace(url('/'), '', route('claim.list')) . '?claim_id=' . $claimIdName;

                storeNotification('Claim', $uniqueArray, $message, $redirect_url);
                return $this->sendResponse(true, getMessageText('update'));
            } else {
                return $this->sendError('No Claims Found');
            }
        });
    }
    public function getClaimIdDatas($claim_id)
    {
        $user = getUserDetail();
        $insuranceClaim = InsuranceClaim::with([
            'group.policy',
            'logs' => function ($q) {
                $q->where('type', InsuranceClaim::STATUS_RESUBMISSION)->latest();
            }
        ])
            ->select("insurance_claims.*", "insurance_headings.name as insurance_heading_name", "insurance_sub_headings.name as insurance_sub_heading_name")
            ->join("insurance_headings", "insurance_claims.heading_id", "insurance_headings.id")
            ->join("insurance_sub_headings", "insurance_claims.sub_heading_id", "insurance_sub_headings.id")
            ->where('insurance_claims.claim_id', $claim_id)
            ->where('insurance_claims.status', InsuranceClaim::STATUS_RESUBMISSION)
            ->when($user, function ($q) use ($user) {
                if ($user->rolecode === 'HR') {
                    $q->whereHas('member', function ($q1) use ($user) {
                        $q1->where('insurance_claims.client_id', $user->client_id);
                    });
                } elseif ($user->rolecode == 'MB') {
                    $q->where('insurance_claims.member_id', $user->member_id);
                }
            })
            ->get();
        if (count($insuranceClaim) > 0) {
            $record = $insuranceClaim[0];
            $memberId = $record->member_id;
            $relative_id = $record->relative_id;
            $otherDetails = Member::where('id', $memberId)
                ->with([
                    'currentMemberPolicy.group.headings',
                    'companyPolicies',
                    'user',
                    'relatives' => function ($query) use ($relative_id) {
                        $query->where('id', $relative_id);
                    },
                ])->first();
            if (is_null($otherDetails)) {
                return $this->sendError('Member not found');
            }

            if (is_null($otherDetails->companyPolicies->first())) {
                return $this->sendError('Company policy has not been created');
            }
            $type = null;
            if ($relative_id) {
                $dependent = isset($otherDetails?->relatives[0]) ? $otherDetails?->relatives[0] : null;
                switch ($dependent->rel_relation) {
                    case 'father':
                    case 'mother':
                    case 'mother-in-law':
                    case 'father-in-law':
                        $type = 'is_parent';
                        break;
                    case 'child1':
                    case 'child2':
                        $type = 'is_child';
                        break;
                    case 'spouse':
                        $type = 'is_spouse';
                        break;
                    default:
                        break;
                }
            }
            $claimPolicy = $record?->group?->policy;
            $policy_no = $claimPolicy?->policy_no;
            $issue_date = $claimPolicy?->issue_date;
            $imitation_days = $claimPolicy?->imitation_days;
            $end_date = null;
            if ($issue_date && $imitation_days) {
                $parsedIssueDate = Carbon::now()->startOfDay();
                $end_date = $parsedIssueDate->addDays($imitation_days)->toDateString();
            }

            $user = $record->member;
            $memberPolicy =
                $user?->allMemberPolicy?->where('group_id', $record->group_id)->first() ?? collect();
            $memberGroup = $memberPolicy?->group;
            if ($type && $relative_id) {
                $allheadings = $memberGroup->headings->where($type, 'Y');
            } else {
                $allheadings = $memberGroup->headings;
            }
            $data = [
                'insuranceClaim' => $insuranceClaim,
                'headings' => $allheadings,
                'details' => [
                    'member_id' => $otherDetails->id,
                    'relative_id' => $relative_id,
                    'member_name' => $otherDetails?->user?->fname . ' ' . $otherDetails?->user?->mname . ' ' . $otherDetails?->user?->lname,
                    'relative_name' => isset($otherDetails?->relatives[0]) ? $otherDetails?->relatives[0]?->rel_name : null,
                    'relative_relation' => isset($otherDetails?->relatives[0]) ? $otherDetails?->relatives[0]?->rel_relation : null,
                    'designation' => $otherDetails->designation,
                    'branch' => $otherDetails->branch,
                    'expiry_date' => $otherDetails->companyPolicies[0]?->valid_date,
                    'policy_no' => $policy_no,
                    'issue_date' => $issue_date,
                    'imitation_days' => $imitation_days,
                    'end_date' => $end_date,
                    'reason' => isset($record->logs[0]) ? $record->logs[0]?->remarks : null,
                ],

            ];
            foreach ($allheadings as $key => $heading) {
                $groupPackageHeadingId = $heading->id;
                $headingData = $heading->heading;
                $headingId = $headingData->id;
                $headingName = $headingData->name;
                $insurancedAmount = $heading->amount;
                if ($memberGroup?->is_amount_different !== 'Y') {
                    $insurancedAmount = $heading->amount;
                } else {
                    if ($record->relative_id) {
                        $amountColumn = $type . '_amount';
                        $insurancedAmount = $heading->$amountColumn;
                    } else {
                        $insurancedAmount = $heading->amount;
                    }
                }
                $claimedAmount = claimedAmount($memberId, $groupPackageHeadingId, $headingId, $relative_id);

                $data['policy'][] = [
                    'heading_id' => $headingId,
                    'heading_name' => $headingName,
                    'insuranced_amount' => $insurancedAmount,
                    'claimed_amount' => $claimedAmount ?? 0,
                ];
            }
            return $this->sendResponse($data, "");
        } else {
            return $this->sendError("Claim not found");
        }
    }
    public function storeResubmission(ClaimResubmissionStoreRequest $request)
    {
        // $accessCheck = $this->checkAccess($this->accessCheck('members'), 'isinsert');
        // if ($accessCheck && $accessCheck['status'] == false) {
        //     return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        // }
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            $folder = 'uploads/claim';

            $claimId = $request->claim_id;
            $claims = InsuranceClaim::where('claim_id', $request->claim_id)
                ->where('status', InsuranceClaim::STATUS_RESUBMISSION)
                ->get();
            $claimDetails = $claims[0];
            $submission_count = ++$claimDetails->submission_count;
            foreach ($validatedData['heading_id'] as $key => $heading) {
                $file = $validatedData['bill_file'][$key];
                $filename = $this->uploadfiles($file, $folder);
                $data = [
                    'member_id' => $validatedData['member_id'],
                    'heading_id' => $heading,
                    'group_id' => $claimDetails->group_id,
                    'submission_count' => $submission_count,
                    'register_no' => $claimDetails->register_no,
                    'is_hold' => $claimDetails->is_hold,
                    'scrutiny_id' => $claimDetails->scrutiny_id,
                    'sub_heading_id' => $validatedData['sub_heading_id'][$key],
                    'relative_id' => $validatedData['relative_id'] ?? null,
                    'claim_for' => $validatedData['relative_id'] ? 'other' : 'self',
                    'document_type' => $validatedData['document_type'][$key],
                    'bill_file_name' => $validatedData['bill_file_name'][$key],
                    'bill_file_size' => $validatedData['bill_file_size'][$key],
                    'file_path' => $filename,
                    'status' => InsuranceClaim::STATUS_REGISTERED,
                    'claim_id' => $claimId,
                    'document_date' => $validatedData['document_date'][$key],
                    'remark' => $validatedData['remark'][$key] ?? '',
                    'bill_amount' => $validatedData['bill_amount'][$key],
                    'clinical_facility_name' => $validatedData['clinical_facility_name'][$key] ?? '',
                    'diagnosis_treatment' => $validatedData['diagnosis_treatment'][$key] ?? '',
                    'clam_type' => $validatedData['save_type'] ?? 'draft',
                ];
                InsuranceClaim::create($data);
            }
            foreach ($claims as $claim) {
                $claim->update([
                    'status' => InsuranceClaim::STATUS_REGISTERED,
                    'submission_count' => $submission_count
                ]);
            }
            $current_user = getUserDetail();
            $firstClaim = $claims[0];
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
            $message = 'The claim has been resubmitted for Claim ID: ' . $claimIdName . '.';
            storeNotification('Claim', $uniqueArray, $message, $redirect_url);
            DB::commit();
            return $this->sendResponse(true, 'Your Claims have been re-submitted successfully, Your Claim id is ' . $claimId);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->sendError(getMessageText('insert', false));
        }
    }
    public function getClaimidConfirmView(Request $request)
    {
        $data['request'] = $request->all();
        $data['member'] = Member::with([
            'user',
            'client',
            'allMemberPolicy' => function ($q) use ($request) {
                $q->whereHas("companyPolicy", function ($q2) use ($request) {
                    $q2->where('policy_no', $request->policy_no);
                });
            },
            'relatives' => function ($q) use ($request) {
                $q->where('id', $request->relative_id);
            },
        ])
            ->whereHas('allMemberPolicy', function ($q) use ($request) {
                $q->whereHas("companyPolicy", function ($q2) use ($request) {
                    $q2->where('policy_no', $request->policy_no);
                });
            })
            ->when($request->relative_id, function ($q4) use ($request) {

                $q4->whereHas('relatives', function ($q) use ($request) {
                    $q->where('id', $request->relative_id);
                });
            })
            ->where('id', $request->member_id)
            ->first();
        $view = view('backend.claimsubmission.claim_form', $data);
        return $this->sendResponse($view->render(), 'View Loaded Sucessfully.');
    }
}
