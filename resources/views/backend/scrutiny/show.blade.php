@extends('backend.layout.main')
<style>
    .document-container {
        border: 1px solid #F6CB6F;
        overflow: hidden;
    }

    .document-header {
        color: #B3975C;
    }

    .employee-info-container,
    .balance-detail-info {
        font-size: 10px;
    }

    .balance-button-container {
        text-align: center;
    }

    .balance-button-container span {
        font-size: 10px;
    }

    .balance-button-container button {
        margin-bottom: 10px;
    }

    .add-amount-container,
    .add-amount-container button span,
    .bottom-button button span,
    .document-list .d-flex {
        font-size: 11px;
    }
</style>
@section('main')
    <div class="row">
        <h6 class="mb-0 text-uppercase col-10 ">{{ $title }}</h6>
    </div>
    <hr>
    <div class="card">
        <div class="card-body">
            <div class="upper-container">
                <div class="row">
                    <div class="col-md-9 border p-3">
                        <div class="employee-info-container d-flex flex-column gap-2">
                            @php
                                $columns_per_row = 3;
                            @endphp
                            <div class="row">
                                <label class="col-md-3">Employee ID: 1</label>
                                <label class="col-md-3">Designation: Doctor</label>
                                <label class="col-md-3">Branch: Kathmandu</label>
                                <label class="col-md-3">Client Name: Bishal GUrung</label>
                            </div>
                            <div class="row">
                                <label class="col-md-3">Policy No: 251342</label>
                                <label class="col-md-3">Employee Name: Bishal Gurung</label>
                                <label class="col-md-3">Select Member: Dil Maya Gurung</label>
                                <label class="col-md-3">Relation: Mother</label>
                            </div>
                            <div class="row">
                                <label class="col-md-3">Expiry Date: 2024-07-04</label>
                            </div>
                        </div>
                        <div class="document-container mt-2 p-2 pt-1">
                            <h6 class="document-header">Document</h6>
                            <div class="row">
                                <div class="document-list col-md-3">
                                    <div class="d-flex flex-column gap-2">
                                        <div>
                                            <label type="button" data-bs-toggle="collapse" href="#invoice-collapse"
                                                aria-expanded="false" aria-controls="invoice-collapse">
                                                Invoices
                                            </label>
                                            <ul class="collapse" id="invoice-collapse">
                                                <li>Bill</li>
                                                <li>Test Bill</li>
                                                <li>Medical Bill</li>
                                            </ul>
                                        </div>
                                        <div>
                                            <label type="button" data-bs-toggle="collapse" href="#clinical-collapse"
                                                aria-expanded="false" aria-controls="clinical-collapse">
                                                Clinical Reports
                                            </label>
                                            <ul class="collapse" id="clinical-collapse">
                                                <li>Bill</li>
                                                <li>Test Bill</li>
                                                <li>Medical Bill</li>
                                            </ul>
                                        </div>
                                        <div>
                                            <label type="button" data-bs-toggle="collapse" href="#report-collapse"
                                                aria-expanded="false" aria-controls="report-collapse">
                                                Reports
                                            </label>
                                            <ul class="collapse" id="report-collapse">
                                                <li>Bill</li>
                                                <li>Test Bill</li>
                                                <li>Medical Bill</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="document-view col-md-8 border">

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-3 border p-1">
                        <div class="balance-container">
                            <p>Balance Details</p>
                            <div class="balance-detail-info row">
                                <div class="col-md-5">Domiciliary: </div>
                                <div class="col-md-7">Rs.45,000.00/Rs.50,000.00</div>
                                <div class="col-md-5">Hospitalization: </div>
                                <div class="col-md-7">Rs.45,000.00/Rs.50,000.00</div>
                                <div class="col-md-5">Dental: </div>
                                <div class="col-md-7">Rs.45,000.00/Rs.50,000.00</div>
                                <div class="col-md-5">Maternity: </div>
                                <div class="col-md-7">Rs.45,000.00/Rs.50,000.00</div>
                                <div class="col-md-12 text-center fw-bold text-decoration-underline mt-1">
                                    Total: Rs.1,53,000/Rs.2,10,000
                                </div>
                            </div>
                        </div>
                        <div class="balance-button-container">
                            <div class="my-3">
                                {{-- <button class="btn btn-sm btn-outline-secondary"><span>Document Correction</span></button> --}}
                                <br>
                                <button class="btn btn-sm btn-outline-secondary"><span>Resubmission
                                        Request/HOLD</span></button>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-outline-secondary"><span>Reject Claim</span></button>
                                <br>
                                {{-- <button class="btn btn-sm btn-outline-secondary"><span>Split PDF</span></button> --}}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom-container mt-3">
                <div class="add-amount-container">
                    <p>Add Amount</p>
                    <form class="row">
                        @php
                            $fields = ['bill_no', 'title', 'bill_amount', 'deduction', 'approved_amount', 'remark'];
                        @endphp
                        @foreach ($fields as $key)
                            <div class="col-md-2">
                                <label for="">
                                    @foreach (explode('_', $key) as $item)
                                        {{ ucfirst($item) . ' ' }}
                                    @endforeach
                                </label>
                                <input cotype="text" class="form-control form-control-sm" style="width: 100%;"
                                    name="{{ $key }}">
                            </div>
                        @endforeach
                        <div class="col-md-12 d-flex flex-row-reverse gap-2 mt-2">
                            <button class="btn btn-sm btn-outline-secondary">
                                <span>CLEAR</span>
                            </button>
                            <button class="btn btn-sm btn-outline-primary">
                                <span>ADD</span>
                            </button>
                        </div>
                    </form>
                </div>
                <form id="addDataToTableFormSave" class="mt-3" action="">
                    {{-- <input type="hidden" name="clinical_facility_name" id="clinical_facility_name_section" /> --}}
                    <div class="table-responsive">
                        <table id="addDataToTable" class="table table-striped table-bordered labelsmaller">
                            <thead>
                                <tr>
                                    <th>S.N.</th>
                                    <th>Bill No</th>
                                    <th>Title</th>
                                    <th>Claim Amount</th>
                                    <th>Bill Amount</th>
                                    <th>Deduction</th>
                                    <th>Approved Amount</th>
                                    <th>Remark</th>
                                    <th style="min-width:240px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>20025</td>
                                    <td>Dom</td>
                                    <td>25000</td>
                                    <td>5000</td>
                                    <td>20000</td>
                                    <td>20000</td>
                                    <td>Rs.500 deducted for no report found</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm viewRow"><i class="fas fa-eye"></i>
                                            View</button>
                                        <button class="btn btn-warning btn-sm text-white editRow"><i
                                                class="fas fa-edit"></i> Edit</button>
                                        <button class="btn btn-danger btn-sm deleteRow"><i class="fas fa-trash"></i>
                                            Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>20025</td>
                                    <td>Dom</td>
                                    <td>25000</td>
                                    <td>5000</td>
                                    <td>20000</td>
                                    <td>20000</td>
                                    <td>Rs.500 deducted for no report found</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm viewRow"><i class="fas fa-eye"></i>
                                            View</button>
                                        <button class="btn btn-warning btn-sm text-white editRow"><i
                                                class="fas fa-edit"></i> Edit</button>
                                        <button class="btn btn-danger btn-sm deleteRow"><i class="fas fa-trash"></i>
                                            Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="fw-bold">Total</span></td>
                                    <td></td>
                                    <td></td>
                                    <td>20000</td>
                                    <td>30000</td>
                                    <td>40000</td>
                                    <td>65000</td>
                                    <td></td>
                                    <td></td>
                                </tr>

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
                <div class="row bottom-button">
                    <div class="col-md-12 d-flex flex-row-reverse gap-2">
                        <button class="btn btn-sm btn-outline-secondary"><span>Draft</span></button>
                        <button class="btn btn-sm btn-outline-secondary"><span>Request For Verification</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('backend.claimscrutiny.form_modal')
@endsection
