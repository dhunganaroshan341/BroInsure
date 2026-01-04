@foreach ($details as $index => $detail)
    @php
        $serialNumber = $index + 1;
    @endphp
    <tr data-rowno="{{ $serialNumber }}" id="scrutiny_row{{ $serialNumber }}">
        <td>
            <span class='scrutiny_sn'>{{ $serialNumber }}</span>
        </td>
        <td id="scrutiny_bill_no{{ $serialNumber }}">
            <span>{{ $detail->bill_no }}</span>
            <input type="hidden" name="bill_no[]" value="{{ $detail->bill_no }}'" />
        </td>
        <td id="scrutiny_file{{ $loop->iteration }}">
            <span>
                @if ($detail->file)
                    <a target="_blank" href="{{ asset($detail->file) }}">{{ basename($detail->file) }}</a>
                @endif
            </span>
            <input type="hidden" name="file_url[]" value="{{ $detail->file ? asset($detail->file) : null }}">
        </td>
        <td id="scrutiny_title_id{{ $serialNumber }}">
            <span>{{ $detail->insuranceHeading->name }}</span>
            <input type="hidden" name="heading_id[]" value="{{ $detail->insuranceHeading->id }}" />
        </td>
        <td id="scrutiny_bill_amount{{ $serialNumber }}">
            <span>{{ $detail->bill_amount }}</span>
            <input type="hidden" name="bill_amount[]" value="{{ $detail->bill_amount }}" />
        </td>
        <td id="scrutiny_approved_amount{{ $serialNumber }}">
            <span>{{ $detail->approved_amount }}</span>
            <input type="hidden" name="approved_amount[]" value="{{ $detail->approved_amount }}" />
        </td>
        <td id="scrutiny_deduction{{ $serialNumber }}">
            <span>{{ $detail->deduct_amount }}</span>
            <input type="hidden" name="deduct_amount[]" value="{{ $detail->deduct_amount }}" />
        </td>
        <td id="scrutiny_remarks{{ $serialNumber }}">
            <span>{{ $detail->remarks }}</span>
            <input type="hidden" name="remarks[]" value="{{ $detail->remarks }}" />
        </td>
        <td>
            <button type="button" class="btn btn-primary btn-sm text-white scrutinyViewRow"
                data-row_no="{{ $serialNumber }}"><i class="fas fa-eye"></i> View</button>
            {{-- <button type="button" class="btn btn-warning btn-sm text-white scrutinyEditRow"
                data-row_no="{{ $serialNumber }}"><i class="fas fa-edit"></i> Edit</button> --}}
            {{-- <button type="button" class="btn btn-danger btn-sm deleteRow" data-row_no="{{ $serialNumber }}"><i
                    class="fas fa-trash"></i> Delete</button> --}}
        </td>

    </tr>
@endforeach
