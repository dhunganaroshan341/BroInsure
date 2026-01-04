@extends('backend.layout.main')
@section('main')
<style>
    .labelsmaller,
    input[type=text],
    input[type=date],
    input[type=file],
    select,
    textarea,
    input[type=text]::placeholder,
    input[type=date]::placeholder,
    input[type=file]::placeholder,
    select::placeholder,
    textarea::placeholder {
        font-size: smaller;
    }

    ul {
        list-style-type: none;
    }

    .nested-checkbox-list ul {
        padding-left: 20px;
    }

    .toggle-btn {
        cursor: pointer;
        font-weight: bold;
        margin: 2px 5px 2px 5px;
        border: 1px solid #ccc;
        padding: 2px 4px;
    }

    .checkbox-label {
        display: flex;
        align-items: center;
    }
</style>
<div class="row">
    <p class="mb-0 text-uppercase col-10 "><strong>{{ $title }}</strong></p>
</div>
<hr class="m-0 mb-1">
<div class="card">
    <div class="card-body">
        <div class="row ">

            <div class="form-group col-md-4 mb-2">
                <div class="form-group row">
                    <label class="labelsmaller col-sm-4" for="group_id">Group<span class="text-danger">*</span>:</label>
                    <div class="col-sm">
                        <select id="group_id" data-required="true" class="labelsmaller form-select form-select-sm"
                            name="group_id">
                            <option value="" selected="">Select Group
                            </option>
                            @foreach ($groups as $group)
                                <option value="{{$group->id}}">
                                    {{$group?->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-4 mb-2">
                <div class="form-group row">
                    <label class="labelsmaller col-sm-4" for="employee_id">Employee <span
                            class="text-danger">*</span>:</label>
                    <div class="col-sm">
                        <select id="employee_id" data-required="true" class="labelsmaller form-select form-select-sm"
                            name="employee_id">
                            <option value="" selected="">Select Employee
                            </option>
                            @foreach ($employees as $employee)
                                <option value="{{$employee->id}}">
                                    {{$employee?->user?->fname . ' ' . $employee?->user?->mname . ' ' . $employee?->user?->lname }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-4 mb-2">
                <div class="form-group row">
                    <label class="labelsmaller col-sm-4" for="from_date">From Date <span
                            class="text-danger">*</span>:</label>
                    <div class="col-sm">
                        <input type="date" class="form-control  form-control-sm" name="from_date" id="from_date"
                            placeholder="From Date">
                    </div>
                </div>
            </div>
            <div class="form-group col-md-4 mb-2">
                <div class="form-group row">
                    <label class="labelsmaller col-sm-4" for="to_date">To Date <span
                            class="text-danger">*</span>:</label>
                    <div class="col-sm">
                        <input type="date" class="form-control  form-control-sm" name="to_date" id="to_date"
                            placeholder="To Date">
                    </div>
                </div>
            </div>
            <div class="form-group col-md-4 mb-2">
                @if ($access['isinsert'] == 'Y')
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="selectAll">
                        <label class="form-check-label" for="selectAll">All</label>
                    </div>
                    <button type="click" class="btn btn-success labelsmaller btn-sm " id="searchData"> Search <i
                            class="fas fa-search "></i>
                    </button>
                @endif
            </div>
        </div>
    </div>
    <hr class="m-0 p-0">
    <div class="card-body " id="replaceHtmlAjax">

    </div>
</div>
@endsection