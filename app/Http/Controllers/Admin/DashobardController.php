<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\City;
use App\Models\ClaimRegister;
use App\Models\Client;
use App\Models\CompanyPolicy;
use App\Models\District;
use App\Models\Group;
use App\Models\InsuranceClaim;
use App\Models\Member;
use App\Models\Scrunity;
use App\Models\ScrunityDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
class DashobardController extends BaseController
{
    public function dashboard()
    {
        $currentUser = getUserDetail();

        $data['extraCss'] = commonDatatableFiles('css');
        $data['extraJs'] = commonDatatableFiles();
        $data['extraJs'][] = 'admin/assets/plugins/apexchart/apexcharts.min.js';
        $data['extraJs'][] = 'admin/assets/plugins/peity/jquery.peity.min.js';
        //   $data['extraJs'][]='admin/assets/js/dashboard1.js';
        $data['currentUser'] = $currentUser;
        if ($currentUser->rolecode !== 'HR' && $currentUser->rolecode !== 'MB') {
            $data['groups'] = Group::where(function ($q) use ($currentUser) {
                if ($currentUser->rolecode == 'HR' || $currentUser->rolecode == 'MB') {
                    $q->where('client_id', $currentUser->client_id);
                }
            })->where('id', '!=', 1)->get();
            $clients = Client::where(function ($q) use ($currentUser) {
                if ($currentUser->rolecode == 'HR' || $currentUser->rolecode == 'MB') {
                    $q->where('id', $currentUser->client_id);
                }
            })
                ->selectRaw("
                            COUNT(CASE WHEN status = 'Y' THEN 1 END) as active_clients,
                            COUNT(CASE WHEN status != 'Y' THEN 1 END) as inactive_clients
                        ")->first();
            $data['clients'] = Client::where(function ($q) use ($currentUser) {
                if ($currentUser->rolecode == 'HR' || $currentUser->rolecode == 'MB') {
                    $q->where('id', $currentUser->client_id);
                }
            })
                ->select('id', 'name')->get();
            $data['active_clients'] = $clients->active_clients;
            $data['inactive_clients'] = $clients->inactive_clients;
        }



        $insuranceClaimApprovedValue = InsuranceClaim::STATUS_APPROVED;
        $data['all_claims'] = InsuranceClaim::where(function ($q) use ($currentUser) {
            if ($currentUser->rolecode == 'HR' || $currentUser->rolecode == 'MB') {
                $q->whereHas('member', function ($q) use ($currentUser) {
                    $q->where('client_id', $currentUser->client_id);
                });
            }
        })
            ->when($currentUser->rolecode == 'MB', function ($q4) use ($currentUser) {
                $q4->where('member_id', $currentUser->member_id);
            })
            ->selectRaw("
            COUNT(DISTINCT claim_id) as total_claims,
            SUM(CAST(bill_amount AS NUMERIC)) as total_bill_amount,
             COUNT(DISTINCT CASE WHEN status = ? THEN claim_id END) as approved_claims,
            SUM(CASE WHEN status = ? THEN CAST(bill_amount AS NUMERIC) ELSE 0 END) as approved_bill_amount
        ", [$insuranceClaimApprovedValue, $insuranceClaimApprovedValue])
            ->first();

        $tottal_scrunity = ScrunityDetail::whereHas('scrunity', function ($q) use ($insuranceClaimApprovedValue, $currentUser) {
            $q->where('status', Scrunity::STATUS_APPROVED);
            if ($currentUser->rolecode == 'HR' || $currentUser->rolecode == 'MB') {
                $q->whereHas('member', function ($q) use ($currentUser) {
                    $q->where('client_id', $currentUser->client_id)
                        ->when($currentUser->rolecode == 'MB', function ($q4) use ($currentUser) {
                            $q4->where('id', $currentUser->member_id);
                        });
                });
            }
            $q->whereHas('claims', function ($q4) use ($insuranceClaimApprovedValue) {
                $q4->where('status', $insuranceClaimApprovedValue);
            });
        })
            ->selectRaw("
            SUM(CAST(approved_amount AS NUMERIC)) as tottal_scrunity_approved_amount
        ")->first();
        $data['all_claims']->approved_amount = $tottal_scrunity->tottal_scrunity_approved_amount;

        
        //   dd( $data['groups']);
        return view('backend.dashboard', $data);
    }

    public function getDistrict($id)
    {
        // dd($id);
        $districts = District::where('state_id', $id)->get(['id', 'name']);
        if (isset($districts)) {
            return $this->sendResponse($districts, getMessageText('fetch'));
        } else {
            return $this->sendError(getMessageText('fetch', false));
        }
    }
    public function getCities($id)
    {
        $cities = City::where('district_id', $id)->get(['id', 'name']);

        if (isset($cities)) {
            return $this->sendResponse($cities, getMessageText('fetch'));
        } else {
            return $this->sendError(getMessageText('fetch', false));
        }
    }

    public function totalMember(Request $request)
    {
        $data = null;
        if ($request->has('client_type') && $request->client_type != 'individual') {
            $query = Member::when($request->has('client_type'), function ($q) use ($request) {
                if ($request->client_type == 'group') {
                    if ($request->has('client_group') && !is_null($request->client_group)) {
                        $q->whereHas('currentMemberPolicy', function ($qq) use ($request) {
                            $qq->where('group_id', $request->client_group);
                        });
                    } else {
                        $q->where('type', '!=', 'individual');
                    }
                }
            });

            $data['total'] = $query->count();
        } else {
            $query = Member::where('type', 'individual');
            $data['total'] = $query->count();
        }
        // return $data;
        $startDate = Carbon::now()->subMonths(4)->startOfMonth();

        // Get the count for the last 5 months including the current month
        $finalData = $query->selectRaw('EXTRACT(YEAR FROM created_at) as year, EXTRACT(MONTH FROM created_at) as month, COUNT(*) as count')
            ->where('created_at', '>=', $startDate)
            ->groupBy(DB::raw('EXTRACT(YEAR FROM created_at), EXTRACT(MONTH FROM created_at)'))
            ->orderBy(DB::raw('EXTRACT(YEAR FROM created_at), EXTRACT(MONTH FROM created_at)'))
            ->get();

        // Initialize the array with zeros for the last 5 months
        // $currentMonth = Carbon::now()->month;
        // $currentYear = Carbon::now()->year;
        $data['data'] = array_fill(0, 5, 0);

        // Populate the array with data from the query
        foreach ($finalData as $item) {
            $yearMonth = Carbon::create($item->year, $item->month)->format('Y-m');
            $dataIndex = (Carbon::now()->year * 12 + Carbon::now()->month) - ($item->year * 12 + $item->month) - 1;
            if ($dataIndex >= 0 && $dataIndex < 5) {
                $data['data'][$dataIndex] = $item->count;
            }
        }

        // $data['total'] = array_sum($data['data']);
        // $data['last_month_count'] =   ($data['data'][0]*100)/$data['total'];
        $data['last_month_count'] = $this->calculatePercentageChange(5, $data['data'][1]);
        // dd($data);
        // $lastIncreased=$data['total']-$data['data'];
        return $this->sendResponse($data, getMessageText('fetch'));
    }
    public function member_details(Request $request)
    {
        $clients = Client::when($request->has('providence_id') && !is_null($request->providence_id), function ($q) use ($request) {
            $q->where('providence', $request->providence_id);
        })->with(['categoryType', 'vdc', 'dis', 'province']);
        $filtered_count = $clients->count();
        $counts = $clients->count();
        // Fetch records with pagination
        $start = 0;
        $length = 10;
        if (request()->has('start')) {
            if (request('start') >= 0) {
                $start = intval(request('start'));
            }
        }
        if (request()->has('length')) {
            if (request('length') >= 10) {
                $length = intval(request('length'));
            }
        }
        $clients1 = $clients->offset($start)
            ->limit($length);
        return Datatables::of($clients1)

            ->addIndexColumn()
            ->editColumn('address', function ($row) {
                return $row->address . ',' . $row->vdc?->name . ',' . $row->province?->name;
            })
            ->editColumn('is_active', function ($row) {
                return $row->is_active == 'Y' ? 'Yes' : 'No';
            })
            ->addColumn('categoryName', function ($row) {
                return $row->categoryType->name;
            })
            ->addColumn('province', function ($row) {
                return $row->province?->name;
            })
            ->addColumn('action', function ($row) use ($access, $useraccess) {

                $btn = '';
                if ($access['isedit'] == 'Y') {
                    $btn = "<a href='javascript:void(0)' class='edit btn btn-primary btn-sm editData' data-pid='" . $row->id . "' data-url=" . route('clients.edit', "$row->id") . "><i class='fas fa-edit'></i> Edit</a>";
                }
                if ($access['isdelete'] == 'Y') {
                    $btn .= "&nbsp;<a href='javascript:void(0)' class='edit btn btn-danger btn-sm deleteData' data-pid='" . $row->id . "' data-url=" . route('clients.destroy', "$row->id") . "><i class='fas fa-trash'></i> Delete</a>";
                }
                //buttons for user management for clients
                if ($useraccess['isinsert'] == 'Y') {
                    $btn .= "&nbsp;<a href='javascript:void(0)' class='edit btn btn-success btn-sm addUser' data-pid='" . $row->id . "'id=addUser><i class='fas fa-plus'></i>Add User</a>";
                    $btn .= "&nbsp;<a href='javascript:void(0)' class='edit btn btn-warning btn-sm listUser' data-pid='" . $row->id . "'id=listUser><i class='fas fa-users'></i>Users</a>";
                }

                return $btn;
            })


            ->rawColumns(['action', 'categoryName', 'province'])
            ->with([
                "recordsFiltered" => $filtered_count,
                "recordsTotal" => $counts
            ])
            ->make(true);
    }

    function calculatePercentageChange($original, $newNumber)
    {
        // dd($original, $newNumber);
        if ($original == 0) {
            // If the original is zero and the new number is also zero, no change
            if ($newNumber == 0) {
                return 0;
            }
            // If the original is zero and the new number is positive, 100% increase
            // If the original is zero and the new number is negative, 100% decrease
            return $newNumber > 0 ? 100 : -100;
        }

        $difference = $newNumber - $original;
        $percentageChange = ($difference / abs($original)) * 100;

        return $percentageChange;
    }
    public function preminumAmount(Request $request)
    {
        $client_id = $request->client_id;
        $currentUser = getUserDetail();

        if ($currentUser->rolecode == 'HR' || $currentUser->rolecode == 'MB') {
            $client_id = $currentUser->client_id;
        }
        $data = [];
        $insuranceClaimApprovedValue = InsuranceClaim::STATUS_APPROVED;
        $tottal_scrunity = ScrunityDetail::whereHas('scrunity', function ($q) use ($insuranceClaimApprovedValue, $client_id) {
            $q->where('status', Scrunity::STATUS_APPROVED)
                ->when($client_id, function ($q2) use ($client_id) {
                    $q2->whereHas('member', function ($q) use ($client_id) {
                        $q->where('client_id', $client_id);
                    });
                })
                ->whereHas('claims', function ($q) use ($insuranceClaimApprovedValue) {
                    $q->where('status', $insuranceClaimApprovedValue);
                });
        })
            ->selectRaw("
            SUM(CAST(approved_amount AS NUMERIC)) as tottal_scrunity_approved_amount
        ")->first();
        $data['approved_amount'] = $tottal_scrunity->tottal_scrunity_approved_amount ?? 0;
        $policy = CompanyPolicy::when($client_id, function ($q2) use ($client_id) {
            $q2->where('client_id', $client_id);
        })
            ->selectRaw("
            SUM(CAST(premium_amount AS NUMERIC)) as tottal_premium_amount
        ")
            ->first();
        $data['preminum_amount'] = $policy->tottal_premium_amount ?? 0;
        return $this->sendResponse($data, getMessageText('fetch'));
    }

    public function getClaimStatusData(Request $request)
    {
        $user = getUserDetail();
        $claims = InsuranceClaim::with(['member.user'])->distinct('claim_id')->where(function($q)use($user){
            if ($user->rolecode=='HR') {
                $q->whereHas('member',function($qq)use($user){
                    $qq->where('members.client_id',$user->client_id);
                });
            } elseif ($user->rolecode=='MB') {
                    $q->where('member_id',$user->member_id);
            }
            
        });
        $filtered_count = $claims->count();
        $counts = $claims->count();
        // Fetch records with pagination
        $start = 0;
        $length = 10;
        if (request()->has('start')) {
            if (request('start') >= 0) {
                $start = intval(request('start'));
            }
        }
        if (request()->has('length')) {
            if (request('length') >= 10) {
                $length = intval(request('length'));
            }
        }
        $claims1 = $claims->offset($start)
            ->limit($length);
        return Datatables::of($claims1)

            ->addIndexColumn()
            ->addColumn('claim_member_id', function ($row) {
                return $row->member?->user->full_name;
            })
            ->addColumn('claim_created_at', function ($row) {
                // return ('Y-m-d H:i:s', $row->created_at)->format('Y-m-d');
                return Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->format('Y-m-d');
            })
            ->addColumn('claim_document_date', function ($row) {
                // return ('Y-m-d H:i:s', $row->created_at)->format('Y-m-d');
                return $row->document_date;
            })
            ->addColumn('claim_id', function ($row) {
                // return ('Y-m-d H:i:s', $row->created_at)->format('Y-m-d');
                return $row->claim_id;
            })
            ->editColumn('claim_status',function($row){
                return '<div class="d-flex flex-wrap p-0 m-0">
                <div class="p-2 flex-fill '.($row->status=='Received'?'bg-secondary text-white':'').'" style="border-right: 1px solid black;padding: 8px;" >
                    Pending
                </div>
                <div class="p-2 flex-fill '.($row->status=='Registered'?'bg-warning ':'').'" style="border-right: 1px solid black;padding: 8px;" >
                    Registered
                </div>
                <div class="p-2 flex-fill '.($row->status=='Scrunity'?'bg-primary text-white':'').'" style="border-right: 1px solid black;padding: 8px;" >
                    Scrunity
                </div>
                <div class="p-2 flex-fill '.($row->status=='Verified'?'bg-info text-white':'').'" style="border-right: 1px solid black;padding: 8px;" >
                    Verified
                </div>
                <div class="p-2 flex-fill '.($row->status=='Resubmission'?'bg-secondary text-white':'').'"  style="border-right: 1px solid black;padding: 8px;" >
                    Resubmission
                </div>
                <div class="p-2 flex-fill '.($row->status=='Approved'?'bg-success text-white':'').'" style="border-right: 1px solid black;padding: 8px;" >
                    Approved
                </div>
                <div class="p-2 flex-fill '.($row->status=='Rejected'?'bg-danger text-white':'').'" style="padding: 8px;">
                    Rejected
                </div>
            </div>';
            })

            ->rawColumns(['claim_status','claim_created_at','claim_member_id','claim_document_date','claim_id'])
            ->with([
                "recordsFiltered" => $filtered_count,
                "recordsTotal" => $counts
            ])
            ->make(true);
    }
}
