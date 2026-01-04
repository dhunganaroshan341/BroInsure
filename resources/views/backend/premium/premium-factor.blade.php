@extends('backend.layout.main')
@section('main')
    <div class="container-fluid mt-5">
       <div class="card p-4">
        <h1 class="text-center mb-4">{{ $title }}</h1>
        <form id="premiumForm" class="row g-3" action="{{ route('premium.update') }}" >
            @csrf
            <div class="col-md-6">
                <label for="insuredAmount" class="form-label">Base Rate<span class="text-danger">*</span>:</label>
                <input type="number" class="form-control" id="base_rate" step="any" name="base_rate" min="1"
                    value="{{ $premium->base_rate }}">
                    <span class="text-danger errorMessage" id="base_rate-error"></span>
            </div>
            <div class="col-md-6">
                <label for="numDependents" class="form-label">Dependent Factor<span class="text-danger">*</span>:</label>
                <input type="number" class="form-control" id="dependent_factor" name="dependent_factor" step="any" value="{{ $premium->dependent_factor }}" min="1">
                <span class="text-danger errorMessage" id="dependent_factor-error"></span>
            </div>
            <div class="col-md-6">
                <label for="dob" class="form-label">Age Factor<span class="text-danger">*</span>:</label>
                <input type="number" class="form-control" id="age_factor" name="age_factor" step="any" value="{{ $premium->age_factor }}" min="1" >
                <span class="text-danger errorMessage" id="age_factor-error"></span>
            </div>
            <div class="col-md-6">
                <label for="insurancePeriod" class="form-label">Period Factor<span class="text-danger">*</span>:</label>
                <input type="number" class="form-control" id="period_factor" name="period_factor" step="any" value="{{ $premium->period_factor }}" min="1" >
                <span class="text-danger errorMessage" id="period_factor-error"></span>
            </div>
            <div class="col-12 d-flex">
                <button class="btn btn-primary mx-auto" type="submit" id="updatePremium">Update</button>
            </div>
        </form>
       </div>
    </div>
@endsection
