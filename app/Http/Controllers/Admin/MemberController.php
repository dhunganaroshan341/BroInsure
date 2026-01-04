<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MemberReferenceExport;
use App\Http\Requests\MemberStatusChangeRequest;
use App\Models\CompanyPolicy;
use DataTables;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Client;
use App\Models\Member;
use App\Models\District;
use App\Models\Province;
use Illuminate\Support\Arr;
use App\Models\GroupPackage;
use App\Models\MemberDetail;
use App\Models\MemberPolicy;
use Illuminate\Http\Request;
use App\Models\MemberRelative;
use App\Models\MemberAttachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\BaseController;
use App\Http\Requests\MemberImportRequest;
use App\Http\Requests\MemberStoreRequest;
use App\Imports\MemberImport;
use App\Jobs\MemberImportJob;
use App\Models\Group;
use Maatwebsite\Excel\Facades\Excel;

class MemberController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $access = $this->accessCheck('members');
        if ($request->ajax()) {
            $currentUser = getUserDetail();
            $users = Member::select('*')->with(['user', 'details', 'attachments', 'currentMemberPolicy.group', 'client', 'currentMemberPolicy'])->where(function ($q) use ($currentUser) {
                if ($currentUser->rolecode === 'HR') {
                    $q->where('client_id', $currentUser->client_id);
                } elseif ($currentUser->rolecode == 'MB') {
                    $q->where('member_id', $currentUser->member_id);
                }
            })->when(isset($request->type), function ($q) use ($request) {
                if ($request->type == 'individual') {
                    $q->where('type', 'individual');
                } else {
                    $q->where('type', '!=', 'individual');
                }
            })
                ->when($request->member_id, function ($q) use ($request) {
                    $q->where('id', $request->member_id);
                })
                // ->orderBy('id', 'asc')
            ;
            // dd($users->get());
            return Datatables::of($users->get())
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($access) {
                    // dd($row->toJson());
                    $btn = '';
                    $btn .= "<a href='javascript:void(0)' class='view btn btn-warning mx-1 btn-sm viewData' data-pid='" . $row->id . "' data-url=" . route('members.show', "$row->id") . "><i class='fas fa-eye'></i> View</a>";

                    if ($access['isedit'] == 'Y') {
                        // $obj = $row->toArray();
                        // dd($obj);
                        $btn .= "<a href='javascript:void(0)' class='edit btn btn-primary btn-sm editData' data-pid='" . $row->id . "' data-url=" . route('members.edit', "$row->id") . "><i class='fas fa-edit'></i> Edit</a>";
                    }
                    if ($access['isdelete'] == 'Y') {
                        $btn .= "&nbsp;<a href='javascript:void(0)' class='edit btn btn-danger btn-sm deleteData' data-pid='" . $row->id . "' data-url=" . route('members.destroy', "$row->id") . "><i class='fas fa-trash'></i> Delete</a>";
                    }
                    return $btn;
                })
                ->addColumn('group_name', function ($row) {
                    return $row->currentMemberPolicy->group->name;
                })->addColumn('amount', function ($row) {
                    return  numberFormatter($row->currentMemberPolicy->group->insurance_amount);
                })->editColumn('user_id', function ($row) {
                    return $row->user->full_name;
                })->editColumn('client_id', function ($row) {
                    return $row->client->name;
                })
                ->editColumn('is_active', function ($row) use ($access) {
                    $active = '';
                    if ($access['isedit'] == 'Y') {
                        $active = '<div class="form-check form-switch">
                                    <input class="form-check-input isactive" type="checkbox" data-pid="' . $row->id . '"';
                        // Check if $row->is_finised is 'Y' and add 'checked' attribute accordingly
                        $active .= $row->is_active == 'Y' ? ' checked' : '';
                        $active .= '></label></div>';
                    }
                    return $active;
                })
                ->rawColumns(['action', 'group_name', 'amount', 'is_active'])
                ->make(true);
        }
        $data['access'] = $access;
        $data['title'] = 'Members';
        $data['extraCss'] = commonDatatableFiles('css');
        $data['extraJs'] = commonDatatableFiles();
        $data['extraJs'][] = 'admin/assets/common/js/address.js';
        $data['extraCss'][] = 'admin/cdns/select2-bootstrap-5/dist/select2-bootstrap-5-theme.min.css';
        // $data['extraCss'][] ='admin/assets/plugins/multi_steps/style.css';
        $data['extraCss'][] = 'admin/cdns/select2@4.1/dist/css/select2.min.css';
        $data['extraCss'][] = 'admin/assets/css/nepali-datepicker.min.css';
        $data['extraJs'][] = 'admin/assets/js/nepali-datepicker.min.js';
        $data['extraJs'][] = 'admin/cdns/select2@4.1/dist/js/select2.min.js';
        $data['extraJs'][] = 'admin/assets/js/jquery.validate.js';
        $data['extraJs'][] = 'admin/assets/js/jquery.steps.js';
        $data['extraJs'][] = 'admin/assets/plugins/multi_steps/js.js';
        $data['extraCss'][] = 'admin/assets/plugins/multi_steps/style.css';
        $data['provinces'] = Province::get(['id', 'name']);
        $data['districts'] = District::whereHas('province', function ($q) {
            $q->where('country_id', 149);
        })->get(['id', 'name']);
        $data['relations'] = MemberRelative::RELATION_TYPES;
        $data['individualPolicies'] = CompanyPolicy::where('client_id', 1)->get(['id', 'policy_no']);
        $data['clients'] = Client::withoutGlobalScopes()->whereNull('archived_at')->get(['id', 'name']);
        return view('backend.member.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MemberStoreRequest $request)
    {

        $accessCheck = $this->checkAccess($this->accessCheck('members'), 'isinsert');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        // dd($request->all());
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            // dd('sadfkjskdafj');
            $personal = $validatedData['personal'];
            $address = $request->member_type == 'individual' ? $validatedData['address'] : null;
            $policy = $validatedData['policy'];

            $personalData = $request->member_type == 'individual' ? array_merge($address, $personal) : $personal;
            // dd($personalData);
            $pass = $personalData['first_name'] . '@123';
            // dd($personalData['first_name']);
            $user = User::create([
                'fname' => $personalData['first_name'],
                'mname' => $personalData['middle_name'],
                'lname' => $personalData['last_name'],
                'email' => $personalData['email'],
                'mobilenumber' => $request->member_type == 'individual' ? $personalData['mobile_number'] : null,
                'usertype' => $policy['type'] === 'hr' ? 3 : 2,
                'password' => bcrypt($pass),
            ]);
            // dd($personalData, $user);
            $personalData['client_id'] = isset($personalData['client_id']) && !is_null($personalData['client_id']) ? $personalData['client_id'] : 1;
            $personalData['is_address_same'] = isset($personalData['is_address_same']) && !is_null($personalData['is_address_same']) ? 'Y' : 'N';
            $personalData['user_id'] = $user->id;
            $personalData['type'] = $policy['type'] === 'hr' || $policy['type'] === 'member' ? ($policy['type'] === 'hr' ? 'hr' : 'member') : 'individual';
            $memberData = Arr::except($personalData, ['first_name', 'middle_name', 'last_name']);
            // dd($memberData);
            $member = Member::create($memberData);
            if ($request->member_type == 'individual') {
                # code...
                $citizenship = $request->citizenship;
                $citizenship['member_id'] = $member->id;
                MemberDetail::create($citizenship);
            }
            if ($request->has('rel_relation')) {
                foreach ($request->rel_relation as $key => $relation) {
                    if ($relation) {
                        MemberRelative::create([
                            'member_id' => $member->id,
                            'rel_relation' => $relation,
                            'rel_name' => $request->rel_name[$key],
                            'rel_gender' => $request->rel_gender[$key],
                            'rel_dob' => $request->rel_dob[$key],
                        ]);
                    }
                }
            }

            if ($request->has('attachments')) {
                foreach ($request->attachments as $key => $file) {
                    if ($file instanceof UploadedFile && $file->isValid()) {
                        $folder = 'admin/uploads/member/attachments';
                        $filename = $this->uploadfiles($file, $folder);
                        MemberAttachment::create([
                            'member_id' => $member->id,
                            'attachment_name' => $request->attachment_name[$key],
                            'file_name' => $filename
                        ]);
                    }
                }
            }

            $policy['member_id'] = $member->id;
            $policy['policy_id'] = Group::where('id', $policy['group_id'])->first()->policy_id;
            $policy['policy_id'] = $policy['policy_id'];

            if ($request->member_type == 'individual') {
                $companypolicy = CompanyPolicy::where('id', $policy['policy_id'])->with(['client'])->first();
                $policy['issue_date'] = $policy['start_date'];
                $date = Carbon::createFromDate($policy['start_date']);
                $policy['valid_date'] = $companypolicy->valid_date;
                $policy['imitation_days'] = $companypolicy->imitation_days;
                $policy['colling_period'] = $companypolicy->colling_period;
                $policy['individual_policy_no'] = substr($companypolicy->client->name, 0, 3) . '-' . Member::where('client_id', $companypolicy->client_id)->count() + 1;
                $policy['end_date'] = $companypolicy->valid_date_type != 'month' ? ($date->addYears($companypolicy->valid_date_type)) : ($date->addMonths(6));
            }
            $policy['is_current'] = 'Y';
            unset($policy['type']);
            MemberPolicy::create($policy);
            $current_user = getUserDetail();
            $memberID = $member->id;
            $claimUserClientId = $member?->client_id;
            $clientName = $member?->client?->name;
            $memberType = $personalData['type'];
            if ($memberType == 'individual') {
                $redirect_url = str_replace(url('/'), '', route('members.index')) . '?member_id=' . $memberID;
            } else {
                $redirect_url = str_replace(url('/'), '', route('member-groups.index')) . '?member_id=' . $memberID;
            }
            $userIds = User::where(function ($q) use ($claimUserClientId, $memberType) {
                // Users who do not have a member
                $q->whereDoesntHave('member');
                if ($memberType !== 'individual') {
                    // Or users who have a member that meets the conditions
                    $q->orWhereHas('member', function ($q) use ($claimUserClientId) {
                        $q->where('client_id', $claimUserClientId)
                            ->where('type', '!=', 'member');
                    });
                }
            })
                ->pluck('id')
                ->toArray();

            $uniqueArray = array_unique(array_values(array_diff($userIds, [$current_user->id])));

            $message = 'The member has been added to the client: ' . $clientName . ' with Member ID: ' . $memberID . '.';
            storeNotification('Member', $uniqueArray, $message, $redirect_url);
            DB::commit();
            return $this->sendResponse(true, getMessageText('insert'));
        } catch (\Exception $e) {
            // dd('here');
            DB::rollback();
            Log::error($e);
            return $this->sendError(getMessageText('insert', false));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $member = Member::where('id', $id)->with(['relatives', 'attachments', 'details', 'user', 'client', 'currentMemberPolicy', 'presentProvince', 'presentDistrict', 'presentCity', 'permProvince', 'permDistrict', 'permCity'])->first();
        $data['personal'] = [
            "first_name" => $member->user->fname,
            "middle_name" => $member->user->mname,
            "last_name" => $member->user->lname,
            "date_of_birth_ad" => $member->date_of_birth_ad,
            "date_of_birth_bs" => $member->date_of_birth_bs,
            "marital_status" => $member->marital_status,
            "gender" => $member->gender,
            "mail_address" => $member->mail_address,
            "phone_number" => $member->phone_number,
            "employee_id" => $member->employee_id,
            "branch" => $member->branch,
            "designation" => $member->designation,
            "date_of_join" => $member->date_of_join,
            "mobile_number" => $member->mobile_number,
            "email" => $member->email,
            "nationality" => $member->nationality,
        ];
        // dd( $member->permProvince,$member->permCity);
        $data['address'] = [
            "perm_province" => $member->permProvince?->name,
            "perm_district" => $member->permDistrict?->name,
            "perm_city" => $member->permCity?->name,
            "perm_ward_no" => $member->perm_ward_no,
            "perm_street" => $member->perm_street,
            "perm_house_no" => $member->perm_house_no,
            "is_address_same" => $member->is_address_same,
            "present_province" => $member->presentProvince?->name,
            "present_district" => $member->presentDistrict?->name,
            "present_city" => $member->presentCity?->name,
            "present_ward_no" => $member->present_ward_no,
            "present_street" => $member->present_street,
            "present_house_no" => $member->present_house_no,
        ];
        $data['relatives'] = $member->relatives;
        $data['details'] = [
            'citizenship_no' => $member->details?->citizenship_no,
            'citizenship_issued_date' => $member->details?->citizenship_issued_date,
            'issued_district' => $member->details?->citizenshipDistrict->name,
            'income_source' => $member->details?->income_source,
            'occupation' => $member->details?->occupation,
            'occupation_other' => $member->details?->occupation_other,
        ];
        $data['attachments'] = $member->attachments;
        $data['policy'] = [
            'client' => $member->client?->name,
            'group' => $member->currentMemberPolicy?->group->name,
            'type' => $member->type,
        ];
        // dd($data['attachments']);
        if ($data) {
            return $this->sendResponse($data, getMessageText('fetch'));
        } else {
            return $this->sendError(getMessageText('fetch', false));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('members'), 'isedit');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        $group = Member::with(['user', 'attachments', 'details', 'currentMemberPolicy'])->find($id);
        $old_relations_html = View::make("backend.member.individual.old_dependent_list", ["relations" => $group->relatives])->render();
        if ($group) {
            return $this->sendResponse([
                "member" => $group,
                "old_relations_html" => $old_relations_html
            ], getMessageText('fetch'));
        } else {
            return $this->sendError(getMessageText('fetch', false));
        }
    }

    public function update(MemberStoreRequest $request, Member $member)
    {

        // dd($request->all());
        // dd($member);
        $accessCheck = $this->checkAccess($this->accessCheck('members'), 'isinsert');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        // try {
        DB::beginTransaction();
        $validatedData = $request->validated();
        // dd('sadfkjskdafj');
        $personal = $validatedData['personal'];
        $address = $request->member_type == 'individual' ? $validatedData['address'] : null;
        // dd($personal,$address);
        $policy = $validatedData['policy'];
        $personalData = $request->member_type == 'individual' ? array_merge($address, $personal) : $personal;
        $pass = $personalData['first_name'] . '@123';
        // dd($personalData['first_name']);
        $user = $member->user;
        $user->update([
            'fname' => $personalData['first_name'],
            'mname' => $personalData['middle_name'],
            'lname' => $personalData['last_name'],
            'email' => $personalData['email'],
            'mobilenumber' => $request->member_type == 'individual' ? $personalData['mobile_number'] : null,
            'usertype' => $policy['type'] === 'hr' ? 3 : 2,
            'password' => bcrypt($pass),
        ]);
        $personalData['client_id'] = isset($personalData['client_id']) && !is_null($personalData['client_id']) ? $personalData['client_id'] : 1;
        $personalData['is_address_same'] = isset($personalData['is_address_same']) && !is_null($personalData['is_address_same']) ? 'Y' : 'N';
        $personalData['user_id'] = $user->id;
        $memberData = Arr::except($personalData, ['first_name', 'middle_name', 'last_name']);
        $personalData['type'] = $policy['type'] === 'hr' ? 'hr' : 'member';
        $member->update($memberData);
        if ($request->member_type == 'individual') {

            $citizenship = $request->citizenship;
            $citizenship['member_id'] = $member->id;
            $member->details->update($citizenship);
        }

        // Delete Old Relations
        $old_relative_ids = $member->relatives->pluck('id');
        // dump($old_relative_ids);
        $new_relative_ids = $request->rel_id;
        // dump($new_relative_ids);
        $ids_to_delete = $old_relative_ids->diff($new_relative_ids);
        // dd($ids_to_delete);
        $member->relatives()->whereIn('id', $ids_to_delete)->delete();
        if ($request->has('rel_relation')) {
            foreach ($request->rel_relation as $key => $relation) {
                if (is_null($relation))
                    continue;
                // dump($request->rel_id[$key]);
                $updateData = [
                    'member_id' => $member->id,
                    'rel_relation' => $relation,
                    'rel_name' => $request->rel_name[$key],
                    'rel_gender' => $request->rel_gender[$key],
                    'rel_dob' => $request->rel_dob[$key],
                ];
                if (($request->rel_id[$key]) ?? false)
                    MemberRelative::query()
                        ->where(['id' => $request->rel_id[$key]])
                        ->update($updateData);
                else
                    MemberRelative::create($updateData);
            }
            // dd('here');

        }

        // Deleting old files
        $old_files_id = $member->attachments->pluck('id');
        $new_files_id = $request->attachment_id;
        $attachment_ids_to_delete = $old_files_id->diff($new_files_id);
        foreach (MemberAttachment::find($attachment_ids_to_delete) as $attachment) {
            $attachment->removeFile('admin/' . $attachment->file_name);
            $attachment->delete();
        }

        // Adding new files
        // if ($request->has('attachments')) {
        if ($request->attachment_name) {
            foreach ($request->attachment_name as $key => $attachment_name) {
                $file = $request->attachments[$key] ?? null;
                if ($file instanceof UploadedFile && $file->isValid()) {
                    // dd(get_class($file));
                    $folder = 'admin/uploads/member/attachments';
                    $filename = $this->uploadfiles($file, $folder);
                    if ($request->attachment_id[$key] ?? false) {
                        $attachment = MemberAttachment::find($request->attachment_id[$key]);
                        $this->removePublicFile('admin' . $attachment->file_name);
                        $attachment->file_name = $filename;
                        $attachment->attachment_name = $request->attachment_name[$key];
                        $attachment->save();
                    } else {
                        MemberAttachment::create([
                            'member_id' => $member->id,
                            'attachment_name' => $request->attachment_name[$key],
                            'file_name' => $filename
                        ]);
                    }
                } else {
                    if ($request->attachment_id[$key] ?? false) {
                        $member_attachment = MemberAttachment::find($request->attachment_id[$key]);
                        $member_attachment->attachment_name = $request->attachment_name[$key];
                        $member_attachment->save();
                    }
                }
            }
        }
        // }
        unset($policy['type']);
        $policy['member_id'] = $member->id;
        // $policy['policy_id'] = Group::where('id', $policy['group_id'])->first()->policy_id;
        // dd($policy,Group::where('id',$policy['group_id'])->first()->id);
        if ($request->member_type == 'individual') {
            $companypolicy = CompanyPolicy::where('id', $policy['policy_id'])->with(['client'])->first();
            $policy['issue_date'] = $policy['start_date'];
            $date = Carbon::createFromDate($policy['start_date']);
            $policy['valid_date'] = $companypolicy->valid_date;
            $policy['imitation_days'] = $companypolicy->imitation_days;
            $policy['individual_policy_no'] = substr($companypolicy->client->name, 0, 3) . '-' . Member::where('client_id', $companypolicy->client_id)->count() + 1;
            $policy['colling_period'] = $companypolicy->colling_period;
            $policy['end_date'] = $companypolicy->valid_date_type != 'month' ? ($date->addYears($companypolicy->valid_date_type)) : ($date->addMonths(6));
        }
        $member->memberPolicy->update($policy);
        $current_user = getUserDetail();
        $memberID = $member->id;
        $claimUserClientId = $member?->client_id;
        $memberType = $request->member_type;
        if ($memberType == 'individual') {
            $redirect_url = str_replace(url('/'), '', route('members.index')) . '?member_id=' . $memberID;
        } else {
            $redirect_url = str_replace(url('/'), '', route('member-groups.index')) . '?member_id=' . $memberID;
        }
        $userIds = User::where(function ($q) use ($claimUserClientId, $memberType) {
            // Users who do not have a member
            $q->whereDoesntHave('member');
            if ($memberType !== 'individual') {
                // Or users who have a member that meets the conditions
                $q->orWhereHas('member', function ($q) use ($claimUserClientId) {
                    $q->where('client_id', $claimUserClientId)
                        ->where('type', '!=', 'member');
                });
            }
        })
            ->pluck('id')
            ->toArray();

        $uniqueArray = array_unique(array_values(array_diff($userIds, [$current_user->id])));
        $message = 'The member has been updated successfully with Member ID: ' . $memberID . '.';
        storeNotification('Member', $uniqueArray, $message, $redirect_url);
        DB::commit();
        return $this->sendResponse(true, getMessageText('insert'));
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     Log::error($e);
        //     return $this->sendError(getMessageText('insert', false));
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('members'), 'isdelete');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        $group = Member::find($id);
        if (!$group) {
            return $this->sendError(getMessageText('delete', false));
        }
        $isdel = $group->delete();
        if ($isdel) {
            return $this->sendResponse(true, getMessageText('delete'));
        } else {
            return $this->sendError(getMessageText('delete', false));
        }
    }

    public function member_claim_details($id, Request $request)
    {
        $relatives = MemberRelative::where('member_id', $id)->get(['id', 'rel_name', 'rel_relation']);

        $otherDetails = Member::where('id', $id)->with([
            'currentMemberPolicy.group.headings',
            'allCompanyPolicies' => function ($query) use ($id) {
                $query->whereHas('memberPolicies', function ($q) use ($id) {
                    $q->where('member_id', $id);
                });
            },
            'currentMemberPolicy.companyPolicy'
        ])->first();
        if (is_null($otherDetails)) {
            return $this->sendError('Member not found');
        }

        if (is_null($otherDetails->allCompanyPolicies->first())) {
            return $this->sendError('Member policy has not been created');
        }
        if ($request->type == 'old') {
            $today = Carbon::today();
            $oldPolicies = $otherDetails?->allCompanyPolicies
                ->filter(function ($policy) use ($today) {
                    $validDate = Carbon::parse($policy->valid_date);
                    $imitationDays = $policy->imitation_days;

                    return $today->greaterThan($validDate) && $today->lessThanOrEqualTo($validDate->copy()->addDays($imitationDays));
                });
            $data = [
                'relatives' => $relatives,
                'details' => [
                    'designation' => $otherDetails->designation,
                    'branch' => $otherDetails->branch,
                ],
                'oldPolicies' => $oldPolicies,
            ];
        } else {
            $policy_no = $otherDetails?->currentMemberPolicy->companyPolicy?->policy_no;
            $issue_date = $otherDetails?->currentMemberPolicy->companyPolicy?->issue_date;
            $imitation_days = $otherDetails->type == 'individual' ? ($otherDetails?->currentMemberPolicy->imitation_days) : $otherDetails?->currentMemberPolicy->companyPolicy?->imitation_days;
            $end_date = null;
            if ($issue_date && $imitation_days) {
                $parsedIssueDate = Carbon::now()->startOfDay();
                $end_date = $parsedIssueDate->addDays($imitation_days)->toDateString();
            }
            $data = [
                'relatives' => $relatives,
                'headings' => $otherDetails->currentMemberPolicy->group->headings,
                // 'currentPolicy'=>$otherDetails->type=='individual'?$otherDetails?->currentMemberPolicy:null,
                'details' => [
                    'id' => $otherDetails->id,
                    'designation' => $otherDetails->designation,
                    'branch' => $otherDetails->branch,
                    // 'expiry_date' => $otherDetails?->currentMemberPolicy?->companyPolicy?->valid_date,
                    'expiry_date' => $otherDetails->type == 'individual' ? $otherDetails->valid_date : $otherDetails?->currentMemberPolicy?->companyPolicy?->valid_date,
                    'policy_no' => $policy_no,
                    'issue_date' => $issue_date,
                    'imitation_days' => $imitation_days,
                    'end_date' => $end_date,
                    'member_type' => $otherDetails->type,
                ],

            ];
            $memberId = $id;
            foreach ($otherDetails->currentMemberPolicy->group->headings as $key => $heading) {
                $groupPackageHeadingId = $heading->id;
                $headingData = $heading->heading;
                $headingId = $headingData->id;
                $headingName = $headingData->name;
                $insurancedAmount = $heading->amount;
                $claimedAmount = claimedAmount($memberId, $groupPackageHeadingId, $headingId);
                $data['policy'][] = [
                    'heading_id' => $headingId,
                    'heading_name' => $headingName,
                    'insuranced_amount' => $insurancedAmount,
                    'claimed_amount' => $claimedAmount ?? 0,
                ];
            }
        }
        if ($relatives) {
            return $this->sendResponse($data, getMessageText('fetch'));
        } else {
            return $this->sendError(getMessageText('fetch', false));
        }
    }
    public function relative_claim_details($id, Request $request)
    {
        $dependent = MemberRelative::where('id', $id)->first();
        $type = null;
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
        $otherDetails = Member::whereHas('relatives', function ($q) use ($id) {
            $q->where('id', $id);
        })->with([
            'currentMemberPolicy.group.headings' => function ($query) use ($type) {
                $query->where($type, 'Y');
            },
            'companyPolicies'
        ])->first();
        if (is_null($otherDetails)) {
            return $this->sendError('Member not found');
        }

        if (is_null($otherDetails->companyPolicies->first())) {
            return $this->sendError('Company policy has not been created');
        }
        if ($request->type == 'old') {
            $groups = collect();
            $data = [];
        } else {
            $groups = $otherDetails->currentMemberPolicy->group;
            $data = [
                'headings' => $groups?->headings,
            ];
            $memberId = $otherDetails->id;
            foreach ($groups?->headings as $key => $heading) {
                $groupPackageHeadingId = $heading->id;
                $headingData = $heading->heading;
                $headingId = $headingData->id;
                $headingName = $headingData->name;
                if ($groups?->is_amount_different !== 'Y') {
                    $insurancedAmount = $heading->amount;
                } else {
                    $amountColumn = $type . '_amount';
                    $insurancedAmount = $heading->$amountColumn;
                }
                // dd($groupPackageHeadingId);
                $claimedAmount = claimedAmount($memberId, $groupPackageHeadingId, $headingId, $dependent->id);
                // dump($claimedAmount,$groupPackageHeadingId );
                $data['policy'][] = [
                    'heading_id' => $headingId,
                    'heading_name' => $headingName,
                    'insuranced_amount' => $insurancedAmount,
                    'claimed_amount' => $claimedAmount ?? 0,
                ];
            }
        }
        return $this->sendResponse($data, getMessageText('fetch'));
        // if ($relatives) {
        // } else {
        //     return $this->sendError(getMessageText('fetch', false));
        // }
    }

    public function reference()
    {
        return Excel::download(new MemberReferenceExport, 'reference.xlsx');
    }
    public function import(MemberImportRequest $request)
    {
        // $request->validate([
        //     'file' => 'required|mimes:xlsx,xls,csv',
        //     'client_id_list' => 'required|exists:clients,id'
        // ]);
        // dd($request->all());
        $accessCheck = $this->checkAccess($this->accessCheck('members'), 'isinsert');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        try {
            // $current_user = getUserDetail();
            Excel::import(new MemberImport, $request->file('file'));
            // dd($export);
            DB::commit();
            // $file=$request->file('file')->store('imports');
            // MemberImportJob::dispatch($file);
            // $uniqueValues = User::whereHas('userType', function ($q) {
            //     $q->whereIn('rolecode', ['SA', 'BK']);
            // })->pluck('id')->toArray();
            // $message =  $current_user->full_name.' Imported Swift transfer.';
            // $redirect_url = str_replace(url('/'), '', route('swifts.index'));
            // storeNotification('Imported Swift transfer', $uniqueValues, $message, $redirect_url);
            return $this->sendResponse(true, 'Members Imported Successfully.');
            // return $this->sendResponse(true, 'Members import procress is going on . You will be notified when process is complete.');

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return $this->sendError($th->getMessage());
            //throw $th;
        }
    }

    public function headingsByPolicy($policy_id, Request $request)
    {
        $memberId = $request->employee_id;
        $relative_id = $request->member_id;
        $type = null;
        if ($relative_id) {
            $dependent = MemberRelative::where('id', $relative_id)->first();
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
        $memberPolicy = MemberPolicy::with([
            'group.headings' => function ($query) use ($relative_id, $type) {
                $query->when($relative_id, function ($q1) use ($type) {
                    $q1->where($type, 'Y');
                });
            }
        ])
            ->where('member_id', $memberId)
            ->whereHas('companyPolicy', function ($q) use ($policy_id) {
                $q->where('id', $policy_id);
            })
            ->first();

        if (is_null($memberPolicy)) {
            return $this->sendError('Company policy has not been created');
        }
        $headings = isset($memberPolicy?->group?->headings) ? $memberPolicy?->group?->headings : collect();
        // dd($headings);
        $companyPolicy = $memberPolicy?->companyPolicy;
        $policy_no = $companyPolicy?->policy_no;
        $issue_date = $companyPolicy?->issue_date;
        $imitation_days = $companyPolicy?->imitation_days;
        $end_date = null;
        if ($issue_date && $imitation_days) {
            $parsedIssueDate = Carbon::now()->startOfDay();
            $end_date = $parsedIssueDate->addDays($imitation_days)->toDateString();
        }
        $data = [
            'headings' => $headings,
            'details' => [
                'expiry_date' => $companyPolicy?->valid_date,
                'policy_no' => $policy_no,
                'issue_date' => $issue_date,
                'imitation_days' => $imitation_days,
                'end_date' => $end_date
            ],

        ];
        foreach ($headings as $key => $heading) {
            $groupPackageHeadingId = $heading->id;
            $headingData = $heading->heading;
            $headingId = $headingData->id;
            $headingName = $headingData->name;
            $insurancedAmount = $heading->amount;
            $claimedAmount = claimedAmount($memberId, $groupPackageHeadingId, $headingId);
            $data['policy'][] = [
                'heading_id' => $headingId,
                'heading_name' => $headingName,
                'insuranced_amount' => $insurancedAmount,
                'claimed_amount' => $claimedAmount ?? 0,
            ];
        }
        if ($companyPolicy) {
            return $this->sendResponse($data, getMessageText('fetch'));
        } else {
            return $this->sendError(getMessageText('fetch', false));
        }
    }
    public function changeStatus(MemberStatusChangeRequest $request)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('members'), 'isupdate');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        // try {
        DB::beginTransaction();
        $validatedData = $request->validated();
        $memberId = $validatedData['member_id'];
        $status = $validatedData['is_active'];
        $member = Member::with(['user'])
            ->where('id', $memberId)->firstOrFail();
        $member->update([
            'is_active' => $status
        ]);
        $member?->user?->update([
            'is_active' => $status
        ]);
        $current_user = getUserDetail();
        $memberID = $member->id;
        $claimUserClientId = $member?->client_id;
        $memberType = $member->type;
        if ($memberType == 'individual') {
            $redirect_url = str_replace(url('/'), '', route('members.index')) . '?member_id=' . $memberID;
        } else {
            $redirect_url = str_replace(url('/'), '', route('member-groups.index')) . '?member_id=' . $memberID;
        }
        $userIds = User::where(function ($q) use ($claimUserClientId, $memberType) {
            // Users who do not have a member
            $q->whereDoesntHave('member');
            if ($memberType !== 'individual') {
                // Or users who have a member that meets the conditions
                $q->orWhereHas('member', function ($q) use ($claimUserClientId) {
                    $q->where('client_id', $claimUserClientId)
                        ->where('type', '!=', 'member');
                });
            }
        })
            ->pluck('id')
            ->toArray();

        $uniqueArray = array_unique(array_values(array_diff($userIds, [$current_user->id])));
        $message = 'The member has been ' . ($status === 'Y' ? 'activated' : 'deactivated') . ' with Member ID: ' . $memberID . '.';
        storeNotification('Member', $uniqueArray, $message, $redirect_url);
        DB::commit();
        return $this->sendResponse(true, $message);
    }

    public function clientEmployee(Request $request)
    {
        $data = Member::when($request->has('client_id') && !is_null($request->client_id), function ($q) use ($request) {
            $q->where('client_id', $request->client_id);
        })->get(['id', 'name']);
        if ($data) {
            return $this->sendResponse($data, getMessageText('fetch'));
        } else {
            return $this->sendError(getMessageText('fetch', false));
        }
    }
}
