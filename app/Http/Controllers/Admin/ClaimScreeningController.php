<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ScrunityStoreRequest;
use App\Http\Requests\StoreInsuranceRegisterRequest;
use App\Models\ClaimRegister;
use App\Models\Client;
use App\Models\CompanyPolicy;
use App\Models\Group;
use App\Models\InsuranceClaim;
use App\Models\InsuranceHeading;
use App\Models\InsuranceLot;
use App\Models\Member;
use App\Models\MemberPolicy;
use App\Models\Scrunity;
use App\Models\ScrunityDetail;
use App\Models\User;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables as DataTablesDataTables;

class ClaimScreeningController extends BaseController
{
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $access = $this->accessCheck('claimscreening');
        $data['access'] = $access;
        if ($request->ajax()) {
            $claims = InsuranceClaim::with([
                'heading:id,name',
                'claimRegister',
                'member.memberPolicy' => function ($query) use ($request) {
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
                ->whereNotNull('register_no')
                ->where(function ($q) {
                    $q->where('status', InsuranceClaim::STATUS_REGISTERED)
                        ->orWhere(function ($q1) {
                            $q1->where('status', InsuranceClaim::STATUS_SCRUNITY)
                                ->whereHas('scrunity', function ($query) {
                                    $query->where('status', Scrunity::STATUS_DRAFT);
                                })
                            ;
                        });
                })
                ->when(!is_null($request->claim_no), function ($q) use ($request) {
                    $q->whereHas('claimRegister', function ($q) use ($request) {
                        $q->where('id', $request->claim_no);
                    });
                })
                ->when(!is_null($request->status), function ($q) use ($request) {
                    $q->where('status', ($request->status == 'Pending' ? null : $request->status));
                })
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
                ->get();
            $filtered_claims = [];
            foreach ($claims->groupBy(function ($item) {
                return $item->claim_id;
            }) as $key => $grouped_claims
            ) {
                $new_claim = $grouped_claims->first();
                $new_claim->bill_amount = numberFormatter($grouped_claims->sum('bill_amount')) ;
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
                    $btn = "<a href='javascript:void(0)' class='preview btn btn-secondary btn-sm previewData' data-claim_id='" . $row->claim_id . "' data-pid='" . $row->member_id . "' data-relative_id='" . $row->relative_id . "' data-url=" . route('claimsubmissions.show', "$row->id") . "><i class='fas fa-eye'></i> </a>";

                    $btn .= "<br><a href='javascript:void(0)' class='btn btn-success btn-sm scrutinyBtn' data-claim_id='" . $row->claim_id . "' data-pid='" . $row?->member->id . "' data-relative_id='" . $row->relative_id . "' ><i class='fas fa-file-medical-alt'></i> </a>";
                    return $btn;
                })
                ->addColumn('full_name', function ($row) {
                    return $row->fname . ' ' . $row->lname;
                })

                ->rawColumns(['action', 'is_active'])
                ->make(true);
        }
        $data['title'] = 'Claim Screening';
        $data['extraCss'] = commonDatatableFiles('css');
        $data['extraJs'] = commonDatatableFiles();
        $data['extraCss'][] = 'admin/cdns/select2-bootstrap-5/dist/select2-bootstrap-5-theme.min.css';
        $data['extraCss'][] = 'admin/cdns/select2@4.1/dist/css/select2.min.css';
        $data['extraJs'][] = 'admin/cdns/select2@4.1/dist/js/select2.min.js';
        $data['headings'] = InsuranceHeading::where('status', 'Y')->orderBy('name', 'asc')->get(['id', 'name']);
        $data['groups'] = Group::get();
        $data['clients'] = Client::get(['id', 'name']);
        return view('backend.claimscreening.list', $data);
    }

    public function oldindex(Request $request)
    {
        $access = $this->accessCheck('claimscreening');
        $data['access'] = $access;
        if ($request->ajax()) {
            // dump($request->all());
            $members = Member::whereHas('insuranceClaim', function ($q) use ($request) {
                $q->whereNull('register_no')
                    // ->where('lot_no', $request->lot_id)
                    ->when($request->has('heading_id') && !is_null($request->heading_id), function ($query) use ($request) {
                        $query->where('heading_id', $request->heading_id);
                    });
            })->whereHas('memberPolicy', function ($q) use ($request) {
                $q->where('group_id', $request->group_id);
            })
                ->with(['insuranceClaim', 'memberPolicy', 'user'])

                ->get();
            // dd($members);
            return Datatables::of($members)
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
                ->addColumn('action', function ($row) {
                    $btn = '';
                    $btn = "<a href='javascript:void(0)' class='preview btn btn-secondary btn-sm previewData' data-pid='" . $row->id . "' data-url=" . route('claimsubmissions.show', "$row->id") . "><i class='fas fa-eye'></i> </a>";

                    $btn .= "<br><a href='javascript:void(0)' class='btn btn-success btn-sm scrutinyBtn' data-pid='" . $row->id . "' ><i class='fas fa-file-medical-alt'></i> </a>";
                    return $btn;
                })
                ->addColumn('full_name', function ($row) {
                    return $row->fname . ' ' . $row->lname;
                })

                ->rawColumns(['action', 'is_active'])
                ->make(true);
        }
        $data['title'] = 'Claim Screening';
        $data['extraCss'] = commonDatatableFiles('css');
        $data['extraJs'] = commonDatatableFiles();
        $data['extraCss'][] = 'admin/cdns/select2-bootstrap-5/dist/select2-bootstrap-5-theme.min.css';
        $data['extraCss'][] = 'admin/cdns/select2@4.1/dist/css/select2.min.css';
        $data['extraJs'][] = 'admin/cdns/select2@4.1/dist/js/select2.min.js';
        $data['headings'] = InsuranceHeading::where('status', 'Y')->orderBy('name', 'asc')->get(['id', 'name']);
        $data['groups'] = Group::get();
        $data['clients'] = Client::get(['id', 'name']);
        return view('backend.claimscreening.list', $data);
    }

    public function getLots(Request $request)
    {
        $claims = InsuranceLot::whereHas('claims', function ($q) use ($request) {
            $q
                ->when($request->has('heading_id') && !is_null($request->heading_id), function ($query) use ($request) {
                    $query->where('heading_id', $request->heading_id);
                })
                ->when($request->has('to_date') && !is_null($request->to_date), function ($query) use ($request) {
                    $query->where('document_date', '<=', $request->to_date);
                })
                ->when($request->has('from_date') && !is_null($request->from_date), function ($query) use ($request) {
                    $query->where('document_date', '>=', $request->from_date);
                })->whereHas('member', function ($query) use ($request) {
                    $query->where('group_id', $request->group_id)->where('client_id', $request->client_id);
                })
                ->when($request->has('type') && !is_null($request->type), function ($query) use ($request) {
                    if ($request->type == 'registered') {
                        $query->whereNotNull('register_no')
                            ->where(function ($q) {
                                $q->where('status', InsuranceClaim::STATUS_REGISTERED)
                                    ->orWhere(function ($q1) {
                                        $q1->where('status', InsuranceClaim::STATUS_SCRUNITY)
                                            ->whereHas('scrunity', function ($query) {
                                                $query->where('status', Scrunity::STATUS_DRAFT);
                                            })
                                        ;
                                    });
                            });
                    } elseif ($request->type == 'scrunity') {
                        $query->where('status', InsuranceClaim::STATUS_SCRUNITY)
                            ->whereHas('scrunity', function ($query) {
                                $query->where('status', '!=', Scrunity::STATUS_DRAFT);
                            })
                            ->whereNotNull('register_no');
                    } elseif ($request->type == 'verified') {
                        $query->where('status', InsuranceClaim::STATUS_VERIFIED)->whereNotNull('register_no');
                    } elseif ($request->type == 'received') {
                        $query->where('status', InsuranceClaim::STATUS_RECEIVED)->whereNull('register_no');
                    } else {
                        $query->where('status', $request->type);
                        # code...
                    }
                });
        })
            ->where('group_id', $request->group_id)
            ->where('client_id', $request->client_id)
            ->get(['id']);

        if ($claims) {
            return $this->sendResponse($claims, getMessageText('fetch'));
        } else {
            return $this->sendError(getMessageText('fetch', false));
        }
    }
    public function getClaims(Request $request)
    {
        $access = $this->accessCheck('claimscrutiny');
        $memberCurrentId = $request->member_id;
        $claims = InsuranceClaim::where('member_id', $memberCurrentId)
            ->when($request->has('relative_id') && !is_null($request->relative_id), function ($q) use ($request) {
                $q->where('relative_id', $request->relative_id);
            })->where('claim_id', $request->claim_id)
            ->when(is_null($request->relative_id), function ($q) {
                $q->whereNull('relative_id');
            })->where(function ($q) use ($request) {
                if ($request->type == 'screening') {
                    $q->where('status', InsuranceClaim::STATUS_REGISTERED)
                        ->orWhere(function ($q1) {
                            $q1->where('status', InsuranceClaim::STATUS_SCRUNITY)
                                ->whereHas('scrunity', function ($query) {
                                    $query->where('status', Scrunity::STATUS_DRAFT);
                                })
                            ;
                        });
                } elseif ($request->type == 'verification') {

                    $q->where('status', InsuranceClaim::STATUS_SCRUNITY);
                } elseif ($request->type == 'approval') {
                    $q->where('status', InsuranceClaim::STATUS_VERIFIED);
                } else {
                    $q->where('status', InsuranceClaim::STATUS_SCRUNITY);
                }

            })

            ->whereNotNull('register_no')
            ->with([
                'member.user',
                'member.client.policies',
                'member.currentMemberPolicy',
                'member.currentMemberPolicy.group.headings.heading',
                'relative',
                'scrunity.details.insuranceHeading',
                'logs' => function ($q) {
                    $q->where('type', InsuranceClaim::STATUS_REGISTERED)->latest();
                },
                'claimNote'
            ])->orderBy('id')
            ->get();
            // dd($claims);
        $firstClaim = $claims[0];
        $relative_type = null;
        $headings = InsuranceHeading::whereHas('group_heading', function ($q) use ($firstClaim, &$relative_type) {
            $q->where('group_id', $firstClaim->group_id)
                ->when(!is_null($firstClaim->relative_id), function ($q) use ($firstClaim, &$relative_type) {
                    $type = null;
                    switch ($firstClaim?->relative?->rel_relation) {
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
                    $relative_type = $type;
                    $q->where($type, 'Y');
                });
        })->get(['id', 'name']);
        $html = '';
        $type = $request->type;
        if ($claims) {
            $html = view('backend.claimscreening.data', compact('claims', 'headings', 'access', 'memberCurrentId', 'type', 'relative_type'))->render();
            $data = [
                'claims' => $claims,
                'html' => $html,
            ];
        }

        if ($claims) {
            return $this->sendResponse($data, getMessageText('fetch'));
        } else {
            return $this->sendError(getMessageText('fetch', false));
        }
    }

    public function store(ScrunityStoreRequest $request)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('claimscrutiny'), 'isinsert');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            $member = Member::where('id', $validatedData['member_id'])->with(['group.headings'])->first();
            $memberPolicy = MemberPolicy::where('member_id', $validatedData['member_id'])
                ->where('is_current', 'Y')->first();
            $relative_id = $validatedData['relative_id'] ?? null;
            $claim_no_id = InsuranceClaim::where('claim_id', $request->claim_id)->first()->register_no;
            $scrunityData = [
                // 'lot_id' => $validatedData['lot_id'],
                'claim_no_id' => $claim_no_id,
                'member_id' => $validatedData['member_id'],
                'relative_id' => $relative_id,
                'member_policy_id' => $memberPolicy->id,
                'status' => $request->status == 'draft' ? Scrunity::STATUS_DRAFT : Scrunity::STATUS_REQUEST
            ];
            if ($validatedData['scrunity_id']) {
                $scrunity = Scrunity::updateOrCreate(
                    ['id' => $validatedData['scrunity_id']], // Find by this criteria
                    $scrunityData // Update with this data if found
                );
            } else {
                $scrunity = Scrunity::create($scrunityData); // Create new record with this data
            }
            $folder = 'uploads/scrunity';
            foreach ($validatedData['heading_id'] as $k => $heading_id) {
                $scrunityDetailsData = [
                    'scrunity_id' => $scrunity->id,
                    'group_heading_id' => $member->memberPolicy->group->headings->where('heading_id', $heading_id)->first()->id,
                    'heading_id' => $heading_id,
                    'bill_amount' => $validatedData['bill_amount'][$k],
                    'approved_amount' => $validatedData['approved_amount'][$k],
                    'deduct_amount' => $validatedData['bill_amount'][$k] - $validatedData['approved_amount'][$k],
                    'bill_no' => $validatedData['bill_no'][$k],
                    'remarks' => $validatedData['remarks'][$k],
                ];
                if (!isset($validatedData['scrunity_details_ids'][$k])) {
                    $scrunityDetailsData['file'] = null;
                }
                if (isset($validatedData['scrunity_files'][$k]) && $validatedData['scrunity_files'][$k] !== null && $validatedData['scrunity_files'][$k] != "null") {
                    $file = $validatedData['scrunity_files'][$k];
                    $filename = $this->uploadfiles($file, $folder);
                    $scrunityDetailsData['file'] = $filename;
                }
                if ($validatedData['scrunity_details_ids'][$k]) {
                    ScrunityDetail::updateOrCreate(
                        ['id' => $validatedData['scrunity_details_ids'][$k]], // Find by this criteria
                        $scrunityDetailsData // Update with this data if found
                    );
                } else {
                    ScrunityDetail::create($scrunityDetailsData); // Create new record with this data
                }
            }
            $allClaims = InsuranceClaim::where('member_id', $validatedData['member_id'])
                // ->where('lot_no', $validatedData['lot_id'])
                ->where('status', InsuranceClaim::STATUS_REGISTERED)
                ->where('claim_id', $request->claim_id)
                ->where(function ($q) use ($request) {
                    if ($request->has('relative_id') && !is_null($request->relative_id)) {
                        $q->where('relative_id', $request->relative_id);
                    } else {
                        $q->whereNull('relative_id');
                    }
                })
                ->whereNotNull('register_no')
                ->get();
            foreach ($allClaims as $claim) {
                $claim->update([
                    'status' => InsuranceClaim::STATUS_SCRUNITY,
                    'scrutiny_id' => $scrunity->id
                ]);
            }
            if ($request->status !== 'draft') {
                $current_user = getUserDetail();
                $claimIdName = $claim_no_id;
                $claimUserClientId = $member?->client_id;
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
                $message = 'The claim status has been changed to ' . InsuranceClaim::STATUS_SCRUNITY . ' for Claim ID: ' . $claimIdName . '.';
                storeNotification('Claim', $uniqueArray, $message, $redirect_url);
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->sendError(getMessageText('insert', false));
        }
        DB::commit();
        return $this->sendResponse(true, getMessageText('insert'));
    }

    public function settleClaims(Request $request)
    {
        $scrunity = Scrunity::
            // where('lot_id', $request->lot_id)->
            where('member_id', $request->member_id)
            ->when($request->has('relative_id') && !is_null($request->relative_id), function ($q) use ($request) {
                $q->where('relative_id', $request->relative_id);
            })->with(['details.group_package'])->first();
        dd($scrunity);
    }

    public function getInsuranceClaimsOfMember(Request $request)
    {
        $claims = InsuranceClaim::with([
            'heading:id,name',
            'member.memberPolicy' => function ($query) use ($request) {
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
            ->where('member_id', $request->member_id)
            ->where('claim_id', $request->claim_ids)
            ->when($request->has('type') && !is_null($request->type), function ($q) use ($request) {
                if ($request->type == 'register') {
                    $q->whereNull('register_no')
                        ->where('status', InsuranceClaim::STATUS_RECEIVED);
                } else if ($request->type == 'screening') {
                    $q->whereNotNull('register_no')
                        ->where('status', InsuranceClaim::STATUS_REGISTERED);
                } else if ($request->type == 'verification') {
                    $q->whereNotNull('register_no')->whereNotNull('scrutiny_id')
                        ->where('status', InsuranceClaim::STATUS_SCRUNITY);
                } else {
                    $q->whereNull('register_no')
                        ->where('status', InsuranceClaim::STATUS_RECEIVED);
                }

            })
            // ->where('relative_id', $request->relative_id)

            ->get();
        // dd($claims);
        // dd($request->status, $request->member_id, $request->relative_id, $request->lot_id, $claims);
        return [
            'status' => true,
            'html' => View::make("backend.claimregistration.preview_modal", [
                "claims" => $claims
            ])->render()
        ];
    }
    public function getClaimId(Request $request)
    {
        $claims = InsuranceClaim::when($request->has('heading_id') && !is_null($request->heading_id), function ($query) use ($request) {
            $query->where('heading_id', $request->heading_id);
        })
            ->when($request->has('to_date') && !is_null($request->to_date), function ($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->to_date);
            })
            ->when($request->has('from_date') && !is_null($request->from_date), function ($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->from_date);
            })->whereHas('member', function ($query) use ($request) {
                $query->where('group_id', $request->group_id)->where('client_id', $request->client_id);
            })
            ->when($request->has('type') && !is_null($request->type), function ($query) use ($request) {
                if ($request->type == 'registered') {
                    $query->whereNotNull('register_no')
                        ->where(function ($q) {
                            $q->where('status', InsuranceClaim::STATUS_REGISTERED)
                                ->orWhere(function ($q1) {
                                    $q1->where('status', InsuranceClaim::STATUS_SCRUNITY)
                                        ->whereHas('scrunity', function ($query) {
                                            $query->where('status', Scrunity::STATUS_DRAFT);
                                        })
                                    ;
                                });
                        });
                } elseif ($request->type == 'scrunity') {
                    $query->where('status', InsuranceClaim::STATUS_SCRUNITY)
                        ->whereHas('scrunity', function ($query) {
                            $query->where('status', '!=', Scrunity::STATUS_DRAFT);
                        })
                        ->whereNotNull('register_no');
                } elseif ($request->type == 'verified') {
                    $query->where('status', InsuranceClaim::STATUS_VERIFIED)->whereNotNull('register_no');
                } elseif ($request->type == 'received') {
                    $query->where('status', InsuranceClaim::STATUS_RECEIVED)->whereNull('register_no');
                } else {
                    $query->where('status', $request->type);
                    # code...
                }
            })
            ->where('group_id', $request->group_id)
            // ->where('client_id', $request->client_id)
            ->when($request->has('client_id') && !is_null($request->client_id), function ($query) use ($request) {
                $query->whereHas('member', function ($q) use ($request) {
                    $q->where('client_id', $request->client_id);
                });
            })
            ->distinct()->pluck('claim_id');

        if ($claims) {
            return $this->sendResponse($claims, getMessageText('fetch'));
        } else {
            return $this->sendError(getMessageText('fetch', false));
        }
    }
    public function claimSlider($claim_id, Request $request)
    {

        $data['title'] = ($request->document_type ?? '') . ' Slider';
        $accessCheck = $this->checkAccess($this->accessCheck('claimscrutiny'), 'isinsert');
        if ($accessCheck && $accessCheck['status'] == false) {
            $data['sliders'] = [];
        } else {
            $data['sliders'] = InsuranceClaim::where('claim_id', $claim_id)
                ->when($request->document_type, function ($q) use ($request) {
                    $q->where('document_type', $request->document_type);
                })
                ->select('file_path', 'document_type', 'bill_file_name')
                ->get()
            ;
        }
        return view('backend.claimscreening.claimslider', $data);
    }
}
