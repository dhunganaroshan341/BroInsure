
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Benefit Heading</th>
            <th>Amount</th>
            <th>Employee</th>
            <th>Spouse</th>
            <th>Children</th>
            <th>Parents</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($package->headings as $heading)
        {{-- @dd($checklist->where('heading_id', $heading)->first()); --}}
        @php
            $isChecked=$checklist->where('heading_id', $heading->id)->first();

        @endphp
        <input type="hidden" name="heading_id[]" value="{{$heading->id}}">
        <tr>
            <td><label for="first_name" class="col-form-label">{{$heading->name}}</label></td>
            <td>
                <input type="number" class="form-control form-control-sm headingAmount" id="amount" name="amount[]" placeholder="Amount" required value="{{$isChecked?$isChecked->amount:null}}">
            </td>
            <td>
                <div class="form-check form-check-info">
                    <input class="form-check-input customCheckClass" type="checkbox" value="Y" style="{{$isChecked?($isChecked->is_employee=='Y'? '1px solid green':''):'border:1px solid red';}}" name="is_employee[]" {{$isChecked?($isChecked->is_employee=='Y'? 'checked':''):''}}>
                  </div>
            </td>
            <td>
                <div class="form-check form-check-info">
                    <input class="form-check-input customCheckClass" type="checkbox" value="Y" style="{{$isChecked?($isChecked->is_employee=='Y'? '1px solid green':''):'border:1px solid red';}}" name="is_spouse[]" {{$isChecked?($isChecked->is_spouse=='Y'?'checked':''):''}}>
                  </div>
            </td>
            <td>
                <div class="form-check form-check-info">
                    <input class="form-check-input customCheckClass" type="checkbox" value="Y" style="{{$isChecked?($isChecked->is_employee=='Y'? '1px solid green':''):'border:1px solid red';}}" name="is_child[]" {{$isChecked?($isChecked->is_child=='Y'?'checked':''):''}}>
                  </div>
            </td>
            <td>
                <div class="form-check form-check-info">
                    <input class="form-check-input customCheckClass" type="checkbox" value="Y" style="{{$isChecked?($isChecked->is_employee=='Y'? '1px solid green':''):'border:1px solid red';}}" name="is_parent[]" {{$isChecked?($isChecked->is_parent=='Y'?'checked':''):''}}>
                  </div>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>
