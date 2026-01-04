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

        /* Style for the custom select container */
        .custom-select-wrapper {
            position: relative;
            width: 40px;
            /* Adjust the width for your icon size */
        }

        /* Custom Select button style */
        .custom-select {
            display: flex;
            align-items: center;
            cursor: pointer;
            padding: 0 10px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            height: calc(1.75em + .75rem + 2px);
        }

        /* Custom flag image inside the select */
        .flag-img {
            width: 20px;
            /* Adjust size of the flag */
            height: auto;
            margin-right: 5px;
        }

        /* Custom dropdown list style */
        .custom-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            z-index: 1;
        }

        .custom-option {
            display: flex;
            align-items: center;
            padding: 5px;
            cursor: pointer;
        }

        .custom-option:hover {
            background-color: #f1f1f1;
        }

        /* Show the dropdown when the select box is clicked */
        .custom-select-wrapper.open .custom-dropdown {
            display: block;
        }
    </style>
    {{-- <style>
        /* For single select elements */
        .select2-container--bootstrap-5 .select2-selection--single {
            border: 1px solid #007bff !important; /* Change to your desired border color and style */
        }

        /* For multiple select elements */
        .select2-container--bootstrap-5 .select2-selection--multiple {
            border: 1px solid #007bff !important; /* Change to your desired border color and style */
        }
        /* Optionally, customize the dropdown's border */
        .select2-container--bootstrap-5 .select2-results__options {
            border: 1px solid #007bff !important; /* Change to your desired border color and style */
        }
    </style> --}}


    <div class="row">
        <p class="mb-0 text-uppercase col-10 "><strong>{{ $title }}</strong></p>
    </div>
    <hr class="m-0 mb-1">
    <div class="card">
        <div class="card-body">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-new-tab" data-bs-toggle="tab" data-bs-target="#nav-new"
                        type="button" role="tab" aria-controls="nav-new" aria-selected="true">New</button>
                    <button class="nav-link" id="nav-resubmission-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-resubmission" type="button" role="tab" aria-controls="nav-resubmission"
                        aria-selected="false">Re-Submission</button>
                    <button class="nav-link" id="nav-old-tab" data-bs-toggle="tab" data-bs-target="#nav-old" type="button"
                        role="tab" aria-controls="nav-old" aria-selected="false">Old</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-new" role="tabpanel" aria-labelledby="nav-new-tab">
                    <div class="row my-2">
                        <div class="col-md-9">
                            <div class="row col-md-12">
                                <div class="row mx-0 px-0" id="employeeDetailsDiv">
                                    <div class="form-group col-md-4">
                                        <div class="form-group row">
                                            <label class="labelsmaller col-sm-4" for="employee_id">Emp Id <span
                                                    class="text-danger">*</span>:</label>
                                            <div class="col-sm-8">
                                                <select id="employee_id" data-required="true"
                                                    class="labelsmaller form-select form-select-sm" name="member_id">
                                                    <option value="" selected="" disabled="">Select Employee
                                                    </option>
                                                    @foreach ($employees as $employee)
                                                        <option value="{{ $employee->id }}"
                                                            {{ $currentUser->member_id == $employee->id ? 'selected' : '' }}>
                                                            {{ $employee?->user?->fname . ' ' . $employee?->user?->mname . ' ' . $employee?->user?->lname }}
                                                            ({{ $employee->employee_id }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group row">
                                            <label class="labelsmaller col-sm-5 px-0" for="destination_id">Designation <span
                                                    class="text-danger">*</span>:</label>
                                            {{-- <div class="col-sm px-0"> --}}
                                            <div class="col-sm ">
                                                <input type="text" class="form-control  form-control-sm"
                                                    name="destination_id" id="destination_id" readonly
                                                    placeholder="Designation">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group row">
                                            <label class="labelsmaller col-sm-4 " for="branch_id">Branch <span
                                                    class="text-danger">*</span>:</label>
                                            <div class="col-sm ">
                                                <input type="text" readonly class="form-control  form-control-sm"
                                                    name="branch_id" id="branch_id" placeholder="Branch">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md">
                                        <label class="labelsmaller" for="employee_name">Employee Name <span
                                                class="text-danger">*</span>:</label>
                                        <input type="text" readonly class="form-control  form-control-sm"
                                            name="employee_name" id="employee_name" placeholder="Employee Name" readonly>
                                    </div>
                                    <div class="form-group col-md">
                                        <label class="labelsmaller" for="member_id">Dependents :</label>
                                        <select id="member_id" class="labelsmaller form-select form-select-sm"
                                            name="relative_id" data-placeholder="select member">
                                            <option value="">Select Member </option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md">
                                        <label class="labelsmaller" for="relation_id">Relation <span
                                                class="text-danger"></span>:</label>
                                        <input type="text" readonly class="form-control  form-control-sm"
                                            name="relation_id" id="relation_id" placeholder="Relation">
                                    </div>
                                    <div class="form-group col-md">
                                        <label class="labelsmaller" for="policy_no">Policy No <span
                                                class="text-danger">*</span>:</label>
                                        <input type="text" readonly class="form-control  form-control-sm"
                                            name="policy_no" id="policy_no" placeholder="Policy No">
                                    </div>
                                </div>
                                <form id="addDataToTableForm">
                                    <div class="row my-1">
                                        <div class="form-group col-md-3 mb-1">
                                            <label class="labelsmaller" for="heading_id">Claim Heading <span
                                                    class="text-danger">*</span>:</label>
                                            <select id="heading_id"
                                                class="labelsmaller form-select form-select-sm heading_select"
                                                data-required="true" name="heading_id">
                                                <option value="" selected="" disabled>Select Claim Heading
                                                </option>
                                                {{-- @foreach ($headings as $heading)
                                        <option value="{{$heading->id}}">{{$heading->name}}
                                        </option>
                                    @endforeach --}}
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3 mb-1">
                                            <label class="labelsmaller" for="heading_id">Claim Sub Heading <span
                                                    class="text-danger">*</span>:</label>
                                            <select id="sub_heading_id" class="labelsmaller form-select form-select-sm"
                                                data-required="true" name="sub_eading_id">
                                                <option value="" selected="" disabled>Select Claim Sub Heading
                                                </option>

                                            </select>
                                        </div>
                                        <div class="form-group col-md-3 mb-1">
                                            <label class="labelsmaller" for="document_type_id">Document Type <span
                                                    class="text-danger">*</span>:</label>
                                            <select id="document_type_id" data-required="true"
                                                class="labelsmaller form-select form-select-sm" name="document_type">
                                                <option value="" selected="" disabled>Select Document Type
                                                </option>
                                                <option value="bill">Bill/Invoices </option>
                                                <option value="prescription">
                                                    Prescriptions/Clinical Notes </option>
                                                <option value="report">Reports </option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3 mb-1">
                                            <label class="labelsmaller" for="bill_file">File <span
                                                    class="text-danger">*</span>:
                                                <small class="text-danger">(Only:
                                                    JPEG, PNG, JPG )</small></label>
                                            <input data-required="true" type="file"
                                                class="form-control  form-control-sm" name="bill_file" id="bill_file"
                                                placeholder="File">
                                        </div>
                                        <div class="form-group col-md-3 mb-1">
                                            <label class="labelsmaller" for="bill_file_name">File Name <span
                                                    class="text-danger">*</span>:</label>
                                            <input data-required="true" type="text"
                                                class="form-control  form-control-sm" name="bill_file_name"
                                                id="bill_file_name" accept="image/png, image/jpeg, application/pdf"
                                                placeholder="File Name">
                                        </div>
                                        <div class="form-group col-md-3 mb-1">
                                            <label class="labelsmaller" for="document_date">Document Date <span
                                                    class="text-danger">*</span>:</label>
                                            {{-- <input data-required="true" type="date"
                                                class="form-control  form-control-sm" name="document_date"
                                                id="document_date" placeholder="Document Date"> --}}
                                            <div class="input-group englishNepaliDiv" data-type="new">
                                                <input data-required="true" type="date"
                                                    class="form-control form-control-sm" name="document_date"
                                                    id="document_date" placeholder="Document Date" disabled>
                                                <input data-required="true" type="text"
                                                    class="form-control form-control-sm" id="document_date_bs"
                                                    placeholder="Document Date" disabled hidden>
                                                <div class="input-group-append">
                                                    <div class="custom-select-wrapper">
                                                        <div class="custom-select customSelect" id="new_customSelect">
                                                            <img src="{{ asset('/admin/assets/images/flags/united-states.png') }}"
                                                                alt="US Flag" class="flag-img">
                                                            {{-- <span class="selected-text">US</span> --}}
                                                        </div>
                                                        <div class="custom-dropdown">
                                                            <div class="custom-option" data-value="ad">
                                                                <img src="{{ asset('/admin/assets/images/flags/united-states.png') }}"
                                                                    alt="US Flag" class="flag-img">

                                                            </div>
                                                            <div class="custom-option" data-value="bs">
                                                                <img src="{{ asset('/admin/assets/images/flags/nepal.png') }}"
                                                                    alt="Nepal Flag" class="flag-img">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3 mb-1">
                                            <label class="labelsmaller" for="bill_amount">Bill Amount <span
                                                    class="text-danger">*</span>:</label>
                                            <input data-required="true" type="text"
                                                class="form-control  form-control-sm" name="bill_amount" id="bill_amount"
                                                placeholder="Bill Amount">
                                        </div>
                                        <div class="form-group col-md-3 mb-1">
                                            <label class="labelsmaller" for="remark">Remark:</label>
                                            <input type="text" class="form-control  form-control-sm" name="remark"
                                                id="remark" placeholder="Remark">
                                        </div>
                                        <div class="form-group col-md-3 mb-1">
                                            <label class="labelsmaller" for="clinical_facility_name">Clinical Facility
                                                Name:</label>
                                            <input type="text" class="form-control  form-control-sm"
                                                name="clinical_facility_name" id="clinical_facility_name"
                                                placeholder="Clinical Facility Name">
                                        </div>
                                        <div class="form-group col-md-3 mb-1">
                                            <label class="labelsmaller"
                                                for="diagnosis_treatment">Diagnosis/Treatment:</label>
                                            <input type="text" class="form-control  form-control-sm"
                                                name="diagnosis_treatment" id="diagnosis_treatment"
                                                placeholder="Diagnosis/Treatment">
                                        </div>
                                        <div class="form-group col-md-3 mb-1">
                                            @if ($access['isinsert'] == 'Y')
                                                <label class="labelsmaller" for="" class="d-block">&nbsp;</label>
                                                <span id="clearBtnAppend">

                                                </span>
                                                <button type="submit"
                                                    class="btn btn-success labelsmaller btn-sm float-end"
                                                    id="addDataToTableAdd">Add <i class="fas fa-plus "></i></button>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md border border-info rounded " style="position: relative;">
                            <p class="labelsmaller" style="position: absolute;top: -10px;left:20px;background:white; ">
                                <strong>
                                    Balance Detail </strong>
                            </p>
                            <div class="row col-12 m-0 p-0" style="width:100%;height:100%;">
                                <p class="labelsmaller mt-4 mx-0 px-0">
                                    <span id="headingSpan">
                                    </span>
                                    <span class="float-end">
                                        <span class=" d-block labelsmaller mt-3">Expiry Date: <span id="expiryDate">
                                                YYYY/MM/DD &nbsp;</span> </span>
                                        <span class=" d-block  labelsmaller"><strong>Total: <span>Rs. <b
                                                        id="totalInsuredAmount">0</b> / Rs. <b
                                                        id="all_totalInsuredAmount">0</b>
                                                </span>
                                            </strong>
                                        </span>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <form id="addDataToTableFormSave" enctype='multipart/form-data'
                        action="{{ route('claimsubmissions.store') }}">
                        {{-- <input type="hidden" name="clinical_facility_name" id="clinical_facility_name_section" /> --}}
                        <div class="table-responsive">
                            <table id="addDataToTable" class="table table-striped table-bordered labelsmaller">
                                <thead>
                                    <tr>
                                        <th>S.N.</th>
                                        <th>Document Type</th>
                                        <th>File Name</th>
                                        <th>Size</th>
                                        <th>Remark</th>
                                        <th>Document Date</th>
                                        <th>Bill Amount</th>
                                        <th>Heading</th>
                                        <th>Sub Heading</th>
                                        <th>Clinical Facility</th>
                                        <th style="min-width:125px">Diagnosis</th>
                                        <th style="min-width:240px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                @if ($access['isinsert'] == 'Y')
                                    <tfoot class="d-none">
                                        <tr>
                                            <td colspan="7">&nbsp;</td>
                                            <td>
                                                <button type="button" class="btnsendData btn btn-danger btn-sm "
                                                    id="cancelBtn">Cancel</button>
                                            </td>
                                            <td>
                                                <button type="button" id="saveAsDraftlBtn"
                                                    class="btnsendData btn btn-warning text-white btn-sm ">Save As
                                                    Draft</button>
                                            </td>
                                            <td>
                                                <button type="button" id="saveSubmitClaim"
                                                    class="btnsendData btn btn-success btn-sm ">Submit
                                                    Claim</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                @endif
                            </table>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="nav-resubmission" role="tabpanel" aria-labelledby="nav-resubmission-tab">
                    <div class="row my-2">
                        <div class="form-group col-md-4">
                            <div class="form-group row">
                                <label class="labelsmaller col-sm-4" for="resubmissionClaimId">Claim Id:<span
                                        class="text-danger">*</span>:</label>
                                <div class="col-sm-8 px-1">
                                    <select id="resubmission_ClaimId" class="labelsmaller form-select form-select-sm">
                                        <option value="">Select Claim Id </option>
                                        @foreach ($resubmissions as $claim)
                                            <option value="{{ $claim->claim_id }}">{{ $claim->claim_id }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="resubmission_Div" class="d-none">
                        <div class="row my-2">
                            <div class="col-md-9">
                                <div class="row col-md-12">
                                    <div class="row mx-0 px-0" id="resubmission_EmployeeDetailsDiv">
                                        <div class="form-group col-md-4">
                                            <div class="form-group row">
                                                <label class="labelsmaller col-sm-4" for="resubmission_employee_id">Emp Id
                                                    <span class="text-danger">*</span>:</label>
                                                <div class="col-sm-8 px-1">
                                                    <span class="labelsmaller" id="resubmission_employee_id"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group row">
                                                <label class="labelsmaller col-sm-5 px-0"
                                                    for="resubmission_destination_id">Designation
                                                    <span class="text-danger">*</span>:</label>
                                                <div class="col-sm px-0">
                                                    <span class="labelsmaller" id="resubmission_destination_id"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group row">
                                                <label class="labelsmaller col-sm-4 " for="resubmission_branch_id">Branch
                                                    <span class="text-danger">*</span>:</label>
                                                <div class="col-sm ">
                                                    <span class="labelsmaller" id="resubmission_branch_id"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-md">
                                            <label class="labelsmaller" for="resubmission_employee_name">Emp Name
                                                <span class="text-danger">*</span>:</label>
                                            <span class="labelsmaller" id="resubmission_employee_name"></span>
                                        </div>
                                        <div class="form-group col-md">
                                            <label class="labelsmaller" for="resubmission_member_id">Member :</label>
                                            <span class="labelsmaller" id="resubmission_member_id"></span>
                                            </span>
                                        </div>
                                        <div class="form-group col-md">
                                            <label class="labelsmaller" for="resubmission_relation_id">Relation <span
                                                    class="text-danger"></span>:</label>
                                            <sapn id="resubmission_relation_id"></sapn>
                                        </div>
                                        <div class="form-group col-md">
                                            <label class="labelsmaller" for="resubmission_policy_no">Policy No <span
                                                    class="text-danger">*</span>:</label>
                                            <span class="labelsmaller" id="resubmission_policy_no"></span>
                                        </div>
                                    </div>
                                    <form id="resubmission_AddDataToTableForm">
                                        <div class="row my-1">
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="labelsmaller" for="resubmission_heading_id">Claim Heading
                                                    <span class="text-danger">*</span>:</label>
                                                <select id="resubmission_heading_id"
                                                    class="labelsmaller form-select form-select-sm resubmission_heading_select"
                                                    data-required="true" name="heading_id">
                                                    <option value="" selected="" disabled>Select Claim Heading
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="labelsmaller" for="resubmission_heading_id">Claim Sub
                                                    Heading <span class="text-danger">*</span>:</label>
                                                <select id="resubmission_sub_heading_id"
                                                    class="labelsmaller form-select form-select-sm" data-required="true"
                                                    name="sub_eading_id">
                                                    <option value="" selected="" disabled>Select Claim Sub
                                                        Heading
                                                    </option>

                                                </select>
                                            </div>
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="labelsmaller" for="resubmission_document_type_id">Document
                                                    Type <span class="text-danger">*</span>:</label>
                                                <select id="resubmission_document_type_id" data-required="true"
                                                    class="labelsmaller form-select form-select-sm" name="document_type">
                                                    <option value="" selected="" disabled>Select Document Type
                                                    </option>
                                                    <option value="bill">Bill/Invoices </option>
                                                    <option value="prescription">
                                                        Prescriptions/Clinical Notes </option>
                                                    <option value="report">Reports </option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="labelsmaller" for="resubmission_bill_file">File <span
                                                        class="text-danger">*</span>: <small class="text-danger">(Only:
                                                        JPEG, PNG, JPG )</small></label>
                                                <input data-required="true" type="file"
                                                    class="form-control  form-control-sm" name="bill_file"
                                                    id="resubmission_bill_file" placeholder="File">
                                            </div>
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="labelsmaller" for="resubmission_bill_file_name">File Name
                                                    <span class="text-danger">*</span>:</label>
                                                <input data-required="true" type="text"
                                                    class="form-control  form-control-sm" name="bill_file_name"
                                                    id="resubmission_bill_file_name"
                                                    accept="image/png, image/jpeg, application/pdf"
                                                    placeholder="File Name">
                                            </div>
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="labelsmaller" for="resubmission_document_date">Document Date
                                                    <span class="text-danger">*</span>:</label>
                                                {{-- <input data-required="true" type="date"
                                                    class="form-control  form-control-sm" name="document_date"
                                                    id="resubmission_document_date" max="{{ date('Y-m-d') }}"
                                                    placeholder="Document Date"> --}}
                                                <div class="input-group englishNepaliDiv" data-type="resubmission">
                                                    <input data-required="true" type="date"
                                                        class="form-control form-control-sm" name="document_date"
                                                        id="resubmission_document_date" placeholder="Document Date"
                                                        disabled>
                                                    <input data-required="true" type="text"
                                                        class="form-control form-control-sm"
                                                        id="resubmission_document_date_bs" placeholder="Document Date"
                                                        disabled hidden>
                                                    <div class="input-group-append">
                                                        <div class="custom-select-wrapper">
                                                            <div class="custom-select customSelect"
                                                                id="resubmission_customSelect">
                                                                <img src="{{ asset('/admin/assets/images/flags/united-states.png') }}"
                                                                    alt="US Flag" class="flag-img">
                                                                {{-- <span class="selected-text">US</span> --}}
                                                            </div>
                                                            <div class="custom-dropdown">
                                                                <div class="custom-option" data-value="ad">
                                                                    <img src="{{ asset('/admin/assets/images/flags/united-states.png') }}"
                                                                        alt="US Flag" class="flag-img">

                                                                </div>
                                                                <div class="custom-option" data-value="bs">
                                                                    <img src="{{ asset('/admin/assets/images/flags/nepal.png') }}"
                                                                        alt="Nepal Flag" class="flag-img">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="labelsmaller" for="resubmission_bill_amount">Bill Amount
                                                    <span class="text-danger">*</span>:</label>
                                                <input data-required="true" type="text"
                                                    class="form-control  form-control-sm" name="bill_amount"
                                                    id="resubmission_bill_amount" placeholder="Bill Amount">
                                            </div>
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="labelsmaller" for="resubmission_remark">Remark:</label>
                                                <input type="text" class="form-control  form-control-sm"
                                                    name="remark" id="resubmission_remark" placeholder="Remark">
                                            </div>
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="labelsmaller"
                                                    for="resubmission_clinical_facility_name">Clinical Facility
                                                    Name:</label>
                                                <input type="text" class="form-control  form-control-sm"
                                                    name="clinical_facility_name" id="resubmission_clinical_facility_name"
                                                    placeholder="Clinical Facility Name">
                                            </div>
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="labelsmaller"
                                                    for="resubmission_diagnosis_treatment">Diagnosis/Treatment:</label>
                                                <input type="text" class="form-control  form-control-sm"
                                                    name="diagnosis_treatment" id="resubmission_diagnosis_treatment"
                                                    placeholder="Diagnosis/Treatment">
                                            </div>
                                            <div class="form-group col-md-3 mb-1">
                                                @if ($access['isinsert'] == 'Y')
                                                    <label class="labelsmaller" for="resubmission_clearBtnAppend"
                                                        class="d-block">&nbsp;</label>
                                                    <span id="resubmission_clearBtnAppend">

                                                    </span>
                                                    <button type="submit"
                                                        class="btn btn-success labelsmaller btn-sm float-end"
                                                        id="resubmission_addDataToTableAdd">Add <i
                                                            class="fas fa-plus "></i></button>
                                                @endif
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md border border-info rounded " style="position: relative;">
                                <p class="labelsmaller"
                                    style="position: absolute;top: -10px;left:20px;background:white; ">
                                    <strong>
                                        Balance Detail </strong>
                                </p>
                                <div class="row col-12 m-0 p-0" style="width:100%;height:100%;">
                                    <p class="labelsmaller mt-4 mx-0 px-0">
                                        <span id="resubmission_headingSpan">
                                        </span>
                                        <span class="float-end">
                                            <span class="mt-3  labelsmaller d-block">Expiry Date: <span
                                                    id="resubmission_expiryDate">
                                                    YYYY/MM/DD &nbsp;</span> </span>
                                            <span class="labelsmaller"><strong>Total: <span>Rs. <b
                                                            id="resubmission_totalInsuredAmount">0</b> / Rs. <b
                                                            id="all_resubmission_totalInsuredAmount">0</b> </span>
                                                </strong>
                                            </span>

                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <form id="resubmission_DataToTableFormSave" enctype='multipart/form-data'
                            action="{{ route('claimsubmissions.resubmission.store') }}">
                            <p class="labelsmaller mb-0"><i><span class="text-danger">Remarks for Resubmission:</span>
                                    <span id="reasonSection"></span></i> </p>
                            <div class="table-responsive">
                                <table id="resubmission_DataToTable"
                                    class="table table-striped table-bordered labelsmaller">
                                    <thead>
                                        <tr>
                                            <th>S.N.</th>
                                            <th>Document Type</th>
                                            <th>File Name</th>
                                            <th>Size</th>
                                            <th>Remark</th>
                                            <th>Document Date</th>
                                            <th>Bill Amount</th>
                                            <th>Heading</th>
                                            <th>Sub Heading</th>
                                            <th>Clinical Facility</th>
                                            <th style="min-width:125px">Diagnosis</th>
                                            <th style="min-width:240px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    @if ($access['isupdate'] == 'Y')
                                        <tfoot class="d-none">
                                            <tr>
                                                <td colspan="7">&nbsp;</td>
                                                <td>
                                                    <button type="button"
                                                        class="resubmission_btnsendData btn btn-danger btn-sm "
                                                        id="resubmission_cancelBtn">Cancel</button>
                                                </td>
                                                {{-- <td>
                                                    <button type="button" id="resubmission_saveAsDraftlBtn"
                                                        class="resubmission_btnsendData btn btn-warning text-white btn-sm ">Save As
                                                        Draft</button>
                                                </td> --}}
                                                <td>
                                                    <button type="button" id="resubmission_saveSubmitClaim"
                                                        class="resubmission_btnsendData btn btn-success btn-sm ">Submit
                                                        Claim</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    @endif
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade show" id="nav-old" role="tabpanel" aria-labelledby="nav-old-tab">
                    <div class="row my-2">
                        <div class="col-md-9">
                            <div class="row col-md-12">
                                <div class="row mx-0 px-0" id="old_employeeDetailsDiv">
                                    <div class="form-group col-md-4">
                                        <div class="form-group row">
                                            <label class="labelsmaller col-sm-4" for="old_employee_id">Emp Id <span
                                                    class="text-danger">*</span>:</label>
                                            <div class="col-sm-8 px-1">
                                                <select id="old_employee_id" data-required="true"
                                                    class="labelsmaller form-select form-select-sm" name="member_id">
                                                    <option value="" selected="" disabled="">Select Employee
                                                    </option>
                                                    @foreach ($employees as $employee)
                                                        <option value="{{ $employee->id }}"
                                                            {{ $currentUser->member_id == $employee->id ? 'selected' : '' }}>
                                                            {{ $employee?->user?->fname . ' ' . $employee?->user?->mname . ' ' . $employee?->user?->lname }}
                                                            ({{ $employee->employee_id }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group row">
                                            <label class="labelsmaller col-sm-5 px-0" for="old_destination_id">Designation
                                                <span class="text-danger">*</span>:</label>
                                            <div class="col-sm px-0">
                                                <input type="text" class="form-control  form-control-sm"
                                                    name="destination_id" id="old_destination_id" readonly
                                                    placeholder="Designation">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group row">
                                            <label class="labelsmaller col-sm-4 " for="old_branch_id">Branch <span
                                                    class="text-danger">*</span>:</label>
                                            <div class="col-sm ">
                                                <input type="text" readonly class="form-control  form-control-sm"
                                                    name="branch_id" id="old_branch_id" placeholder="Branch">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md">
                                        <label class="labelsmaller" for="old_employee_name">Employee Name <span
                                                class="text-danger">*</span>:</label>
                                        <input type="text" readonly class="form-control  form-control-sm"
                                            name="employee_name" id="old_employee_name" placeholder="Employee Name"
                                            readonly>
                                    </div>
                                    <div class="form-group col-md">
                                        <label class="labelsmaller" for="old_member_id">Member :</label>
                                        <select id="old_member_id" class="labelsmaller form-select form-select-sm"
                                            name="relative_id" data-placeholder="select member">
                                            <option value="">Select Member </option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md">
                                        <label class="labelsmaller" for="old_relation_id">Relation <span
                                                class="text-danger"></span>:</label>
                                        <input type="text" readonly class="form-control  form-control-sm"
                                            name="relation_id" id="old_relation_id" placeholder="Relation">
                                    </div>
                                    <div class="form-group col-md">
                                        <label class="labelsmaller" for="old_policy_no">Policy No <span
                                                class="text-danger">*</span>:</label>
                                        <select id="old_policy_no" class="labelsmaller form-select form-select-sm"
                                            data-required="true" name="policy_no">
                                            <option value="" selected="" disabled>Select Policy No.
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <form id="old_addDataToTableForm">
                                    <div class="row my-1">
                                        <div class="form-group col-md-3 mb-1">
                                            <label class="labelsmaller" for="old_heading_id">Claim Heading <span
                                                    class="text-danger">*</span>:</label>
                                            <select id="old_heading_id"
                                                class="labelsmaller form-select form-select-sm heading_select"
                                                data-required="true" name="heading_id">
                                                <option value="" selected="" disabled>Select Claim Heading
                                                </option>
                                                {{-- @foreach ($headings as $heading)
                                        <option value="{{$heading->id}}">{{$heading->name}}
                                        </option>
                                    @endforeach --}}
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3 mb-1">
                                            <label class="labelsmaller" for="old_sub_heading_id">Claim Sub Heading <span
                                                    class="text-danger">*</span>:</label>
                                            <select id="old_sub_heading_id"
                                                class="labelsmaller form-select form-select-sm" data-required="true"
                                                name="sub_eading_id">
                                                <option value="" selected="" disabled>Select Claim Sub Heading
                                                </option>

                                            </select>
                                        </div>
                                        <div class="form-group col-md-3 mb-1">
                                            <label class="labelsmaller" for="old_document_type_id">Document Type <span
                                                    class="text-danger">*</span>:</label>
                                            <select id="old_document_type_id" data-required="true"
                                                class="labelsmaller form-select form-select-sm" name="document_type">
                                                <option value="" selected="" disabled>Select Document Type
                                                </option>
                                                <option value="bill">Bill/Invoices </option>
                                                <option value="prescription">
                                                    Prescriptions/Clinical Notes </option>
                                                <option value="report">Reports </option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3 mb-1">
                                            <label class="labelsmaller" for="old_bill_file">File <span
                                                    class="text-danger">*</span>:
                                                <small class="text-danger">(Only:
                                                    JPEG, PNG, JPG )</small></label>
                                            <input data-required="true" type="file"
                                                class="form-control  form-control-sm" name="bill_file" id="old_bill_file"
                                                placeholder="File">
                                        </div>
                                        <div class="form-group col-md-3 mb-1">
                                            <label class="labelsmaller" for="old_bill_file_name">File Name <span
                                                    class="text-danger">*</span>:</label>
                                            <input data-required="true" type="text"
                                                class="form-control  form-control-sm" name="bill_file_name"
                                                id="old_bill_file_name" accept="image/png, image/jpeg, application/pdf"
                                                placeholder="File Name">
                                        </div>
                                        <div class="form-group col-md-3 mb-1">
                                            <label class="labelsmaller" for="old_document_date">Document Date <span
                                                    class="text-danger">*</span>:</label>
                                            {{-- <input data-required="true" type="date"
                                                class="form-control  form-control-sm" name="document_date"
                                                id="old_document_date" placeholder="Document Date"> --}}
                                            <div class="input-group englishNepaliDiv" data-type="old">
                                                <input data-required="true" type="date"
                                                    class="form-control form-control-sm" name="document_date"
                                                    id="old_document_date" placeholder="Document Date" disabled>
                                                <input data-required="true" type="text"
                                                    class="form-control form-control-sm" id="old_document_date_bs"
                                                    placeholder="Document Date" disabled hidden>
                                                <div class="input-group-append">
                                                    <div class="custom-select-wrapper">
                                                        <div class="custom-select customSelect" id="old_customSelect">
                                                            <img src="{{ asset('/admin/assets/images/flags/united-states.png') }}"
                                                                alt="US Flag" class="flag-img">
                                                            {{-- <span class="selected-text">US</span> --}}
                                                        </div>
                                                        <div class="custom-dropdown">
                                                            <div class="custom-option" data-value="ad">
                                                                <img src="{{ asset('/admin/assets/images/flags/united-states.png') }}"
                                                                    alt="US Flag" class="flag-img">

                                                            </div>
                                                            <div class="custom-option" data-value="bs">
                                                                <img src="{{ asset('/admin/assets/images/flags/nepal.png') }}"
                                                                    alt="Nepal Flag" class="flag-img">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3 mb-1">
                                            <label class="labelsmaller" for="old_bill_amount">Bill Amount <span
                                                    class="text-danger">*</span>:</label>
                                            <input data-required="true" type="text"
                                                class="form-control  form-control-sm" name="bill_amount"
                                                id="old_bill_amount" placeholder="Bill Amount">
                                        </div>
                                        <div class="form-group col-md-3 mb-1">
                                            <label class="labelsmaller" for="old_remark">Remark:</label>
                                            <input type="text" class="form-control  form-control-sm" name="remark"
                                                id="old_remark" placeholder="Remark">
                                        </div>
                                        <div class="form-group col-md-3 mb-1">
                                            <label class="labelsmaller" for="old_clinical_facility_name">Clinical Facility
                                                Name:</label>
                                            <input type="text" class="form-control  form-control-sm"
                                                name="clinical_facility_name" id="old_clinical_facility_name"
                                                placeholder="Clinical Facility Name">
                                        </div>
                                        <div class="form-group col-md-3 mb-1">
                                            <label class="labelsmaller"
                                                for="old_diagnosis_treatment">Diagnosis/Treatment:</label>
                                            <input type="text" class="form-control  form-control-sm"
                                                name="diagnosis_treatment" id="old_diagnosis_treatment"
                                                placeholder="Diagnosis/Treatment">
                                        </div>
                                        <div class="form-group col-md-3 mb-1">
                                            @if ($access['isinsert'] == 'Y')
                                                <label class="labelsmaller" for="" class="d-block">&nbsp;</label>
                                                <span id="old_clearBtnAppend">

                                                </span>
                                                <button type="submit"
                                                    class="btn btn-success labelsmaller btn-sm float-end"
                                                    id="old_addDataToTableAdd">Add <i class="fas fa-plus "></i></button>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md border border-info rounded " style="position: relative;">
                            <p class="labelsmaller" style="position: absolute;top: -10px;left:20px;background:white; ">
                                <strong>
                                    Balance Detail </strong>
                            </p>
                            <div class="row col-12 m-0 p-0" style="width:100%;height:100%;">
                                <p class="labelsmaller mt-4 mx-0 px-0">
                                    <span id="old_headingSpan">
                                    </span>
                                    <span class="float-end">
                                        <span class=" d-block labelsmaller d-block">Expiry Date: <span
                                                id="old_expiryDate">
                                                YYYY/MM/DD &nbsp;</span> </span>
                                        <span class=" d-block  labelsmaller"><strong>Total: <span>Rs. <b
                                                        id="old_totalInsuredAmount">0</b> / Rs. <b
                                                        id="all_old_totalInsuredAmount">0</b> </span>
                                            </strong>
                                        </span>
                                    </span>

                                </p>
                            </div>
                        </div>
                    </div>
                    <form id="old_addDataToTableFormSave" enctype='multipart/form-data'
                        action="{{ route('claimsubmissions.store') }}">
                        {{-- <input type="hidden" name="clinical_facility_name" id="clinical_facility_name_section" /> --}}
                        <div class="table-responsive">
                            <table id="old_addDataToTable" class="table table-striped table-bordered labelsmaller">
                                <thead>
                                    <tr>
                                        <th>S.N.</th>
                                        <th>Document Type</th>
                                        <th>File Name</th>
                                        <th>Size</th>
                                        <th>Remark</th>
                                        <th>Document Date</th>
                                        <th>Bill Amount</th>
                                        <th>Heading</th>
                                        <th>Sub Heading</th>
                                        <th>Clinical Facility</th>
                                        <th style="min-width:125px">Diagnosis</th>
                                        <th style="min-width:240px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                @if ($access['isinsert'] == 'Y')
                                    <tfoot class="d-none">
                                        <tr>
                                            <td colspan="7">&nbsp;</td>
                                            <td>
                                                <button type="button" class="btnsendData btn btn-danger btn-sm "
                                                    id="old_cancelBtn">Cancel</button>
                                            </td>
                                            <td>
                                                <button type="button" id="old_saveAsDraftlBtn"
                                                    class="btnsendData btn btn-warning text-white btn-sm ">Save As
                                                    Draft</button>
                                            </td>
                                            <td>
                                                <button type="button" id="old_saveSubmitClaim"
                                                    class="btnsendData btn btn-success btn-sm ">Submit
                                                    Claim</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                @endif
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('backend.claimsubmission.vieweditModal')
    @endsection
