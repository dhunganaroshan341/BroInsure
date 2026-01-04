@extends('backend.layout.main')
@section('main')
    <div class="row">
        <h6 class="mb-0 text-uppercase col-6 ">{{ $title }}</h6>
        @php
            $url = Route::current()->getName() == 'member-groups.index' ? 'group' : 'individual';
            // dd($url);
        @endphp
        @if ($access['isinsert'] == 'Y')
            <div class="col-4">
                @php
                    $urlc = url()->current();
                    $segments = explode('/', $urlc);
                    $suffix = end($segments);
                @endphp
                @if ($suffix == 'member-groups')
                    <a href="{{ route('member.reference') }}"><button class="btn btn-primary float-end mx-1"><i
                                class="fas fa-import ml-2">Reference</i> </button></a>
                    <a href="{{ asset('admin/assets/member_sample.xlsx') }}" target="_blank"><button
                            class="btn btn-secondary float-end mx-1"><i class="fas fa-import ml-2">sample</i> </button></a>
                    <form id="importForm" action="{{ route('member.import') }}" class="d-flex justify-content-end">
                        @if (!in_array(getUserDetail()->rolecode, ['MB', 'HR']))
                            <select name="client_id_list" id="client_id_list" class="form-select form-select-sm w-auto me-2"
                                required style="width: 100%">
                                <option value="" selected disabled>Select Client</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        @endif
                        <input type="file" class="form-control form-control-sm w-auto me-2" id="file" name="file"
                            placeholder="Enter Bank Name" required value="Global Bank Ime">
                        <button type="submit" class="btn btn-warning text-white" id="btnFileSubmit">Submit</button>
                    </form>
                @endif
            </div>
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
                            <th>Type</th>
                            <th>Company</th>
                            <th>Group</th>
                            <th>Amount</th>
                            <th>Is Active?</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('backend.member.form_modal')
    @include('backend.member.view')
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            var memberTyppe = `{{ $url }}`;
            console.log(memberTyppe);
        })
    </script>
@endpush
