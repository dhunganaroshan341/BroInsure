@extends('backend.layout.main')
@section('main')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title_ pe-3">Dashboard</div>

    </div>
    <!--end breadcrumb-->

    <div class="row">
        <div class="col-xxl-12 d-flex align-items-stretch">
            <div class="card w-100 overflow-hidden rounded-4">
                <div class="card-body position-relative p-4">
                    <div class="row">
                        <div class="col-12 col-sm-7">
                            <div class="d-flex align-items-center gap-3 mb-5">
                                <img src="{{ asset('admin/assets/images/profile.png') }}"
                                    class="rounded-circle bg-grd-info p-1" width="60" height="60" alt="user">
                                <div class="">
                                    <p class="mb-0 fw-semibold">Welcome</p>
                                    <h4 class="fw-semibold mb-0 fs-4 mb-0">{{ getUserDetail()->full_name }}</h4>
                                </div>
                            </div>

                        </div>
                        <div class="col-12 col-sm-5">
                            <div class="welcome-back-img pt-4">
                                <img src="{{ asset('admin/assets/images/gallery/welcome-back-3.png') }}" height="180"
                                    alt="">
                            </div>
                        </div>
                    </div><!--end row-->
                </div>
            </div>
        </div>


        @if ($currentUser->rolecode !== 'HR' && $currentUser->rolecode !== 'MB')
            <div class="col-md-8  d-flex row m-0 p-0">

                <div class="row col-12 mb-2">
                    <div class="col-md-4">

                        <select name="client_type" id="client_type" class="form-select">
                            {{-- <option selected disabled>select type</option> --}}
                            <option value="all" selected>All</option>
                            <option value="group">Group</option>
                            <option value="individual">Individual</option>
                        </select>
                    </div>
                    <div class="col-md-8">

                        <select name="client_group" id="client_group" class="form-select" hidden>
                            <option selected disabled>Select Group</option>
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class=" col-12 align-items-stretch">
                    <div class="card w-100 rounded-4">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <div class="">
                                    <h5 class="mb-0" id="total_member">0</h5>
                                    <p class="mb-0">Total Members</p>
                                </div>
                            </div>
                            <div class="chart-container2">
                                <div id="chart2"></div>
                            </div>
                            <div class="text-center">
                                <p class="mb-0 font-12"><span class="text-success me-1 member-increased-per">0</span> <span
                                        id="perMem" class="text-success">%</span> from last month</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card w-100 rounded-4">
                    <div class="card-body">
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="">
                                    <h5 class="mb-0">Client Status</h5>
                                </div>
                                {{-- <div class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle-nocaret options dropdown-toggle"
                                    data-bs-toggle="dropdown">
                                    <span class="material-icons-outlined fs-5">more_vert</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                                    <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                                    <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                                </ul>
                            </div> --}}
                            </div>
                            <div class="position-relative">
                                <div class="piechart-legend">
                                    <h2 class="mb-1">{{ $active_clients + $inactive_clients }}</h2>
                                    <h6 class="mb-0">Total Clients</h6>
                                </div>
                                <div id="clientsChart"></div>
                            </div>
                            <div class="d-flex flex-column gap-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="mb-0 d-flex align-items-center gap-2 w-25"><span
                                            class="material-icons-outlined fs-6 text-danger">fiber_manual_record</span>Inctive
                                    </p>
                                    <div class="">
                                        <p class="mb-0">{{ $inactive_clients }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="mb-0 d-flex align-items-center gap-2 w-25"><span
                                            class="material-icons-outlined fs-6 text-success">fiber_manual_record</span>Active
                                    </p>
                                    <div class="">
                                        <p class="mb-0">{{ $active_clients }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-12   d-flex">
            <div class="card rounded-4 w-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="">
                            <h5 class="mb-0">Claim Detail</h5>
                        </div>
                        {{-- <div class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle-nocaret options dropdown-toggle"
                                data-bs-toggle="dropdown">
                                <span class="material-icons-outlined fs-5">more_vert</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                                <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                                <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                            </ul>
                        </div> --}}
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>No.</th>
                                    <th>Claim Amount</th>
                                    <th>Approved Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Total Claim Received</th>
                                    <td>
                                        <h5 class="mb-0">{{ numberFormatter($all_claims->total_claims) }}</h5>
                                    </td>
                                    <td>
                                        <h5 class="mb-0">Rs. {{ numberFormatter($all_claims->total_bill_amount) }}</h5>
                                    </td>
                                    <td>
                                        <div class="card-lable bg-success text-success bg-opacity-10">
                                            <p class="text-success mb-0">
                                                Rs. {{ numberFormatter($all_claims->approved_amount) }}</p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Total Claim Approved</th>
                                    <td>
                                        <h5 class="mb-0">{{ numberFormatter($all_claims->approved_claims) }}</h5>
                                    </td>
                                    <td>
                                        <h5 class="mb-0">Rs. {{ numberFormatter($all_claims->approved_bill_amount) }}</h5>
                                    </td>
                                    <td>
                                        <div class="card-lable bg-success text-success bg-opacity-10">
                                            <p class="text-success mb-0">
                                                Rs. {{ numberFormatter($all_claims->approved_amount) }}</p>
                                        </div>
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @if ($currentUser->rolecode !== 'MB')
            <div class="col-12  d-flex">
                <div class="card rounded-4 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <div class="">
                                <h5 class="mb-0">Amount Detail</h5>
                            </div>
                            @if ($currentUser->rolecode !== 'HR' && $currentUser->rolecode !== 'MB')
                                <select id="clientID" class="form-select" style="max-width: 300px">
                                    {{-- <option selected disabled>select type</option> --}}
                                    <option value="" selected>All</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}" data-name="{{ $client->name }}">
                                            {{ $client->name }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-striped" id="preminumSection">
                                <thead>
                                    <tr>
                                        @if ($currentUser->rolecode !== 'HR' && $currentUser->rolecode !== 'MB')
                                            <th>Client</th>
                                        @endif
                                        <th>Preminum Amount</th>
                                        <th>Approved Amount</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($currentUser->rolecode == 'MB' || $currentUser->rolecode == 'HR')
            <div class="col-12  d-flex">
                <div class="card rounded-4 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <div class="">
                                <h5 class="mb-0">Claim Status</h5>
                            </div>

                        </div>
                        <div class="card-body">
                            <table class="table align-middle mb-0 table-bordered" id="claim-status-table-responsive">
                                <thead>
                                    <tr>
                                        <th>Claim ID</th>
                                        {{-- <th>Claim ID</th> --}}
                                        <th>Claim Date</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- <tr >
                                        <td>1</td>
                                        <td>2025-90-09</td>
                                        <td class="p-0 m-0">
                                            <div class="row p-0 m-0">
                                                <div class="col-md-2" style="border-right: 1px solid black;padding: 8px;" >
                                                    Column 1 Content
                                                </div>
                                                <div class="col-md-2" style="border-right: 1px solid black;padding: 8px;" >
                                                    Column 2 Content
                                                </div>
                                                <div class="col-md-2" style="border-right: 1px solid black;padding: 8px;" >
                                                    Column 1 Content
                                                </div>
                                                <div class="col-md-2"  style="border-right: 1px solid black;padding: 8px;" >
                                                    Column 2 Content
                                                </div>
                                                <div class="col-md-2" style="border-right: 1px solid black;padding: 8px;" >
                                                    Column 1 Content
                                                </div>
                                                <div class="col-md-2" style="padding: 8px;">
                                                    Column 2 Content
                                                </div>
                                            </div>
                                        </td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
    <script>
        let all_active_clients =
            {{ $currentUser->rolecode !== 'HR' && $currentUser->rolecode !== 'MB' ? $active_clients : 0 }};
        let all_inactive_clients =
            {{ $currentUser->rolecode !== 'HR' && $currentUser->rolecode !== 'MB' ? $inactive_clients : 0 }};
        let currentUser = {{ $currentUser->rolecode }};
    </script>
@endsection
