@extends('backend.layout.main')
@section('main')
    <div class="row">

        <h6 class="mb-0 text-uppercase col-10 ">{{ $title }}</h6>
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
                            <th>Heading</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('backend.sub-heading.form_modal')
@endsection
