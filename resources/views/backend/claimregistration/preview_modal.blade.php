<div class="modal fade modal-xl" id="viewEditModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header ">
                <strong class="modal-title text-dark labelsmaller " id="modalTitle">View Data</strong>
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="modal-body ">
                {{-- <div class="form-body">
                    <form class="row g-3 form" id="viewEditRecordForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="insurance_claim_id"/>
                        <div class="row my-1">
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="heading_id">Claim Heading <span
                                        class="text-danger">*</span>:</label>
                                <select class="labelsmaller form-select form-select-sm" disabled
                                    name="heading_id" id="heading_id">
                                    <option value="" selected="" disabled>Select Claim Heading
                                    </option>
                                    @foreach ($headings as $heading)
                                        <option value="{{$heading->id}}">{{$heading->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="sub_heading_id">Claim Sub Heading <span
                                        class="text-danger">*</span>:</label>
                                <select id="sub_heading_id" class="labelsmaller form-select form-select-sm"
                                    data-required="true" name="sub_heading_id">
                                    <option value="" selected="" disabled>Select Claim Sub Heading</option>

                                </select>
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="document_type">Document Type <span
                                        class="text-danger">*</span>:</label>
                                <select disabled class="labelsmaller form-select form-select-sm"
                                    name="document_type" id="document_type">
                                    <option value="" selected="" disabled>Select Document Type
                                    </option>
                                    <option value="bill">Bill/Invoices </option>
                                    <option value="prescription">
                                        Prescriptions/Clinical Notes </option>
                                    <option value="report">Reports </option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="bill_file">File <span class="text-danger">*</span>:
                                    <span id="fileUrl"></span></label>
                                <div class="d-bloack">
                                    <a name="bill_file" class="labelsmaller" target="_blank" href=""></a>
                                </div>
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="bill_file_size">Bill File SIze <span
                                        class="text-danger">*</span>:</label>
                                <input disabled type="text" class="form-control  form-control-sm"
                                    name="bill_file_size"
                                    placeholder="Bill File SIze">
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="document_date">Document Date <span
                                        class="text-danger">*</span>:</label>
                                <input disabled type="date" class="form-control  form-control-sm"
                                    name="document_date" placeholder="Document Date" id="document_date">
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="bill_amount">Bill Amount <span
                                        class="text-danger">*</span>:</label>
                                <input disabled type="text" class="form-control  form-control-sm"
                                    name="bill_amount" placeholder="Bill Amount" id="bill_amount">
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="remark">Remark <span
                                        class="text-danger">*</span>:</label>
                                <input disabled type="text" class="form-control  form-control-sm"
                                    name="remark" placeholder="Remark" id="remark">
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="clinical_facility_name">Clinical Facility
                                    Name <span class="text-danger">*</span>:</label>
                                <input disabled type="text" class="form-control  form-control-sm"
                                    name="clinical_facility_name" placeholder="Clinical Facility Name">
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="diagnosis_treatment">Diagnosis/Treatment
                                    <span class="text-danger">*</span>:</label>
                                <input disabled type="text" class="form-control  form-control-sm"
                                    name="diagnosis_treatment" placeholder="Diagnosis/Treatment" id="diagnosis_treatment">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                <button type="button" class="btn btn-sm btn-danger px-4 text-white"
                                    data-bs-dismiss="modal">Close</button>
                                <span id="submitBtn">

                                </span>
                            </div>
                        </div>
                    </form>
                </div> --}}
                <div class="table-responsive" id="previewTable">
                    <table id="datatables-preview-reponsive" class="table table-striped table-bordered labelsmaller">
                        <thead>
                            <tr>
                                <th>S.N.</th>
                                {{-- <th>Lot No.</th> --}}
                                <th>Claim Id</th>
                                <th>EmpID</th>
                                <th>Employee Name</th>
                                <th>Dependent Name</th>
                                <th>Relation</th>
                                <th>File</th>
                                <th>DOB</th>
                                <th>Claim Title</th>
                                <th>Claim Date</th>
                                <th>Client Name</th>
                                <th>Group</th>
                                <th>Branch</th>
                                <th>Designation</th>
                                <th>HCF Name</th>
                                <th>Amount</th>
                                <th>Submitted By</th>
                                <th>Diagnosis/Treatment</th>
                                {{-- <th>Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @isset($claims)
                                @foreach ($claims as $index => $claim)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        {{-- <td>{{ $claim->lot_no }}</td> --}}
                                        <td>{{ $claim->claim_id }}</td>
                                        <td>{{ $claim->member_id }}</td>
                                        <td>{{ $claim->member->user->full_name }}</td>
                                        <td>{{ $claim->relation?->rel_name }}</td>
                                        <td>{{ $claim->relation?->rel_relation }}</td>
                                        <td>
                                            <a target='_blank'
                                                href="{{ asset($claim->file_path) }}">{{ $claim->bill_file_name }}</a>
                                        </td>
                                        <td>{{ $claim->relative_id ? $claim->relation->rel_dob : $claim->member->date_of_birth_ad }}
                                        </td>
                                        <td>{{ $claim->heading->name }}</td>
                                        <td>{{ $claim->document_date }}</td>
                                        <td>{{ $claim->member->client->name }}</td>
                                        <td>{{ $claim?->member?->memberPolicy?->group?->name }}</td>
                                        <td>{{ $claim?->member?->branch }}</td>
                                        <td>{{ $claim?->member?->designation }}</td>
                                        <td>{{ $claim->clinical_facility_name }}
                                        </td>
                                        <td>{{ $claim->bill_amount }}</td>
                                        <td>{{ $claim->creator->full_name }}</td>
                                        <td>{{ $claim->diagnosis_treatment }}</td>
                                    </tr>
                                @endforeach
                            @endisset
                        </tbody>
                        {{-- <tfoot class="d-none">
                            <tr>
                                <td colspan="12">
                                    <div class="d-flex justify-content-end">
                                        <button id="registerBtn" class="btn  mx-1 btn-sm btn-success">Register</button>
                                        <button id="cancelBtn" class="btn  mx-1 btn-sm btn-danger">Cancel</button>
                                    </div>
                                </td>
                            </tr>
                        </tfoot> --}}
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
