<table id="datatables-reponsive" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>Form Name
            </th>
            <th>Create
                <div class="form-check form-switch">
                    <input class="form-check-input create_all" value="create" type="checkbox">
                </div>
            </th>
            <th>Edit Button
                <div class="form-check form-switch">
                    <input class="form-check-input edit_all" value="edit" type="checkbox">
                </div>
            </th>
            <th>Update
                <div class="form-check form-switch">
                    <input class="form-check-input update_all" value="update" type="checkbox">
                </div>
            </th>
            <th>Delete
                <div class="form-check form-switch">
                    <input class="form-check-input delete_all" value="delete" type="checkbox">
                </div>
            </th>


        </tr>
    </thead>
    <tbody>
        @foreach($formList as $m)
        <tr>
            <td>{{$m}}</td>
            <td>
                @php
                if(isset($allowed[$m.'_I']) && $allowed[$m.'_I']=='Y')
                $check='checked';
                else
                $check='';
                @endphp
                <div class="form-check form-switch">
                    <input class="form-check-input permission_chk create" value="{{$m.'_I'}}" type="checkbox"
                        id="flexSwitchCheckDefault" {{$check}}>
                </div>
            </td>
            <td>
                @php
                if(isset($allowed[$m.'_E']) && $allowed[$m.'_E']=='Y')
                $check='checked';
                else
                $check='';
                @endphp
                <div class="form-check form-switch">
                    <input class="form-check-input permission_chk edit" value="{{$m.'_E'}}" type="checkbox"
                        id="flexSwitchCheckDefault" {{$check}}>
                </div>
            </td>
            <td>
                @php
                if(isset($allowed[$m.'_U']) && $allowed[$m.'_U']=='Y')
                $check='checked';
                else
                $check='';
                @endphp
                <div class="form-check form-switch">
                    <input class="form-check-input permission_chk update" value="{{$m.'_U'}}" type="checkbox"
                        id="flexSwitchCheckDefault" {{$check}}>
                </div>
            </td>
            <td>
                @php
                if(isset($allowed[$m.'_D']) && $allowed[$m.'_D']=='Y')
                $check='checked';
                else
                $check='';
                @endphp
                <div class="form-check form-switch">
                    <input class="form-check-input permission_chk delete" value="{{$m.'_D'}}" type="checkbox"
                        id="flexSwitchCheckDefault" {{$check}}>
                </div>
            </td>


        </tr>

        @endforeach

    </tbody>
</table>