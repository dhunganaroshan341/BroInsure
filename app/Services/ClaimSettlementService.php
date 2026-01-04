<?php

namespace App\Services;

use App\Models\Scrunity;
use App\Models\ClaimNote;
use App\Models\InsuranceClaim;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Database\Eloquent\Builder;

class ClaimSettlementService
{
    public function getIndexDataTable(Request $request)
    {
        $claim_notes = ClaimNote::with(['client', 'claimRegister.scrunities.details', 'insuranceCliams', 'claimRegister.firstClaims.member.user'])
            ->when($request->claim_no, function (Builder $q) use ($request) {
                $q->whereHas('claimRegister', function (Builder $q) use ($request) {
                    $q
                        ->when($request->claim_no, function (Builder $q) use ($request) {
                            $q->where('claim_no_id', $request->claim_no);
                        })

                    ;
                });
            })
            ->whereHas('insuranceCliams', function (Builder $q) use ($request) {
                $q->where(function ($q1) {
                    $q1->where('status', InsuranceClaim::STATUS_VERIFIED)->orWhere('status', InsuranceClaim::STATUS_APPROVED);
                })
                ;
            })
            ->when($request->client_id, function (Builder $q) use ($request) {
                $q->where('client_id', $request->client_id);
            })
            ->when($request->from_date, function (Builder $q) use ($request) {
                $q->where('created_at', '>=', $request->from_date);
            })
            ->when($request->to_date, function (Builder $q) use ($request) {
                $q->where('created_at', '<=', $request->to_date);
            })
            ->orderBy('status', 'DESC')
            ->get();
        return DataTables::of($claim_notes)
            ->addIndexColumn()
            ->addColumn('claim_no', function (ClaimNote $row) {
                return $row->claimRegister->claim_no;
            })
            ->addColumn('file_no', function (ClaimNote $row) {
                return $row->claimRegister->file_no;
            })
            ->addColumn('client_name', function (ClaimNote $row) {
                return $row->client->name;
            })
            ->addColumn('member_name', function (ClaimNote $row) {
                return $row->claimRegister->firstClaims->member?->user?->full_name;
            })
            ->addColumn('status', function (ClaimNote $row) {
                return $row->status ?? 'Pending';
            })
            ->addColumn('claim_id', function (ClaimNote $row) {
                return $row->insuranceCliams[0]->claim_id;
            })
            ->addColumn('bill_amount', function (ClaimNote $row) {

                return  numberFormatter($row->claimRegister?->Allscrunities?->details->sum('bill_amount'));
            })
            ->addColumn('claim_amount', function (ClaimNote $row) {
                return  numberFormatter($row->claimRegister?->Allscrunities?->details->sum('approved_amount'));
            })
            ->addColumn('action', function (ClaimNote $row) {
                $btn = "";
                // if ($row->status !== Scrunity::STATUS_APPROVED) {
                //     $btn .= " <a href='javascript:void(0)'
                //                 class='btn btn-warning text-white btn-sm approveData'
                //                 data-claim_note_id='$row->id'
                //                 data-url=" . route('claimapproval.updatestatus', "$row->id") . ">
                //                     <i class='fas fa-check'></i>
                //             </a>";
                // }
                $firstCLiam = isset($row->insuranceCliams[0]) ? $row->insuranceCliams[0] : collect();
                if ($row->status !== Scrunity::STATUS_APPROVED) {
                    $btn .= "<a href='javascript:void(0)' class='btn btn-success btn-sm scrutinyBtn' data-claim_id='" . $firstCLiam->claim_id . "' data-pid='" . $firstCLiam?->member_id . "' data-relative_id='" . $firstCLiam->relative_id . "' ><i class='fas fa-file-medical-alt'></i> </a>";
                }
                $btn .= "
                        <a href='javascript:void(0)'
                            class='btn btn-primary btn-sm previewData'
                            data-claim_note_id='$row->id'
                            data-url=" . route('claimsubmissions.show', "$row->id") . ">
                                <i class='fas fa-eye'></i>
                        </a>
                    ";

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection $scrunities
     */
    public function getScrunityTable($scrunities, $excessAmount = null)
    {

        return DataTables::of($scrunities)
            ->addIndexColumn()
            ->addColumn('member_name', function (Scrunity $row) {
                return $row->member->user->full_name;
            })
            ->addColumn('dependent_name', function (Scrunity $row) {
                return $row->relative->rel_name ?? null;
            })
            ->addColumn('claim_amount', function (Scrunity $row) {
                return  numberFormatter($row->details->sum('bill_amount'));
            })
            ->addColumn('bill_amount', function (Scrunity $row) {
                return  numberFormatter($row->details->sum('approved_amount'));
            })
            ->addColumn('excess', function (Scrunity $row) use ($excessAmount) {
                return  numberFormatter($excessAmount);
                // return $row->details->sum('deduct_amount');
            })
            ->addColumn('total_amount', function (Scrunity $row) use ($excessAmount) {
                return  numberFormatter($row->details->sum('approved_amount') - $excessAmount);
            })
            ->addColumn('remarks', function (Scrunity $row) {
                return $row->details->pluck('remarks')->implode(', ');
            });
    }

    public function getScrunityDetails(ClaimNote $claim_note)
    {
        return [
            'claim_no' => $claim_note->claimRegister->claim_no,
            'claim_intimation_date' => $claim_note->created_at->format('Y-m-d'),
            'document_no' => $claim_note->claimRegister->file_no,
            'period_of_insured' => "From " . $claim_note->client->policies->first()?->issue_date . " to " . $claim_note->client->policies->first()?->valid_date,
            'name_of_insured' => $claim_note->client->name,
            'premium_balance' => 0
        ];
    }
}
