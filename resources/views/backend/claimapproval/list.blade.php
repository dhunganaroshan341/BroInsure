@extends('backend.layout.main')
<style>
    /* Container for the signature section */
    .signatures {
        display: flex;
        justify-content: space-between;
        padding: 0 50px;
        margin-top: 0px;
    }

    /* Each signature box (column) */
    .signature-box {
        width: 30%;
        text-align: center;
    }

    /* Signature lines */
    .signature-line {
        border-bottom: 1px solid black;
        margin: 30px 0 5px 0;
        height: 20px;
        /* Adjust height if needed */
    }

    /* Signature label text */
    .signature-text {
        font-weight: bold;
        margin: 0;
        padding: 0;
    }

    .particularsTable tr {
        height: 15px;
        /* Adjust the height as needed */
        line-height: 1;
    }

    @media print {
        #scrunity_table tr {
            height: 15px;
            /* Adjust the height as needed */
            line-height: 0.7;
            /* Control the vertical spacing */
        }
    }
</style>
@section('main')
    @include('backend.claimscreening.balance_side_bar')
    <div class="row">

        <h6 class="mb-0 text-uppercase col-10 ">{{ $title }}</h6>
    </div>
    <hr>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatables-reponsive" class="table table-striped table-bordered labelsmaller">
                    <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>Claim Id</th>
                            <th>Employee Name</th>
                            <th>Client Name</th>
                            <th>File No</th>
                            <th>Claim Amount</th>
                            <th>Bill Amount</th>
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
    @include('backend.claimscrutiny.form_modal')
    @include('backend.claimregistration.preview_modal')
    @include('backend.claimscreening.screen_modal')
    @include('backend.claimscreening.scrutinyRowEditModal')
@endsection
