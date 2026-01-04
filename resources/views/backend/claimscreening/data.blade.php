<style>
    :root {
        --default-margin-mq: 105px;
        /* Default margin for .marginTopMQ */
        --default-margin-mq-sec: 105px;
        /* Default margin for .marginTopMQSec */
        --extra-margin: 10px;
        /* Increment margin if condition met */
    }

    .stickyHeader {
        position: fixed;
        top: 46px;
        background: #eff1f3;
        z-index: 99999;
        padding-top: 7px;
        left: 0;
        right: 0;
        border-bottom: var(--bs-modal-header-border-width) solid var(--bs-modal-header-border-color);
    }

    /* Base styles */
    .marginTopMQ {
        margin-top: var(--default-margin-mq);
    }

    .marginTopMQSec {
        margin-top: var(--default-margin-mq-sec);
    }

    /* Tablet (900px to 1024px) */
    @media (max-width: 1024px) and (min-width: 900px) {
        :root {
            --default-margin-mq: 150px;
            --default-margin-mq-sec: 150px;
        }
    }

    /* Tablet (768px to 900px) */
    @media (max-width: 900px) and (min-width: 768px) {
        :root {
            --default-margin-mq: 160px;
            --default-margin-mq-sec: 160px;
        }
    }

    /* Mobile (400px to 767px) */
    /* @media (max-width: 767px) and (min-width: 400px) {
        :root {
            --default-margin-mq: 265px;
            --default-margin-mq-sec: 50px;
        }
    } */

    /* Mobile (less than 400px) */
    /* @media (max-width: 399px) {
        :root {
            --default-margin-mq: 300px;
            --default-margin-mq-sec: 50px;
        }
    } */

    @media (max-width: 767px) {

        /* Small devices like phones */
        .stickyHeader {
            position: static;
            top: auto;
            background: #eff1f3;
            z-index: auto;
            padding-top: 0;
            left: auto;
            right: auto;
            border-bottom: var(--bs-modal-header-border-width) solid var(--bs-modal-header-border-color);
        }

        :root {
            --default-margin-mq: 5px;
            --default-margin-mq-sec: 10px;
        }
    }

    /* Extra margin condition */
    .extraMargin {
        margin-top: calc(var(--default-margin-mq) + var(--extra-margin));
    }

    .heighWidthOfEditor {
        width: 100%;
        /* You can also set this to a fixed width like 1000px if needed */
        height: 700px;
        /* Set a fixed height */
        overflow: hidden;
        /* Enable scrolling */
    }

    .heighWidthOfEditor .tui-image-editor-canvas {
        overflow: auto;
    }

    .custom-popover {
        --bs-popover-max-width: 300px;
        --bs-popover-border-color: rgba(0, 0, 0, 0.2);
        /* Soft border */
        --bs-popover-border-color: #6c5ce7;
        --bs-popover-header-bg: #6c5ce7;
        --bs-popover-header-color: white;
        /* Header text color */
        --bs-popover-body-color: #2d3436;
        /* Dark gray body text */
        --bs-popover-body-bg: #dfe6e9;
        /* Light gray body background */
        --bs-popover-border-radius: 10px;
        /* Rounded corners */
        --bs-popover-box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        /* Shadow */
        --bs-popover-body-padding-x: 1.5rem;
        --bs-popover-body-padding-y: 1rem;
        --bs-popover-arrow-width: 12px;
        /* Arrow customization */
        --bs-popover-arrow-height: 12px;
        --bs-popover-arrow-color: #6c5ce7;
    }

    @keyframes blink {
        50% {
            opacity: 0;
        }
    }
</style>

<div class="upper-container row  overflow-hidden">
    <div class="col-md-12  row">
        <div class="employee-info-container col-md-12 d-flex flex-column stickyHeader">
            @php
                $columns_per_row = 3;
                $firstClaim = $claims[0];
                $user = $firstClaim->member;
                $memberPolicy =
                    $user?->allMemberPolicy?->where('group_id', $firstClaim->group_id)->first() ?? collect();
                $memberGroup = $memberPolicy?->group;
                $groupHeadings = $firstClaim->relative_id
                    ? $memberGroup->headings->where($relative_type, 'Y')
                    : $memberGroup->headings;
                $totalInsurance = 0;
                $totalCollected = 0;
                foreach ($groupHeadings as $key => $heading) {
                    $groupPackageHeadingId = $heading->id;
                    $headingData = $heading->heading;
                    $headingId = $headingData->id;
                    $headingName = $headingData->name;
                    if ($memberGroup?->is_amount_different !== 'Y') {
                        $insurancedAmount = $heading->amount;
                    } else {
                        if ($firstClaim->relative_id) {
                            $amountColumn = $relative_type . '_amount';
                            $insurancedAmount = $heading->$amountColumn;
                        } else {
                            $insurancedAmount = $heading->amount;
                        }
                    }
                    $totalInsurance += $insurancedAmount;
                    $onlyScrutiny = true;
                    $claimedAmount =
                        claimedAmount(
                            $memberCurrentId,
                            $groupPackageHeadingId,
                            $headingId,
                            $firstClaim->relative_id,
                            $onlyScrutiny,
                        ) ?? 0;

                    $userPolicy[] = [
                        'heading_id' => $headingId,
                        'heading_name' => $headingName,
                        'insuranced_amount' => $insurancedAmount,
                        'claimed_amount' => $claimedAmount,
                    ];
                }
                $data = $user->currentMemberPolicy?->companyPolicy;
                $expirydate = null;
                if ($data?->policy_type == 'retail') {
                    $expirydate = $user?->memberPolicy;
                }
            @endphp
            <div class="row">
                <label class="col-md-3">Employee ID: {{ $user->employee_id }}</label>
                <label class="col-md-3">Designation: {{ $user->designation }}</label>
                <label class="col-md-3">Branch: {{ $user->branch }}</label>
                <label class="col-md-3">Client Name: {{ $user->client->name }}</label>
            </div>
            <div class="row">
                <label class="col-md-3">Policy No: {{ $user->client->policies[0]->policy_no }}</label>
                <label class="col-md-3">Employee Name: {{ $user->user->full_name }}</label>
                <label class="col-md-3">Select Member: {{ $claims[0]->relative?->rel_name }}</label>
                <label class="col-md-3">Relation: {{ $claims[0]->relative?->rel_relation }}</label>
            </div>
            <div class="row">
                <label class="col-md-3">Expiry Date: {{ $expirydate?->end_date ?? $user->client->policies[0]->valid_date }}</label>
                @if ($type == 'screening')
                    <label class="col-md-3">Total Claim Amount : Rs. <span id="totalClaimAmt"></span></label>
                @else
                    <label class="col-md-3">Total Claim Amount : Rs. <span id="newTotalClaimAmt"></span></label>
                @endif
                <label class="col-md-3">Claim ID : <span id="claimspanid"></span></label>
                @if (isset($type))
                    @php
                        $firstClaim = $claims[0];
                    @endphp
                    @if ($type == 'screening')
                        @if (isset($claims[0]) &&
                                isset($claims[0]->scrunity->details) &&
                                $claims[0]->scrunity->status === \App\Models\Scrunity::STATUS_REJECTED &&
                                isset($firstClaim->logs[0]->remarks))
                            <div class="col d-flex justify-content-start">
                                <span style=" font-style: italic;" id="rejectionReasonPopoverButton"
                                    data-bs-toggle="popover" title="Reason for Rejection" data-bs-html="true"
                                    data-bs-content="{{ $firstClaim->logs[0]->remarks }}">
                                    <span class="text-danger"
                                        style="font-weight: bold;animation: blink 1s steps(5, start) infinite; ">Reason
                                        for
                                        Rejection</span>
                                </span>
                            </div>
                            {{-- <div class="col-12" id="overFlowDIv">
                                <span style=" font-style: italic;">
                                    <span class="text-danger" style="font-weight: bold;">Reason for
                                        Rejection*</span>:
                                    {{ $firstClaim->logs[0]->remarks }}
                                </span>
                            </div> --}}
                        @endif
                    @else
                        @php
                            // Create the array for request data
                            $requestData = [
                                'member_id' => $firstClaim->member_id,
                                'lot_no' => $firstClaim->lot_no,
                                'claim_no' => $firstClaim?->register_no,
                                'relative_id' => $firstClaim->relative_id,
                            ];
                            // Encode the array into a JSON string and escape it for HTML
                            $jsonRequestData = json_encode($requestData);
                        @endphp
                    @endif
                @endif

            </div>
            <div class="row">
                <div
                    class="balance-button-container d-flex {{ $type !== 'screening' ? 'justify-content-left col-12 col-sm-7' : 'justify-content-center col-12' }} col-md">
                    <div class="">
                        @if (isset($claims[0]))
                            <button class="btn btn-sm btn-warning text-white btn-outline-secondary mb-2"
                                data-type="resubmission">
                                <span>Resubmission </span>
                            </button>
                            @if ($claims[0]->is_hold == 'N')
                                <button class="btn btn-sm btn-primary text-white btn-outline-secondary mb-2"
                                    data-type="hold">
                                    <span>Hold</span>
                                </button>
                            @elseif($claims[0]->is_hold == 'Y')
                                <button class="btn btn-sm btn-primary text-white btn-outline-secondary mb-2"
                                    data-type="release">
                                    <span>Release</span>
                                </button>
                            @endif
                            <button class="btn btn-sm btn-danger text-white btn-outline-secondary mb-2"
                                data-type="reject_claim">
                                <span>Reject Claim</span>
                            </button>
                            <a href="{{ route('claim.list') }}?member_id={{ $firstClaim->member_id }}"
                                class="btn btn-sm btn-info text-white btn-outline-secondary mb-2" target="_blank">
                                <span>History</span>
                            </a>
                        @endif
                    </div>
                </div>
                @if ($type !== 'screening')
                    <div class="col d-flex justify-content-start justify-content-md-end col-12 col-sm-5 col-md">
                        @if (
                            $type == 'verification' ||
                                (isset($claims[0]) &&
                                    isset($claims[0]->scrunity->details) &&
                                    $claims[0]->scrunity->status != \App\Models\Scrunity::STATUS_APPROVED))
                            <button data-request_data="{{ $jsonRequestData }}"
                                class="mx-1 btn btn-sm btn-danger requestBtn text-white  mb-2"
                                data-type="reject_request">
                                <span>Reject Request</span>
                            </button>
                        @endif
                        @if ($type == 'verification')
                            <button data-request_data="{{ $jsonRequestData }}"
                                class="mx-1 btn btn-sm btn-success requestBtn text-white  mb-2"
                                data-type="verify_request">
                                <span>Request Approve</span>
                            </button>
                        @endif
                        @if (
                            $type == 'approval' &&
                                (isset($claims[0]) &&
                                    isset($claims[0]->scrunity->details) &&
                                    $claims[0]->scrunity->status != \App\Models\Scrunity::STATUS_APPROVED))
                            <button data-claim_note_id="{{ $firstClaim?->claimNote?->id }}"
                                data-url="{{ route('claimapproval.updatestatus', $firstClaim?->claimNote?->id) }}"
                                data-request_data="{{ $jsonRequestData }}"
                                class="mx-1 btn btn-sm btn-success requestBtn text-white  mb-2"
                                data-type="approve_request">
                                <span>Approve</span>
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        @if ($type == 'screening')
            {{-- <div class="document-container border col-md-2 mt-2 p-2 pt-1">
            <h6 class="document-header">Document</h6>
            <div class="document-list">
                <div class="d-flex flex-column ">
                    <div>
                        <label type="button" data-bs-toggle="collapse" href="#invoice-collapse" aria-expanded="false"
                            aria-controls="invoice-collapse">
                            Invoices
                        </label>
                        <ul class="collapse {{ count($claims->where('document_type', 'bill')) > 0 ? 'show' : '' }}"
                            id="invoice-collapse">
                            @foreach ($claims->where('document_type', 'bill') as $item)
                                <li><a
                                        href="{{ route('claimscreening.claim-sliders', $item->claim_id) }}?document_type=bill"
                                        target="_blank">{{ $item->bill_file_name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div>
                        <label type="button" data-bs-toggle="collapse" href="#clinical-collapse" aria-expanded="false"
                            aria-controls="clinical-collapse">
                            Clinical Reports
                        </label>
                        <ul class="collapse {{ count($claims->where('document_type', 'prescription')) > 0 ? 'show' : '' }}"
                            id="clinical-collapse">
                            @foreach ($claims->where('document_type', 'prescription') as $item)
                                <li><a
                                        href="{{ route('claimscreening.claim-sliders', $item->claim_id) }}?document_type=prescription"
                                        target="_blank">{{ $item->bill_file_name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div>
                        <label type="button" data-bs-toggle="collapse" href="#report-collapse" aria-expanded="false"
                            aria-controls="report-collapse">
                            Reports
                        </label>
                        <ul class="collapse {{ count($claims->where('document_type', 'report')) > 0 ? 'show' : '' }}"
                            id="report-collapse">
                            @foreach ($claims->where('document_type', 'report') as $item)
                                <li><a
                                        href="{{ route('claimscreening.claim-sliders', $item->claim_id) }}?document_type=report"
                                        target="_blank">{{ $item->bill_file_name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div> --}}
            <div class="col-md-6 documentEditHid marginTopMQ {{ $type !== 'screening' ? 'extraMargin' : '' }}">
                <div class="row">
                    <div class="">
                        <p class="row">
                            <span class="col">
                                {{-- <strong>Document Name:</strong> <span class="text-capitalize" id="documentName">Bill File
                                name</span> --}}
                                <select id="billSelect" class="form-select">

                                </select>
                            </span>
                            <span class="col">
                                <strong> Invoices</strong>
                                {{-- <strong> Document Type:</strong> <span class="text-capitalize"
                                id="documentType">document_type</span> --}}
                            </span>
                        </p>
                        <!-- Embed element where the content will change -->
                        <div class="ratio ratio-16x9" id="embeddedSection">
                            <img id="slider-image" class="img-fluid" src="" alt="Image Slider">
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button id="prevBtn" class="btn btn-sm btn-primary" disabled>
                                <i class="fas fa-arrow-left"></i> Previous
                            </button>
                            @if ($type == 'screening')
                                <button class="btn btn-warning" id="editClaim" data-id='0'>Edit</button>
                                <button class="btn btn-info" id="addClaim" data-id='0'
                                    sub_heading_id="">Add</button>
                            @endif
                            <span class="text-center"><span id="counterSpan">1</span></span>
                            <button id="nextBtn" class="btn btn-sm btn-primary">
                                Next <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 documentEdit" hidden>
                <div class="row">
                    <div id="tui-image-editor-container" class="documentEdit heighWidthOfEditor"></div>
                    <div class="d-flex justify-content-between mt-3">

                        <button class="btn btn-info" id="saveEditImage">Save</button>
                        <button id="editorCloseBtn" class="btn btn-sm btn-danger">Close </button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 prescriptionEditHid marginTopMQSec {{ $type !== 'screening' ? 'extraMargin' : '' }}">
                <div class="row">
                    <div class="">
                        <p class="row">
                            <span class="col">
                                <select id="reportSelect" class="form-select">

                                </select>
                            </span>
                            <span class="col">
                                <strong> Clinical/Presciption Reports </strong>
                            </span>
                        </p>
                        <div class="ratio ratio-16x9" id="prescriptionEmbeddedSection">
                            <img id="prescription-slider-image" class="img-fluid" src="" alt="Image Slider">
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button id="prescriptionPrevBtn" class="btn btn-sm btn-primary" disabled>
                                <i class="fas fa-arrow-left"></i> Previous
                            </button>
                            @if ($type == 'screening')
                                <button class="btn btn-warning" id="prescriptionEditClaim"
                                    data-id='0'>Edit</button>
                                <button class="btn btn-info" id="prescriptionAddClaim" data-id='0'>Add</button>
                            @endif
                            <span class="text-center"><span id="prescriptionCounterSpan">1</span></span>
                            <button id="prescriptionNextBtn" class="btn btn-sm btn-primary">
                                Next <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 prescriptionEdit" hidden>
                <div class="row">
                    <div id="prescription-tui-image-editor-container" class="prescriptionEdit heighWidthOfEditor">
                    </div>
                    <div class="d-flex justify-content-between mt-3">

                        <button class="btn btn-info" id="prescriptionSaveEditImage">Save</button>
                        <button id="prescriptionEditorCloseBtn" class="btn btn-sm btn-danger">Close </button>
                    </div>
                </div>
            </div>
        @else
            @include('backend.claimscreening.verification_approve')
        @endif

        {{-- <div class="col-md-4 border p-1 mt-2">
            <div class="balance-container">
                <p>Balance Details</p>
                <div class="balance-detail-info row">

                    @foreach ($userPolicy as $item)
                        <div class="col-md-5">{{ ucwords(strtolower($item['heading_name'])) }}: </div>
                        <div class="col-md-7">Rs.{{ $item['claimed_amount'] }}/Rs.{{ $item['insuranced_amount'] }}
                        </div>
                    @endforeach
                    <div class="col-md-12 text-center fw-bold text-decoration-underline mt-3">
                        Total:
                        Rs.{{ array_sum(array_column($userPolicy, 'claimed_amount')) }}/Rs.{{ $totalInsurance }}
                    </div>
                </div>
            </div>

        </div> --}}
    </div>
</div>
<div class="bottom-container mt-3">
    <div class="add-amount-container row">
        <p><strong>Add Amount</strong></p>
        <form class="row" id="scrutinyForm">
            <div class="col-md">
                <label for="">Bill No</label>
                <input type="text" id="scrutiny_bill_no" class="form-control form-control-sm"
                    style="width: 100%;" name="bill_no" required>
            </div>
            <div class="col-md">
                <label for="scrutiny_file">File</label>
                <input type="file" id="scrutiny_file" name="file" class="form-control form-control-sm"
                    style="width: 100%;" name="file">
            </div>
            <div class="col-md">
                <label for="">Title</label><span id="addLimit" style="font-size: 12px !important"
                    class="text-primary"></span>
                <select type="text" id="scrutiny_title" class="form-select form-select-sm" style="width: 100%;"
                    name="heading_id" required>
                    <option value="" selected disabled>-select heading-</option>
                    @foreach ($headings as $heading)
                        <option value="{{ $heading->id }}">{{ $heading->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md">
                <label for="">Bill Amount</label>
                <input type="number" id="scrutiny_bill_amount" class="form-control form-control-sm"
                    style="width: 100%;" name="bill_amount" required max="0">
            </div>
            <div class="col-md">
                <label for="">Approved Amount</label>
                <input type="number" id="scrutiny_approved_amount" class="form-control form-control-sm"
                    style="width: 100%;" name="approved_amount" required>
                <small id="misMatchSpan" hidden><span class="text-danger">* approved amount can not be more than
                        bill
                        amount</span></small>

            </div>
            <div class="col-md">
                <label for="">Deduction</label>
                <input type="number" id="scrutiny_deduction" class="form-control form-control-sm"
                    style="width: 100%;" name="deduct_amount" readonly required>
            </div>
            <div class="col-md">
                <label for="">Remarks</label>
                <input type="text" id="scrutiny_remarks" class="form-control form-control-sm"
                    style="width: 100%;" name="remarks" required>
            </div>
            <div class="col-md-12 d-flex flex-row-reverse gap-2 mt-2">
                <button type="button" class="btn btn-sm btn-outline-secondary clearScrunityForm">
                    <span>CLEAR</span>
                </button>
                <button type="submit" class="btn btn-sm btn-outline-primary addBtnOfCal" id="addDataToTableAdd">
                    <span>ADD</span>
                </button>
            </div>
        </form>
    </div>
    <form id="submitClaimForm" enctype="multipart/form-data" class="mt-3" action="">
        <div class="table-responsive">
            <table id="addDataToTable" class="table table-striped table-bordered labelsmaller">
                <thead>
                    <tr>
                        <th>S.N.</th>
                        <th>Bill No</th>
                        <th>File</th>
                        <th>Title</th>
                        <th>Bill Amount</th>
                        <th>Approved Amount</th>
                        <th>Deduction</th>
                        <th>Remark</th>
                        <th style="min-width:240px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <input type="hidden" name="scrunity_id"
                        value="{{ isset($claims[0]?->scrunity?->id) ? $claims[0]?->scrunity?->id : null }}">
                    @if (isset($claims[0]) && isset($claims[0]?->scrunity?->details) && !request()->query('hideRows'))
                        @foreach ($claims[0]?->scrunity?->details as $detail)
                            <tr data-rowno="{{ $loop->iteration }}" id="scrutiny_row{{ $loop->iteration }}">
                                <td><span class="scrutiny_sn">{{ $loop->iteration }}</span></td>
                                <td id="scrutiny_bill_no{{ $loop->iteration }}">
                                    <span>{{ $detail->bill_no }}</span>
                                    <input type="hidden" name="bill_no[]" value="{{ $detail->bill_no }}">
                                </td>
                                <td id="scrutiny_file{{ $loop->iteration }}">
                                    <span>
                                        @if ($detail->file)
                                            <a target="_blank"
                                                href="{{ asset($detail->file) }}">{{ basename($detail->file) }}</a>
                                        @endif
                                    </span>
                                    <input type="hidden" name="file_url[]"
                                        value="{{ $detail->file ? asset($detail->file) : null }}">
                                    <input type="hidden" name="files[]" value="">
                                </td>
                                <td id="scrutiny_title_id{{ $loop->iteration }}">
                                    <span>{{ $detail?->insuranceHeading?->name }}</span>
                                    <input type="hidden" name="heading_id[]" value="{{ $detail->heading_id }}">
                                </td>
                                <td id="scrutiny_bill_amount{{ $loop->iteration }}">
                                    <span>{{ $detail->bill_amount }}</span>
                                    <input type="hidden" name="bill_amount[]" value="{{ $detail->bill_amount }}">
                                </td>
                                <td id="scrutiny_approved_amount{{ $loop->iteration }}">
                                    <span>{{ $detail->approved_amount }}</span>
                                    <input type="hidden" name="approved_amount[]"
                                        value="{{ $detail->approved_amount }}">
                                </td>
                                <td id="scrutiny_deduction{{ $loop->iteration }}">
                                    <span>{{ $detail->deduct_amount }}</span>
                                    <input type="hidden" name="deduct_amount[]"
                                        value="{{ $detail->deduct_amount }}">
                                </td>
                                <td id="scrutiny_remarks{{ $loop->iteration }}">
                                    <span>{{ $detail->remarks }}</span>
                                    <input type="hidden" name="remarks[]" value="{{ $detail->remarks }}">
                                </td>
                                <td>
                                    <input type="hidden" name="scrunity_details_ids[]"
                                        value="{{ $detail->id }}" />
                                    @if ($access['isedit'] == 'Y')
                                        <button type="button" data-scrunity_details_id="{{ $detail->id }}"
                                            class="btn btn-warning btn-sm text-white scrutinyEditRow"
                                            data-row_no="{{ $loop->iteration }}"><i class="fas fa-edit"></i>
                                            Edit</button>
                                    @endif
                                    @if ($access['isdelete'] == 'Y')
                                        <button type="button" data-scrunity_details_id="{{ $detail->id }}"
                                            class="btn btn-danger btn-sm deleteRow"
                                            data-row_no="{{ $loop->iteration }}"
                                            data-url="{{ route('scrutinydetail.destroyScrunity', $detail->id) }}"><i
                                                class="fas fa-trash"></i> Delete</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif

                    <tr id="total_row">
                        <td colspan="4" class="text-right"><span class="fw-bold">Total</span></td>
                        <td id="scrutiny_total_bill_amount">
                            {{ isset($claims[0]?->scrunity?->details) ? $claims[0]?->scrunity?->details->sum('bill_amount') : 0 }}
                        </td>
                        <td id="scrutiny_total_approved_amount">
                            {{ isset($claims[0]?->scrunity?->details) ? $claims[0]?->scrunity?->details->sum('approved_amount') : 0 }}
                        </td>
                        <td id="scrutiny_total_deduct_amount">
                            {{ isset($claims[0]?->scrunity?->details) ? $claims[0]?->scrunity?->details->sum('deduct_amount') : 0 }}
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
                @if ($access['isinsert'] == 'Y' && $type == 'screening')
                    <tfoot
                        class="{{ isset($claims[0]?->scrunity?->details) && count($claims[0]?->scrunity?->details) > 0 ? '' : 'd-none' }}">
                        <tr>
                            <td colspan="7">&nbsp;</td>
                            <td colspan="2">
                                <button type="button" class="btnsendData btn btn-danger btn-sm "
                                    id="cancelBtn">Cancel</button>
                                <button type="button" id="saveAsDraftlBtn"
                                    class="btnsendData btn btn-warning text-white btn-sm ">Save As Draft</button>
                                @if (isset($claims[0]) && $claims[0]->is_hold == 'N')
                                    <button type="submit" id="saveSubmitClaim"
                                        class="btnsendData btn btn-success btn-sm">Request For
                                        Verification</button>
                                @endif
                            </td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </form>
</div>
{{-- @push('scripts') --}}
<script>
    $(document).ready(function() {
        let rejectionReasonPopoverButton = document.getElementById('rejectionReasonPopoverButton');
        if (rejectionReasonPopoverButton) {
            const popoverTrigger = new bootstrap.Popover(rejectionReasonPopoverButton, {
                trigger: 'hover',
                placement: 'right', // 'top', 'right', 'bottom', 'left'
                template: `
                <div class="popover custom-popover" role="tooltip">
                    <div class="popover-arrow"></div>
                    <h3 class="popover-header"></h3>
                    <div class="popover-body"></div>
                </div>
            `
            });
        }
        $('#balance-detail-info').empty();
        const userPolicy = @json($userPolicy);
        $(document).on('change', '#scrutiny_title', function() {
            
            let selectedTitle = $(this).find(':selected').val();
            let selectedHeading = userPolicy.filter(function(item) {
                return item.heading_id == selectedTitle;
            });
            if (selectedTitle) {
                
                $('#scrutiny_bill_amount').attr('max', selectedHeading[0].insuranced_amount -
                    selectedHeading[0].claimed_amount);
                } else {
                $('#scrutiny_bill_amount').attr('max', 0);
                
            }
        })
        const totalInsurance = {{ $totalInsurance }}; // Example total insurance amount
        let totalClaimAMount = 0;
        // Populate the balance details
        let balanceDetailInfo = $('#balance-detail-info');
        let totalClaimedAmount = 0;

        userPolicy.forEach(item => {
            let headingName = toTitleCase(item.heading_name);
            let claimedAmount = item.claimed_amount;
            let insurancedAmount = item.insuranced_amount;
            totalClaimedAmount += claimedAmount;

            balanceDetailInfo.append(`
            <div class="col-md-5">${headingName}: </div>
            <div class="col-md-7">Rs.${claimedAmount}/Rs.${insurancedAmount}</div>
        `);
        });

        // Populate the total balance
        $('#total-balance').html('Total: Rs.' + totalClaimedAmount + '/Rs.' + totalInsurance);


        // Function to convert a string to title case
        function toTitleCase(str) {
            return str.toLowerCase().replace(/\b\w/g, function(l) {
                return l.toUpperCase();
            });
        }
        const allClaims = @json($claims);
        const bills = [];
        const reports = [];
        $('#billSelect option[value!=""]').remove();
        $('#reportSelect option[value!=""]').remove();
        let billIndex = 0;
        let reportIndex = 0;
        $.each(allClaims, function(index, claim) {
            if (claim.document_type === 'bill') {
                bills.push(claim);
                $("#billSelect").append(
                    '<option value="' +
                    claim.id +
                    '" data-id="' +
                    billIndex +
                    '"' +
                    ">" +
                    claim.bill_file_name +
                    "</option>"
                );
                billIndex++;
            } else {
                reports.push(claim);
                $("#reportSelect").append(
                    '<option value="' +
                    claim.id +
                    '" data-id="' +
                    reportIndex +
                    '"' +
                    ">" +
                    claim.bill_file_name +
                    "</option>"
                );
                reportIndex++;
            }
            totalClaimAMount += parseInt(claim.bill_amount);
        })

        $('#totalClaimAmt').html(totalClaimAMount.toLocaleString('en-IN'));
        $('#claimspanid').html(allClaims[0].claim_id)
        let currentIndex = 0;
        let prescriptionCurrentIndex = 0;
        const baseURL = '{{ url('/') }}';
        let imageEditor;

        //for bill


        function updateSlider() {
            const currentImage = bills[currentIndex];
            const sub_heading = currentImage.sub_heading_id;
            const headings = currentImage.member.current_member_policy.group.headings;
            console.log(headings);


            let matchedHeading = headings.find(heading => {
                let exclusive = heading.exclusive ? JSON.parse(heading.exclusive) : [];
                return heading.heading_id == sub_heading || exclusive.includes(sub_heading);
            });

            if (matchedHeading) {
                console.log(matchedHeading);

                let limitData = matchedHeading.limit ? JSON.parse(matchedHeading.limit) : {};
                let limitTypeData = matchedHeading.limit_type ? JSON.parse(matchedHeading.limit_type) : {};

                let limit = limitData[sub_heading] || 'N/A';
                let limit_type = limitTypeData[sub_heading] || 'N/A';

                // console.log('Limit:', limit);
                // console.log('Limit Type:', limit_type);
                if (limit !== "N/A") {
                    $("#addLimit").text([" Limit Type: " + limit_type, " Limit: " + limit]);
                }
            }

            $('#slider-image').attr('src', baseURL + '/' + currentImage.file_path);
            $('#documentName').text(currentImage.bill_file_name);
            $('#documentType').text(currentImage.document_type);
            $('#editClaim').attr('data-id', currentIndex);
            $('#addClaim').attr('data-id', currentIndex);
            $('#addClaim').attr('data-sub_heading_id', currentImage.sub_heading_id);
            $('#counterSpan').text((currentIndex + 1) + '/' + bills.length);
            $('#prevBtn').prop('disabled', currentIndex === 0);
            $('#nextBtn').prop('disabled', currentIndex === bills.length - 1);
        }

        $(document).on('change', '#billSelect', function() {
            let currentlySelected = $(this).find(':selected').attr('data-id');
            currentIndex = parseInt(currentlySelected);
            $('#counterSpan').text(' ');
            updateSlider();
        });

        $('#prevBtn').click(function() {
            if (currentIndex > 0) {
                currentIndex--;
                updateSlider();
            }
        });
        $('#nextBtn').click(function() {
            if (currentIndex < bills.length - 1) {
                currentIndex++;
                updateSlider();
            }
        });
        //for reports

        function prescriptionUpdateSlider() {
            const prescriptionCurrentImage = reports[prescriptionCurrentIndex];
            $('#prescription-slider-image').attr('src', baseURL + '/' + prescriptionCurrentImage.file_path);
            $('#prescriptionName').text(prescriptionCurrentImage.bill_file_name);
            $('#prescriptionType').text(prescriptionCurrentImage.document_type);
            $('#prescriptionEditClaim').attr('data-id', prescriptionCurrentIndex);
            $('#prescriptionAddClaim').attr('data-id', prescriptionCurrentIndex);
            $('#prescriptionCounterSpan').text((prescriptionCurrentIndex + 1) + '/' + reports.length);
            $('#prescriptionPrevBtn').prop('disabled', prescriptionCurrentIndex === 0);
            $('#prescriptionNextBtn').prop('disabled', prescriptionCurrentIndex === reports.length - 1);
        }

        $('#prescriptionPrevBtn').click(function() {
            if (prescriptionCurrentIndex > 0) {
                prescriptionCurrentIndex--;
                prescriptionUpdateSlider();
            }
        });

        $('#prescriptionNextBtn').click(function() {
            if (prescriptionCurrentIndex < reports.length - 1) {
                prescriptionCurrentIndex++;
                prescriptionUpdateSlider();
            }
        });

        // Initialize the slider
        if (bills.length > 0) {
            $('#editClaim').attr('hidden', false);
            $('#addClaim').attr('hidden', false);
            updateSlider();
        } else {
            $('#editClaim').attr('hidden', true);
            $('#addClaim').attr('hidden', true);
        }
        if (reports.length > 0) {
            $('#prescriptionEditClaim').attr('hidden', false);
            $('#prescriptionAddClaim').attr('hidden', false);
            prescriptionUpdateSlider();
        } else {

            $('#prescriptionEditClaim').attr('hidden', true);
            $('#prescriptionAddClaim').attr('hidden', true);
        }
        let zoomLevel = 1;

        $('#embeddedSection').on('wheel', function(event) {
            event.preventDefault();
            if (event.originalEvent.deltaY < 0) {
                // Scroll up, zoom in
                zoomLevel += 0.1;
            } else {
                // Scroll down, zoom out
                zoomLevel -= 0.1;
            }
            zoomLevel = Math.min(Math.max(1, zoomLevel), 3); // Limit zoom between 1x and 3x
            $('#slider-image').css('transform', `scale(${zoomLevel})`);
        });
        $(document).on('click', '#addClaim', function() {
            let details = bills[$(this).attr('data-id')];
            console.log(details.member.current_member_policy.group.headings);
            let subheading_id = $(this).attr('data-sub_heading_id');
            // let currentda=
            $('#scrutiny_bill_amount').val(details.bill_amount).trigger('keyup');
            $('#scrutiny_bill_no').val(details.bill_file_name).trigger('keyup');
            $('#scrutiny_title').val(details.heading_id).trigger('change');
        });
        $(document).on('click', '#editClaim', function() {
            $('.documentEdit').attr('hidden', false);
            $('.documentEditHid').attr('hidden', true);
            let details = bills[$(this).attr('data-id')];
            imageEditor = new tui.ImageEditor('#tui-image-editor-container', {
                includeUI: {
                    loadImage: {
                        path: baseURL + '/' + details.file_path,
                        name: 'Sample Image'
                    },
                    theme: {},
                    menu: ['crop', 'flip', 'rotate', 'draw', 'shape', 'icon', 'filter', 'text'],
                    initMenu: 'draw',
                    uiSize: {
                        width: '1000%',
                        height: '700px'
                    }
                },
                cssMaxWidth: 1000,
                cssMaxHeight: 700,
                usageStatistics: false
            });

        });
        $(document).on('click', '#saveEditImage', function() {
            if (imageEditor) {
                const dataURL = imageEditor.toDataURL();
                const blob = dataURLToBlob(dataURL);

                // Create a new File object
                const file = new File([blob], 'edited-image.png', {
                    type: 'image/png'
                });

                // Update the file input with the new File object
                const fileInput = document.getElementById('scrutiny_file');
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                fileInput.files = dataTransfer.files;

                // Close the editor
                $('.documentEdit').attr('hidden', true);
                $('.documentEditHid').attr('hidden', false);
                if (imageEditor) {
                    imageEditor.destroy();
                    imageEditor = null;
                }
            }
        });
        // imageEditor.ui.resizeEditor();
        $(document).on('click', '#editorCloseBtn', function() {
            $('.documentEdit').attr('hidden', true);
            $('.documentEditHid').attr('hidden', false);
        });

        function dataURLToBlob(dataURL) {
            const parts = dataURL.split(';base64,');
            const byteString = atob(parts[1]);
            const mimeString = parts[0].split(':')[1];
            const buffer = new ArrayBuffer(byteString.length);
            const uintArray = new Uint8Array(buffer);
            for (let i = 0; i < byteString.length; i++) {
                uintArray[i] = byteString.charCodeAt(i);
            }
            return new Blob([buffer], {
                type: mimeString
            });
        }

        $(document).on('change', '#reportSelect', function() {
            let currentlySelected = $(this).find(':selected').attr('data-id');
            prescriptionCurrentIndex = parseInt(currentlySelected);
            $('#prescriptionCounterSpan').text('');
            prescriptionUpdateSlider();
        });
        let prescriptionZoomLevel = 1;
        $('#prescriptionEmbeddedSection').on('wheel', function(event) {
            event.preventDefault();
            if (event.originalEvent.deltaY < 0) {
                // Scroll up, zoom in
                prescriptionZoomLevel += 0.1;
            } else {
                // Scroll down, zoom out
                prescriptionZoomLevel -= 0.1;
            }
            prescriptionZoomLevel = Math.min(Math.max(1, prescriptionZoomLevel),
                3); // Limit zoom between 1x and 3x
            $('#prescription-slider-image').css('transform', `scale(${prescriptionZoomLevel})`);
        });
        $(document).on('click', '#prescriptionAddClaim', function() {
            let details = reports[$(this).attr('data-id')];
            // alert(details.bill_amount);
            // $('#scrutiny_bill_amount').val(details.bill_amount).trigger('keyup');
            $('#scrutiny_bill_no').val(details.bill_file_name).trigger('keyup');
            $('#scrutiny_title').val(details.heading_id).trigger('change');
        });
        $(document).on('click', '#prescriptionEditClaim', function() {
            $('.prescriptionEdit').attr('hidden', false);
            $('.prescriptionEditHid').attr('hidden', true);
            let details = reports[$(this).attr('data-id')];
            prescriptImageEditor = new tui.ImageEditor('#prescription-tui-image-editor-container', {
                includeUI: {
                    loadImage: {
                        path: baseURL + '/' + details.file_path,
                        name: 'Sample Image'
                    },
                    theme: {},
                    menu: ['crop', 'flip', 'rotate', 'draw', 'shape', 'icon', 'filter', 'text'],
                    initMenu: 'draw',
                    uiSize: {
                        width: '1000%',
                        height: '700px'
                    }
                },
                cssMaxWidth: 1000,
                cssMaxHeight: 700,
                usageStatistics: false
            });
            prescriptImageEditor.addText('init text', {
                styles: {
                    fill: '#000',
                    fontSize: 20,
                    fontWeight: 'bold'
                },
                position: {
                    x: 10,
                    y: 10
                }
            }).then(objectProps => {
                console.log(objectProps.id);
            });
        });
        $(document).on('click', '#prescriptionSaveEditImage', function() {
            if (prescriptImageEditor) {
                const dataURL = prescriptImageEditor.toDataURL();
                const blob = dataURLToBlob(dataURL);

                // Create a new File object
                const file = new File([blob], 'edited-image.png', {
                    type: 'image/png'
                });

                // Update the file input with the new File object
                const fileInput = document.getElementById('scrutiny_file');
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                fileInput.files = dataTransfer.files;

                // Close the editor
                $('.prescriptionEdit').attr('hidden', true);
                $('.prescriptionEditHid').attr('hidden', false);
                if (prescriptImageEditor) {
                    prescriptImageEditor.destroy();
                    prescriptImageEditor = null;
                }
            }
        });
        // imageEditor.ui.resizeEditor();
        $(document).on('click', '#prescriptionEditorCloseBtn', function() {
            $('.prescriptionEdit').attr('hidden', true);
            $('.prescriptionEditHid').attr('hidden', false);
        });


    });
</script>
{{-- @endpush --}}
