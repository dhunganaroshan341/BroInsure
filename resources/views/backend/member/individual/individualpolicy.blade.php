<div class="row ">
    <div class="col-md-4">
        <label for="policy_id" class="form-label">Policy <span class="text-danger">*</span></label>
        <select name="policy[policy_id]" id="policy_id" class="form-select " data-placeholder="Select Client" required>
            <option value="" selected disabled>select Policy </option>
            @foreach ($individualPolicies as $policy)
                <option value="{{ $policy->id }}" data-id="{{ $policy->id }}" selected>
                    {{ $policy->policy_no }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label for="group_id" class="form-label">Groupss <span class="text-danger">*</span></label>
        <select id="group_id" class="form-select" name="policy[group_id]" required>
            <option selected="" value="">select group</option>
        </select>
    </div>
    {{-- <div class="col-md-4">
        <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
        <select id="type" class="form-select" name="policy[type]" required>
            <option value="" >select type</option>
            <option value="hr">HR</option>
            <option value="member">Member</option>
            <option value="individual" selected>individual</option>
        </select>
    </div> --}}
    {{-- <div class="col-md-4">
        <label for="package_id" class="form-label">Package <span
                                        class="text-danger">*</span></label>
        <select id="package_id" class="form-select" name="policy[package_id]" required>
            <option selected="" value="" >select package</option>
        </select>
    </div> --}}
    {{-- <div class="col-md-4">
        <label for="policy" class="form-label"> Policy Number <span class="text-danger">*</span> </label>

        <input type="text" name="policy[policy_no]" id="policy" class="form-control" required>
    </div> --}}
    <div class="col-md-4">
        <label for="start_date" class="form-label"> Start Date <span class="text-danger">*</span> </label>

        <input type="date" name="policy[start_date]" id="start_date" class="form-control" required>
    </div>
</div>
