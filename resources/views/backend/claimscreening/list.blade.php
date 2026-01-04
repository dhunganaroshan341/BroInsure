@extends('backend.layout.main')
@push('styles')
    <style>
        .tui-image-editor-header-buttons,
        .tui-image-editor-header-logo,
        .tie-btn-zoomIn,
        .tie-btn-zoomOut,
        .tie-btn-hand,
        .tie-btn-delete,
        .tie-btn-deleteAll {
            display: none !important;
        }
    </style>
    <style>
        #embeddedSection,
        #prescriptionEmbeddedSection {
            width: 100%;
            max-height: 80vh;
            /* Set max height to 80% of viewport height */
            overflow: auto;
            /* Enable scrolling */
            position: relative;
            border: 1px solid #ccc;
            /* Optional: Add a border for visual effect */
        }

        #slider-image,
        #prescription-slider-image {
            max-width: 100%;
            /* Ensure image width is responsive */
            height: auto;
            transition: transform 0.25s ease;
            /* Smooth zoom transition */
        }

        /* Styles for navigation buttons */
        .nav-btn {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 8px 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .nav-btn:disabled {
            background-color: #c0c0c0;
            cursor: not-allowed;
        }

        .nav-btn i {
            margin: 0 5px;
        }

        .sticky-sidebar {
            position: fixed;
            top: 50%;
            right: 0;
            transform: translateY(-50%);
            z-index: 1060;
            /* Ensure it's above any modal */
            width: 60px;
            /* Adjust width for vertical alignment */
            background-color: #f8f9fa;

            border: 1px solid #ddd;
            padding: 15px 5px;
            /* Adjust padding for vertical button */
        }

        .toggle-btn {
            writing-mode: vertical-rl;
            text-orientation: mixed;
            transform: rotate(180deg);
            /* Rotate to make the text readable */
            width: 100%;
            text-align: center;
            /* margin-bottom: 15px; */
            /* Add margin for spacing */
        }

        .nav-link {
            text-align: center;
        }

        .collapse-vertical {
            background: white;
            width: 250px;
            position: absolute;
            left: -250px;
            top: 0;
            height: auto;
        }
    </style>
    <link rel="stylesheet" href="https://uicdn.toast.com/tui-image-editor/latest/tui-image-editor.css">
    <!-- TUI Color Picker CSS -->
    <link rel="stylesheet" href="https://uicdn.toast.com/tui-color-picker/latest/tui-color-picker.css">
@endpush
@section('main')
    @include('backend.claimscreening.balance_side_bar')
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
                                <option value="" selected="">Select Fiscal Year
                                </option>
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
                                    <option value="{{ $client->id }}">
                                        {{ $client?->name }}
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
                @if (str_contains(request()->path(), 'claimverification'))
                    <div class="form-group col-md-4 mb-2">
                        <div class="form-group row">
                            <label class="labelsmaller col-sm-4" for="claim_no">Claim No:</label>
                            <div class="col-sm">
                                <select id="claim_no" data-required="true" class="labelsmaller form-select form-select-sm"
                                    name="claim_no">
                                    <option value="" selected="">Claim No
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="form-group col-md-4 mb-2">
                    <div class="form-group row">
                        <label class="labelsmaller col-sm-4" for="heading_id">Claim Title:</label>
                        <div class="col-sm">
                            <select id="heading_id" class="labelsmaller form-select form-select-sm" data-required="true"
                                name="heading_id">
                                <option value="" selected="">Select Heading</option>
                                @foreach ($headings as $heading)
                                    <option value="{{ $heading->id }}">{{ $heading->name }}
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
                            placeholder="Search by Employee Code, Name, Lot Number, or Dependent Name"  aria-label=".form-control-sm example">
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
                            {{-- <th>Lot No.</th> --}}
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
                    <tfoot class="d-none">
                        <tr>
                            <td colspan="12">
                                <div class="d-flex justify-content-end">
                                    <button id="registerBtn" class="btn  mx-1 btn-sm btn-success">Register</button>
                                    <button id="cancelBtn" class="btn  mx-1 btn-sm btn-danger">Cancel</button>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="row register_container d-none d-flex flex-row-reverse justify-content-center d-none">
                <button id="requestBtn" style="width: 100px; margin-top: 10px; "
                    class="btn mx-1 btn-sm btn-primary">Verify</button>
            </div>
        </div>
    </div>
    @include('backend.claimregistration.preview_modal')
    @include('backend.claimscreening.screen_modal')
    @include('backend.claimscreening.scrutinyRowEditModal')
@endsection
@push('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/3.6.0/fabric.js"></script>
<script type="text/javascript" src="https://uicdn.toast.com/tui.code-snippet/v1.5.0/tui-code-snippet.min.js"></script>
<script type="text/javascript" src="https://uicdn.toast.com/tui-color-picker/v2.2.6/tui-color-picker.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.3/FileSaver.min.js"></script>
<script src="https://uicdn.toast.com/tui-image-editor/latest/tui-image-editor.js"></script>
@endpush
