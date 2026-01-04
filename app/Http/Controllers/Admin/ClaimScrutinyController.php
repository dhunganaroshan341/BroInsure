<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Group;
use App\Models\InsuranceClaim;
use App\Models\InsuranceHeading;
use App\Models\Scrunity;
use App\Models\ScrunityDetail;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;

class ClaimScrutinyController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function indexzzz(Request $request)
    {
        $access = $this->accessCheck('claimscrutiny');
        $data['access'] = $access;
        if ($request->ajax()) {
            $claims = InsuranceClaim::with(['heading:id,name', 'member.memberPolicy.group:id,name', 'member.user', 'relation:rel_name,rel_relation,id,rel_dob', 'creator:id,fname,mname,lname', 'lot'])
                ->whereNotNull('lot_no')
                ->when(!is_null($request->lot), function ($q) use ($request) {
                    $q->where('member_id', $request->employee_id);
                })
                ->when(!is_null($request->status), function ($q) use ($request) {
                    // $q->where('status', $request->status);
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
            ;
            return Datatables::of($claims)
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
                    return $btn = "<a href='javascript:void(0)' class='preview btn btn-secondary btn-sm previewData' data-pid='" . $row->id . "' data-url=" . route('claimsubmissions.show', "$row->id") . "><i class='fas fa-eye'></i> </a>";
                })
                ->addColumn('full_name', function ($row) {
                    return $row->fname . ' ' . $row->lname;
                })

                ->rawColumns(['action', 'is_active'])
                ->make(true);
        }
        $data['title'] = 'Claim Scrutiny';
        $data['extraCss'] = commonDatatableFiles('css');
        $data['extraJs'] = commonDatatableFiles();
        $data['extraCss'][] = 'admin/cdns/select2-bootstrap-5/dist/select2-bootstrap-5-theme.min.css';
        $data['extraCss'][] = 'admin/cdns/select2@4.1/dist/css/select2.min.css';
        $data['extraJs'][] = 'admin/cdns/select2@4.1/dist/js/select2.min.js';
        $data['headings'] = InsuranceHeading::where('status', 'Y')->orderBy('name', 'asc')->get(['id', 'name']);
        $data['groups'] = Group::get();
        return view('backend.claimscrutiny.list', $data);
    }

    public function index()
    {
        return view("backend.scrutiny.show", [
            "title" => "Scrutiny",
            "access" => $this->accessCheck('claimsubmissions')
        ]);
    }
    public function destroyScrunity($id)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('claimscrutiny'), 'isdelete');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        /** @var ScrunityDetail */
        $scrutinyDetail = ScrunityDetail::find($id);
        if (!$scrutinyDetail) {
            return $this->sendError(getMessageText('delete', false));
        }
        $isdel = $scrutinyDetail->delete();
        if ($isdel) {
            return $this->sendResponse(true, getMessageText('delete'));
        } else {
            return $this->sendError(getMessageText('delete', false));
        }
    }

}
