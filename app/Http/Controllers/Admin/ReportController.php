<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Client;
use App\Models\CompanyPolicy;
use App\Models\InsuranceClaim;
use App\Models\InsuranceHeading;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends BaseController
{
    public function index(Request $request){
        $data['title'] = 'Report| MIS';
        $data['extraCss'] = commonDatatableFiles('css');
        $data['extraJs'] = commonDatatableFiles();
        $data['extraCss'][] = 'admin/cdns/select2-bootstrap-5/dist/select2-bootstrap-5-theme.min.css';
        $data['extraCss'][] = 'admin/cdns/select2@4.1/dist/css/select2.min.css';
        $data['extraJs'][] = 'admin/cdns/select2@4.1/dist/js/select2.min.js';
        $data['clients']=Client::get(['id','name']);
        $data['headings']=InsuranceHeading::get(['id','name']);
        return view('backend.report.index',$data);
    }

    public function claim_details(Request $request){
        $currentuser = getUserDetail();
        if ($request->ajax()) {
            $currentuserId = getUserDetail()->id;
            $claims = InsuranceClaim::with(['heading:id,name', 'sub_heading:id,name', 'member.client','member.user', 'member.companyPolicies', 'relation:rel_name,rel_relation,id', 'scrunity.details', 'logs'])
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
                })->when($request->has('client_id')&& !is_null($request->client_id), function ($q) use ($request) {
                    // dd($request->client_id);
                    $q->whereHas('member.client',function($qq)use($request){
                        $qq->where('clients.id',$request->client_id);
                    });
                })->when($request->has('type')&& !is_null($request->type), function ($q) use ($request) {
                    // dd($request->client_id);
                    if ($request->type=='non-group') {
                        # code...
                        $q->whereHas('member',function($qq)use($request){
                            $qq->where('type','individual');
                        });
                    } else {
                        # code...
                        $q->whereHas('member',function($qq)use($request){
                            $qq->where('type','!=','individual');
                        });
                    }
                    
                })->when($request->has('heading_id')&& !is_null($request->heading_id), function ($q) use ($request) {
                    $q->where('heading_id',$request->heading_id);
                })->when($request->has('sub_heading_id')&& !is_null($request->sub_heading_id), function ($q) use ($request) {
                    $q->where('sub_heading_id',$request->sub_heading_id);
                })->when($request->has('claim_status')&& !is_null($request->claim_status), function ($q) use ($request) {
                    if(in_array('Scrunity',$request->claim_status)){

                        $q->whereIn('status',$request->claim_status)->orWhere('status','Verified');
                    }else{

                        $q->whereIn('status',$request->claim_status);
                    }
                })->when($request->has('claim_claim_no')&& !is_null($request->claim_claim_no), function ($q) use ($request) {
                    $q->where('claim_id','ILIKE', '%' . trim($request->claim_claim_no) . '%');
                })->when($request->has('policy_no')&& !is_null($request->policy_no), function ($q) use ($request) {
                    $q->whereHas('member.currentMemberPolicy.companyPolicy',function($qq)use($request){
                        $qq->where('company_policies.policy_no','ILIKE', '%' . trim($request->policy_no) . '%');
                    });
                })
                ;
                // dd($claims->get());
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
            return DataTables::of($filtered_claims)
                ->addIndexColumn()
                ->addColumn('member_name', function ($row) {
                    $employee = $row?->member?->user;
                    return $employee?->fname . ' ' . $employee?->mname . ' ' . $employee?->lname;
                })
                ->addColumn('approved_amt', function ($row) {
                    return $row?->status ?($row->status == 'Approved' ?  numberFormatter($row->scrunity->details->sum('approved_amount')): '') : 'Pending';
                })
                ->editColumn('bill_amount',function ($row) {
                    return numberFormatter($row->bill_amount);
                })
                // ->addColumn('designation', function ($row) {
                //     return $row?->member?->designation;
                // })
                // ->addColumn('branch', function ($row) {
                //     return $row?->member?->branch;
                // })
                ->addColumn('client_name', function ($row) {
                    return $row?->member?->client?->name;
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
                    return $row?->status ? str_replace('_', ' ', $row?->status) : 'Pending';
                    // return $row?->lot?->status ?? 'Pending';
                })
                ->addColumn('status_remarks', function ($row) {
                    return $row?->status ? ($row->status == 'Resubmission' ? $row->logs->where('type', 'Resubmission')->sortByDesc('id')->first()->remarks : ($row->status == 'Approved' ? $row->scrunity->details->pluck('remarks')->implode(',') : '')) : '';
                    // return $row?->lot?->status ?? 'Pending';
                })
                ->addColumn('member', function ($row) {
                    return ($row->relative_id) ? $row?->relation?->rel_name : 'Self';
                })
                // ->addColumn('relation', function ($row) {
                //     return ($row->relative_id) ? $row?->relation?->rel_relation : '';
                // })
                
                // ->addColumn('file', function ($row) {
                //     return "<a  target='_blank' href='" . asset($row->file_path) . "' >" . $row->bill_file_name . "</a>";
                // })
                ->rawColumns(['status_remarks','approved_amt'])
                ->make(true);
        }
    }

    public function client_details(Request $request){
        $currentuser = getUserDetail();
        if ($request->ajax()) {
            $currentuserId = getUserDetail()->id;
            $claims = CompanyPolicy::with(['groups','client'])
                
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
                ->when($request->has('client_id')&& !is_null($request->client_id), function ($q) use ($request) {
                    // dd($request->client_id);
                        $q->where('client_id',$request->client_id);
                })
                // ->when($request->has('type')&& !is_null($request->type), function ($q) use ($request) {
                //     if ($request->type=='non-group') {
                //         $q->whereHas('member',function($qq)use($request){
                //             $qq->where('type','individual');
                //         });
                //     } else {
                //         $q->whereHas('member',function($qq)use($request){
                //             $qq->where('type','!=','individual');
                //         });
                //     }
                    
                // })
                ->when($request->has('heading_id')&& !is_null($request->heading_id), function ($q) use ($request) {
                    $q->whereHas('groups.headings',function($qq)use($request){
                        $qq->where('insurance_headings.id',$request->heading_id);
                    });
                })
                // ->when($request->has('sub_heading_id')&& !is_null($request->sub_heading_id), function ($q) use ($request) {
                //     $q->where('sub_heading_id',$request->sub_heading_id);
                // })
                ->when($request->has('client_status')&& !is_null($request->client_status), function ($q) use ($request) {
                    $q->whereHas('client',function($qq)use($request){
                        
                        if (!in_array('All',$request->client_status)) {
                            $qq->where('status',$request->client_status);
                        }
                        
                    });
                })
                // ->when($request->has('claim_claim_no')&& !is_null($request->claim_claim_no), function ($q) use ($request) {
                //     $q->where('claim_id','ILIKE', '%' . trim($request->claim_claim_no) . '%');
                // })
                ->when($request->has('policy_no')&& !is_null($request->policy_no), function ($q) use ($request) {
                        $q->where('policy_no','ILIKE', '%' . trim($request->policy_no) . '%');
                })
                ;
                // dd($claims->get());
            // if (isset($request->type) && $request->type == 'group') {
            //     $filtered_claims = [];
            //     $claims = $claims->get();
            //     foreach ($claims->groupBy(function ($item) {
            //         return $item->claim_id;
            //     }) as $key => $grouped_claims) {
            //         $new_claim = $grouped_claims->first();
            //         $new_claim->bill_amount = $grouped_claims->sum('bill_amount');
            //         $new_claim->insurance_claim_ids = $grouped_claims->pluck("id");
            //         $filtered_claims[] = $new_claim;
            //     }
            // } else {
                $filtered_claims = $claims;
            // }
            // dd($filtered_claims->get());
            // dd($filtered_claims[0]->scrunity->details->pluck('remarks')->implode(','));
            return DataTables::of($filtered_claims)
                ->addIndexColumn()
                // ->addColumn('member_name', function ($row) {
                //     $employee = $row?->member?->user;
                //     return $employee?->fname . ' ' . $employee?->mname . ' ' . $employee?->lname;
                // })
                // ->addColumn('approved_amt', function ($row) {
                //     return $row?->status ?($row->status == 'Approved' ?  numberFormatter($row->scrunity->details->sum('approved_amount')): '') : 'Pending';
                // })
                // ->editColumn('bill_amount',function ($row) {
                //     return numberFormatter($row->bill_amount);
                // })
                // ->addColumn('designation', function ($row) {
                //     return $row?->member?->designation;
                // })
                // ->addColumn('branch', function ($row) {
                //     return $row?->member?->branch;
                // })
                ->addColumn('client_name', function ($row) {
                    return $row?->client?->name;
                })
                ->addColumn('total_claim_amount', function ($row) {
                    return '00999';
                })
                ->addColumn('total_claim', function ($row) {
                    return 90;
                })
                ->addColumn('approved_amt', function ($row) {
                    return 90;
                })
                ->addColumn('status', function ($row) {
                    return $row?->client?->status=='Y'?'Active':'Inactive';
                    // return $row?->lot?->status ?? 'Pending';
                })
                ->rawColumns(['approved_amt'])
                ->make(true);
        }
    }
}
