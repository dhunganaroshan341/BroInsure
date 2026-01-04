@extends('backend.layout.main')
@section('main')
    <div class="row">

        <h6 class="mb-0 text-uppercase col-10 ">{{ $title }}</h6>
    </div>
    <hr>
    <div class="card">
        <div class="card-body">
            <div class="row mb-2">
                <div class="form-group col-md">
                    <label class="labelsmaller" for="employee_id">Employee</label>
                    <select id="employee_id" class="labelsmaller form-select form-select-sm" name="employee_id">
                        <option value="" selected="">Select Employee </option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}" {{ $employee->id == $request_member_id ? 'selected' : '' }}>
                                {{ $employee?->user?->fname . ' ' . $employee?->user?->mname . ' ' . $employee?->user?->lname }}{{ $employee->employee_id ? ' (' . $employee->employee_id . ')' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md">
                    <label class="labelsmaller" for="claim_type">Claim Type </label>
                    <select id="claim_type" class="labelsmaller form-select form-select-sm" name="claim_type">
                        <option value="" selected="">Select Claim Type </option>
                        <option value="claim">Claim </option>
                        <option value="draft">Draft </option>
                    </select>
                </div>
                <div class="form-group col-md">
                    <label class="labelsmaller" for="from_date">From Date </label>
                    <input type="date" class="form-control  form-control-sm" name="from_date" id="from_date"
                        placeholder="From Date">
                </div>
                <div class="form-group col-md">
                    <label class="labelsmaller" for="to_date">To Date </label>
                    <input type="date" class="form-control  form-control-sm" name="to_date" id="to_date"
                        placeholder="To Date">
                </div>

            </div>
            <div class="table-responsive">
                <table id="datatables-reponsive"
                    class="table-striped  labelsmaller table table-striped table-bordered cell-border">
                    <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>Claim Id</th>
                            <th>Emp Id</th>
                            <th>Emp Name</th>
                            <th>Designation</th>
                            <th>Branch </th>
                            <th>Dependent</th>
                            <th>Relation</th>
                            <th>Policy No.</th>
                            <th>Bill Amount</th>
                            {{-- <th>Document Type</th>
                        <th>File</th>
                        <th>Size</th>
                        <th>Remark</th>
                        <th>Document Date</th>
                        <th>Heading</th>
                        <th>Sub Heading</th>
                        <th>Clinical Facility</th>
                        <th>Diagnosis/Treatment</th> --}}
                            <th>Claim Type</th>
                            <th>Status</th>
                            <th>Status Remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('backend.claimsubmission.listEditModal')
    @include('backend.claimscrutiny.form_modal')
@endsection
