@extends('backend.layout.main')
@section('main')
    <div class="row">

        <h6 class="mb-0 text-uppercase col-10 ">{{ $title }}</h6>
        <div class="col-4">
            <form id="userSerach" action="#" class="d-flex justify-content-end">
                {{-- <a href="{{route('swifts.reference')}}" class="btn btn-primary">Reference File</a> --}}
                @if (!in_array(getUserDetail()->rolecode, ['MB', 'HR']))
                    <div class="form-group col-md-8">
                        <div class="form-group row">
                            <label class="labelsmaller col-sm-4 p-0" for="client_id">Client:</label>
                            <div class="col-sm-8  p-0">
                                <select name="client_id" id="client_id"
                                    class="form-select form-select-sm w-auto me-2" required style="width: 100%">
                                    <option value="" >Select Client</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- <button type="btn" class="btn btn-warning text-white" id="btnSearchSubmit">Search</button> --}}
            </form>
        </div>
        @if ($access['isinsert'] == 'Y')
            <div class="col-2 ">

                <button class="btn btn-success float-end" id="addData">Add <i class="fas fa-plus "></i></button>
            </div>
        @endif
    </div>
    <hr>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatables-reponsive" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>Name</th>
                            <th>Client</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>User Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('backend.user.form_modal')
@endsection
