@extends('backend.layout.main')
@section('main')
<div class="row">
    <h6 class="mb-0 text-uppercase col-10 ">{{ $title }}</h6>
</div>
<hr>
<div class="card">
    <div class="card-body">
        <div class="row" id="filterData">
            <div class="form-group col-md-4 mb-2">
                <div class="form-group row">
                    <label class="labelsmaller col-sm-4" for="fiscal_year_id">Fiscal Year:</label>
                    <div class="col-sm">
                        <select id="fiscal_year_id" data-required="true" class="labelsmaller form-select form-select-sm"
                            name="fiscal_year_id">
                            <option value="" selected>Select Fiscal Year</option>
                            @foreach($theFiscalYears as $year)
                            <option value="{{ $year->id }}">{{ $year->name }}</option>
                            @endforeach
                        </select>

                    </div>
                </div>
            </div>
            <div class="form-group col-md-4 mb-2">
                <div class="form-group row">
                    <label class="labelsmaller col-sm-4" for="from_date">From Date :</label>
                    <div class="col-sm">
                        <input type="date" class="form-control  form-control-sm" name="from_date" id="from_date"
                            placeholder="From Date">
                    </div>
                </div>
            </div>
            <div class="form-group col-md-4 mb-2">
                <div class="form-group row">
                    <label class="labelsmaller col-sm-4" for="to_date">To Date :</label>
                    <div class="col-sm">
                        <input type="date" class="form-control  form-control-sm" name="to_date" id="to_date"
                            placeholder="To Date">
                    </div>
                </div>
            </div>
            <div class="form-group col-md-4 mb-2">
                <div class="form-group row">
                    <label class="labelsmaller col-sm-4" for="status">Status:</label>
                    <div class="col-sm">
                        <select id="status" data-required="true" class="labelsmaller form-select form-select-sm"
                            name="status">
                            <option value="" selected="">All</option>
                            <option value="Pending">Pending</option>
                            <option value="Registered">Registered</option>
                            <option value="Hold">Hold</option>
                            <option value="Processed">Processed</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-4 mb-2">
                <div class="form-group row">
                    <label class="labelsmaller col-sm-4" for="client_id">Client:</label>
                    <div class="col-sm">
                        <select id="client_id" data-required="true" class="labelsmaller form-select form-select-sm"
                            name="client_id">
                            <option value="" selected="" disabled>Select Client
                            </option>
                            @foreach ($clients as $client)
                            <option value="{{$client->id}}">
                                {{$client?->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-4 mb-2">
                <div class="form-group row">
                    <label class="labelsmaller col-sm-4" for="group_id">Group:</label>
                    <div class="col-sm">
                        <select id="group_id" data-required="true" class="labelsmaller form-select form-select-sm"
                            name="group_id">
                            <option value="" selected="">Select Group
                            </option>
                            {{-- @foreach ($groups as $group)
                            <option value="{{$group->id}}">
                                {{$group?->name}}
                            </option>
                            @endforeach --}}
                        </select>
                    </div>
                </div>
            </div>
            {{-- <div class="form-group col-md-4 mb-2">
                <div class="form-group row">
                    <label class="labelsmaller col-sm-4" for="lot_id">Lot:</label>
                    <div class="col-sm">
                        <select id="lot_id" data-required="true" class="labelsmaller form-select form-select-sm"
                            name="lot_id">
                            <option value="" selected="">Select Lot
                            </option>
                        </select>
                    </div>
                </div>
            </div> --}}
            <div class="form-group col-md-4 mb-2">
                <div class="form-group row">
                    <label class="labelsmaller col-sm-4" for="heading_id">Claim Title:</label>
                    <div class="col-sm">
                        <select id="heading_id" class="labelsmaller form-select form-select-sm" data-required="true"
                            name="heading_id">
                            <option value="" selected="">Select Heading</option>
                            @foreach ($headings as $heading)
                            <option value="{{$heading->id}}">{{$heading->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            {{-- <div class="form-group col-md mb-4">
                <div class="form-group row">
                    <label class="labelsmaller col-sm-2" for="global_search">Global Search:</label>
                    <div class="col-sm">
                        <input class="form-control form-control-sm" type="text" name="global_search" id="global_search"
                            placeholder="Search by Employee Code, Name, Lot Number, or Dependent Name"
                            aria-label=".form-control-sm example">
                    </div>
                </div>
            </div> --}}

            <div class="form-group col-md-4 mb-2">
                <button type="click" class="btn btn-success labelsmaller btn-sm " id="searchData"> Search <i
                        class="fas fa-search "></i>
                </button>
                <button type="click" class="mx-2 btn btn-danger labelsmaller btn-sm " id="resetData"> Reset <i
                        class="fas fa-undo-alt"></i>
                </button>
                @if ($access['isinsert'] == 'Y')
                @endif
            </div>

        </div>
        <div class="table-responsive" id="mainTableForm">
            <table id="datatables-reponsive" class="table table-striped table-bordered labelsmaller">
                <thead>
                    <tr>
                        <th>S.N.</th>
                        <th>Clamin Id</th>
                        <th>EmpID</th>
                        <th>Employee Name</th>
                        <th>Dependent Name</th>
                        <th>Relation</th>
                        <th>DOB</th>
                        <th>Claim Title</th>
                        <th>Claim Date</th>
                        <th>Client Name</th>
                        <th>Group</th>
                        <th>File No</th>
                        <th>Claim No</th>
                        {{-- <th>Branch</th> --}}
                        {{-- <th>Designation</th> --}}
                        <th>HCF Name</th>
                        <th>Amount</th>
                        <th>Submitted By</th>
                        {{-- <th>Diagnosis/Treatment</th> --}}
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
                {{-- <tfoot class="d-none">
                    <tr>
                        <td colspan="12">
                            <div class="d-flex justify-content-center">
                                <button id="registerBtn" class="btn  mx-1 btn-sm btn-success">Register</button>
                                <button id="cancelBtn" class="btn  mx-1 btn-sm btn-danger">Cancel</button>
                            </div>
                        </td>
                    </tr>
                </tfoot> --}}
            </table>
            <div class="d-flex justify-content-center d-none RegisterDiv">
                <button id="registerBtn" class="btn  mx-1 btn-sm btn-success">Register</button>
                <button id="cancelBtn" class="btn  mx-1 btn-sm btn-danger">Cancel</button>
            </div>
        </div>
    </div>
</div>
@include('backend.claimregistration.preview_modal')
@endsection