@extends('backend.layout.main')
@section('main')
    <style>
        .labelsmaller,
        input[type=text],
        input[type=date],
        input[type=file],
        select,
        textarea,
        input[type=text]::placeholder,
        input[type=date]::placeholder,
        input[type=file]::placeholder,
        select::placeholder,
        textarea::placeholder {
            font-size: smaller;
        }
    </style>

    <div class="row">
        <p class="mb-0 text-uppercase col-10 "><strong>Reports</strong></p>
    </div>
    <hr class="m-0 mb-1">
    <div class="card">
        <div class="card-body">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-claim-details" data-bs-toggle="tab" data-bs-target="#nav-claim"
                        type="button" role="tab" aria-controls="nav-claim" aria-selected="true">Claim Detail</button>
                    <button class="nav-link" id="nav-client-details" data-bs-toggle="tab" data-bs-target="#nav-client"
                        type="button" role="tab" aria-controls="nav-client" aria-selected="false">Client
                        Detail</button>
                    {{-- <button class="nav-link" id="nav-policy-details" data-bs-toggle="tab" data-bs-target="#nav-policy" type="button"
                        role="tab" aria-controls="nav-policy" aria-selected="false">Policy Detail</button>
                    <button class="nav-link" id="nav-claim-approved" data-bs-toggle="tab" data-bs-target="#nav-claim-approved" type="button"
                        role="tab" aria-controls="nav-claim-approved" aria-selected="false">Claim Vs Approved</button> --}}
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-claim" role="tabpanel" aria-labelledby="nav-claim-details">
                    <div class="row my-2">
                        <div class="row col-md-12">
                            <form action="#" id="claim_report_form" enctype="multipart/form-data">
                                <div class="row mx-0 px-0" id="employeeDetailsDiv">

                                    <div class="form-group col-md-3">
                                        <div class="form-group row">
                                            <label class="labelsmaller col-sm-4 " for="employee_id"><small>From
                                                    date:</small>
                                            </label>
                                            <div class="col-sm-8  p-0">
                                                <input type="date" name="from_date" id="claim_from_date"
                                                    class="form-control  form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="form-group row">
                                            <label class="labelsmaller col-sm-4" for="destination_id"> To Date:</label>
                                            <div class="col-sm-8  p-0 ">
                                                <input type="date" name="to_date" id="claim_to_date"
                                                    class="form-control  form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="form-group row">
                                            <label class="labelsmaller col-sm-4  " for="employee_name">Client:</label>
                                            <div class="col-sm-8  p-0 ">
                                                <select name="client" id="claim_client"
                                                    class="labelsmaller form-select form-select-sm">
                                                    <option value="" selected disabled>Select Clients</option>
                                                    @foreach ($clients as $client)
                                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="form-group col-md-3">
                                        <div class="form-group row">
                                            <label class="labelsmaller  col-sm-4  p-0" for="member_id">Emp Name:</label>
                                            <div class="col-sm-8  p-0 ">
                                                <select id="claim_emp_name" class="labelsmaller form-select form-select-sm"
                                                    name="claim_emp_name" data-placeholder="select member">
                                                    <option value="">Select Member </option>

                                                </select>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="form-group col-md-3">
                                        <div class="form-group row">
                                            <label class="labelsmaller  col-sm-4  " for="relation_id">Heading:</label>
                                            <div class="col-sm-8  p-0 ">
                                                <select name="claim_heading" id="claim_heading"
                                                    class="labelsmaller form-select form-select-sm ">
                                                    <option selected disabled value="">Select Heading</option>
                                                    @foreach ($headings as $heading)
                                                        <option value="{{ $heading->id }}">{{ $heading->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 mt-2">
                                        <div class="row">
                                            <label class="labelsmaller col-sm-3 col-form-label"
                                                for="branch_id"><small>Type:</small></label>
                                            <div class="col-sm-9 p-0">
                                                <div class="form-check form-check-inline ">
                                                    <input class="form-check-input" type="radio" name="claim_type"
                                                        id="groupOption" value="group" checked>
                                                    <label class="form-check-label" for="groupOption"><small>Group</small>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="claim_type"
                                                        id="nonGroupOption" value="non-group">
                                                    <label class="form-check-label"
                                                        for="nonGroupOption"><small>Non-Group</small></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-8 mt-2">
                                        <div class="form-group row">
                                            <label class="labelsmaller col-sm-3">Status:</label>
                                            <div class="col-sm-9  p-0 ">
                                                <div class="form-check form-check-inline ">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                                                        value="Received" name="claim_status[]">
                                                    <label class="form-check-label" for="inlineCheckbox1">Pending</label>
                                                </div>
                                                <div class="form-check form-check-inline ">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2"
                                                        name="claim_status[]" value="Registered">
                                                    <label class="form-check-label" for="inlineCheckbox2"
                                                        name="claim_status[]">Registration</label>
                                                </div>
                                                <div class="form-check form-check-inline ">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3"
                                                        name="claim_status[]" value="Approved">
                                                    <label class="form-check-label" for="inlineCheckbox3">Approved</label>
                                                </div>
                                                <div class="form-check form-check-inline ">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox4"
                                                        name="claim_status[]" value="Rejected">
                                                    <label class="form-check-label" for="inlineCheckbox4">Rejected</label>
                                                </div>
                                                <div class="form-check form-check-inline ">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox5"
                                                        name="claim_status[]" value="Scrunity">
                                                    <label class="form-check-label"
                                                        for="inlineCheckbox5">Processed</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 mt-2">
                                        <div class="form-group row">
                                            <label class="labelsmaller col-sm-4 " for="relation_id">SubHead:</label>
                                            <div class="col-sm-8  p-0">
                                                <select name="claim_sub_heading" id="claim_sub_heading"
                                                    class="labelsmaller form-select form-select-sm ">
                                                    <option selected disabled value="">Select Sub-Heading</option>
                                                    @foreach ($headings as $heading)
                                                        <option value="{{ $heading->id }}">{{ $heading->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3 mt-2">
                                        <div class="form-group row">
                                            <label class="labelsmaller col-sm-4 " for="claim_claim_no"><small>Claim
                                                    ID:</small>
                                            </label>
                                            <div class="col-sm-8  p-0">
                                                <input type="text" name="from_date" id="claim_claim_no"
                                                    class="form-control  form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 mt-2">
                                        <div class="form-group row">
                                            <label class="labelsmaller col-sm-4 " for="claim_policy_no"><small>Policy
                                                    No:</small>
                                            </label>
                                            <div class="col-sm-8  p-0">
                                                <input type="text" name="policy_no" id="claim_policy_no"
                                                    class="form-control  form-control-sm">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3 mt-2 d-flex justify-content-center">
                                        <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                            <button class="btn btn-sm btn-info  px-4"
                                                id="claim_details_search"type="button">Filter</button>
                                            <button class="btn btn-sm btn-danger  px-4" id="claim_details_search_clear"
                                                type="button"> <i class="fas fa-sync-alt"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="claim-details-datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S.N.</th>
                                    <th>Policy No.</th>
                                    <th>Claim ID</th>
                                    <th>Intimation Date</th>
                                    <th>Registered Date</th>
                                    <th>Processed Date</th>
                                    <th>Client</th>
                                    <th>Member</th>
                                    <th>Dependent</th>
                                    <th>Heading</th>
                                    <th>Sub-Heading</th>
                                    <th>Claim Amount</th>
                                    <th>Status</th>
                                    <th>Approved Amount</th>
                                    <th>Approved Date</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-client" role="tabpanel" aria-labelledby="nav-client-details">
                    <div class="row my-2">
                        <div class="row col-md-12">
                            <form action="#" id="client_report_form" enctype="multipart/form-data">
                                <div class="row mx-0 px-0" id="employeeDetailsDiv">
                                    <div class="form-group col-md-3">
                                        <div class="form-group row">
                                            <label class="labelsmaller col-sm-4" for="employee_id"><small>From
                                                    date:</small>
                                            </label>
                                            <div class="col-sm-8  p-0">
                                                <input type="date" name="from_date" id="client_from_date"
                                                    class="form-control  form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="form-group row">
                                            <label class="labelsmaller col-sm-4" for="destination_id">To
                                                Date:</label>
                                            <div class="col-sm-8  p-0 ">
                                                <input type="date" name="to_date" id="client_to_date"
                                                    class="form-control  form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="form-group col-md-3">
                                        <div class="row">
                                            <label class="labelsmaller col-sm-3 col-form-label"
                                                for="branch_id"><small>Type:</small></label>
                                            <div class="col-sm-9 p-0">
                                                <div class="form-check form-check-inline ">
                                                    <input class="form-check-input" type="radio" name="client_type"
                                                        id="groupOption" value="group" checked>
                                                    <label class="form-check-label" for="groupOption"><small>Group</small>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="client_type"
                                                        id="nonGroupOption" value="non-group">
                                                    <label class="form-check-label"
                                                        for="nonGroupOption"><small>Non-Group</small></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}

                                    <div class="form-group col-md-3">
                                        <div class="form-group row">
                                            <label class="labelsmaller col-sm-4  " for="employee_name">Client:</label>
                                            <div class="col-sm-8  p-0 ">
                                                <select name="client" id="client_client"
                                                    class="labelsmaller form-select form-select-sm">
                                                    <option value="" selected disabled>Select Clients</option>
                                                    @foreach ($clients as $client)
                                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="form-group row">
                                            <label class="labelsmaller  col-sm-4  " for="relation_id">Heading:</label>
                                            <div class="col-sm-8  p-0 ">
                                                <select name="claim_heading" id="client_heading"
                                                    class="labelsmaller form-select form-select-sm ">
                                                    <option selected disabled value="">Select Heading</option>
                                                    @foreach ($headings as $heading)
                                                        <option value="{{ $heading->id }}">{{ $heading->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="form-group col-md-4">
                                        <div class="form-group row">
                                            <label class="labelsmaller col-sm-4" for="relation_id">SubHeading:</label>
                                            <div class="col-sm-8   ">
                                                <select name="claim_sub_heading" id="client_sub_heading"
                                                    class="labelsmaller form-select form-select-sm ">
                                                    <option selected disabled value="">Select Sub-Heading</option>
                                                    @foreach ($headings as $heading)
                                                        <option value="{{ $heading->id }}">{{ $heading->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="form-group col-md-3 mt-2">
                                        <div class="form-group row">
                                            <label class="labelsmaller col-sm-4 " for="client_policy_no"><small>Policy
                                                    No:</small>
                                            </label>
                                            <div class="col-sm-8  p-0">
                                                <input type="text" name="policy_no" id="client_policy_no"
                                                    class="form-control  form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 mt-2">
                                        <div class="form-group row">
                                            <label class="labelsmaller col-sm-2">Status:</label>
                                            <div class="col-sm-10  p-0 ">
                                                <div class="form-check form-check-inline ">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                                                        value="All" name="client_status[]" checked>
                                                    <label class="form-check-label" for="inlineCheckbox1">All</label>
                                                </div>
                                                <div class="form-check form-check-inline ">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2"
                                                        name="client_status[]" value="Y">
                                                    <label class="form-check-label" for="inlineCheckbox2">Active</label>
                                                </div>
                                                <div class="form-check form-check-inline ">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2"
                                                        name="client_status[]" value="N">
                                                    <label class="form-check-label" for="inlineCheckbox2">Inactive</label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center mt-2 form-group col-md-3">
                                        <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                            <button class="btn btn-sm btn-info  px-4"
                                                id="client_details_search"type="button">Filter</button>
                                            <button class="btn btn-sm btn-danger  px-4" id="client_details_search_clear"
                                                type="button"> <i class="fas fa-sync-alt"></i></button>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table id="client-details-datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S.N.</th>
                                    <th>Policy No.</th>
                                    <th>Client Name</th>
                                    <th>Issue Date</th>
                                    <th>Valid From</th>
                                    <th>Valid Till</th>
                                    <th>Total Sum Insured</th>
                                    {{-- <th>Group</th> --}}
                                    <th>Initimation Days</th>
                                    <th>Total Claim Count</th>
                                    <th>Claim Amount</th>
                                    <th>Paid Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="detailsCLaimsOfCLaimIdModal">
        <div class="modal-dialog modal-fullscreen modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header ">
                    <strong class="modal-title text-dark">All claims of Claim Id : <span id="modalTitleClaimID"></span>
                    </strong>
                    <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                        <i class="material-icons-outlined">close</i>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="form-body">
                        <div class="table-responsive">
                            <table id="datatables-reponsive-individual"
                                class="table-striped  labelsmaller table table-striped table-bordered cell-border">
                                <thead>
                                    <tr>
                                        <th>S.N.</th>
                                        <th>Claim Id</th>
                                        <th>Emp Id</th>
                                        <th>Emp Name</th>
                                        <th>Designation</th>
                                        <th>Branch </th>
                                        <th>Member</th>
                                        <th>Relation</th>
                                        <th>Policy No.</th>
                                        <th>Bill Amount</th>
                                        <th>Document Type</th>
                                        <th>File</th>
                                        <th>Size</th>
                                        <th>Remark</th>
                                        <th>Document Date</th>
                                        <th>Heading</th>
                                        <th>Sub Heading</th>
                                        <th>Clinical Facility</th>
                                        <th>Diagnosis/Treatment</th>
                                        <th>Claim Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot></tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
