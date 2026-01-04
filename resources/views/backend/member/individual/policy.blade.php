<div class="row ">
    <div class="col-md-4">
        <label for="client_id" class="form-label">Client <span class="text-danger">*</span></label>
        <select name="personal[client_id]" id="client_id" class="form-select " data-placeholder="Select Client" required>
            <option value="" selected disabled>select client </option>
            @foreach ($clients as $client)
                <option value="{{ $client->id }}" data-id="{{ $client->id }}">
                    {{ $client->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label for="group_id" class="form-label">Group <span class="text-danger">*</span></label>
        <select id="group_id" class="form-select" name="policy[group_id]" required>
            <option selected="" value="">select group</option>
        </select>
    </div>
    <div class="col-md-4">
        <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
        <select id="type" class="form-select" name="policy[type]" required>
            <option value="" >select type</option>
            <option value="hr">HR</option>
            <option value="member">Member</option>
        </select>
    </div>
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
</div>
