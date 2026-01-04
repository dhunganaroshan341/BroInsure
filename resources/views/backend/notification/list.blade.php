@extends('backend.layout.main')
@section('main')
    {{-- @dd($access) --}}
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">{{ $title }}</h5>
                            <h6 class="card-subtitle text-muted">
                                <a href="javajavascript:void(0)" class="markAllAsSeen" data-id="all"
                                    style="float:right;text-decoration: none;">Mark all as
                                    Seen</a>
                            </h6>

                        </div>
                        <div class="card-body table-responsive">
                            <table id="datatables-reponsive" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Message</th>
                                        <th>Created At</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection
