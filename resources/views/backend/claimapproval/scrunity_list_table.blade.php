<table id="scrunity_table111" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>S.N.</th>
            <th>Name.</th>
            <th>Dependent</th>
            <th>Claim Amt</th>
            <th>Ass. Amt</th>
            <th>Excess</th>
            <th>Total Amt</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($scrunities as $index => $scrunity)
            @php
                $approved_amount = $scrunity->details->sum('approved_amount');
            @endphp
            <tr>
                <td>{{$index + 1}}</td>
                <td>{{$scrunity->member->user->full_name}}</td>
                <td>{{$scrunity->relative->rel_name ?? null}}</td>
                <td>{{$scrunity->details->sum('bill_amount')}}</td>
                <td>{{$approved_amount}}</td>
                <td>0</td>
                <td>{{$approved_amount - 0}}</td>
                <td>{{$scrunity->details->pluck('remarks')->implode(', ')}}</td>
            </tr>
        @endforeach
    </tbody>
</table>






