<div class="row">
    <div class="col-6">
        <form method="post" id="intimateClaimForm" action="{{route('claimreceived.store')}}">
            <ul class="nested-checkbox-list">
                @if (count($members) <= 0)
                    <li>No Data Found.</li>
                @else
                    @foreach ($members as $member)    
                        <li>
                            <div class="checkbox-label position-relative">
                                <input type="checkbox" class="form-check-input" name="" value="">
                                <span class="toggle-btn" data-bs-toggle="collapse"
                                    data-bs-target="#bootstrap-ford-list_{{$member['user_id']}}"><i
                                        class="fas fa-plus"></i></span>
                                <strong>{{$member['full_name']}}</strong><i class="position-absolute end-0 labelsmaller">Total
                                    Claim
                                    amount:{{$member['total_amount']}}</i>
                            </div>
                            <ul id="bootstrap-ford-list_{{$member['user_id']}}" class="collapse">
                                @foreach ($member['groupedClaims'] as $key => $groupMember)
                                    <li class=" position-relative">
                                        <div class="checkbox-label" style="margin-left: 10px;">
                                            <input type="checkbox" name="employee_id[]" class="form-check-input employee_id" name=""
                                                value="{{$member['id'] . "__" . $groupMember[0]->relative_id}}"
                                                data-member_id="{{$member['id']}}">
                                            <span class="toggle-btn" data-bs-toggle="collapse"
                                                data-bs-target="#bootstrap-fiesta-list_{{$groupMember[0]?->id}}"><i
                                                    class="fas fa-plus"></i></span>
                                            {{$key == 'self' ? $member['full_name'] : $groupMember[0]?->relation?->rel_name}} <i
                                                class="position-absolute end-0 labelsmaller">Claim
                                                Amount:{{$groupMember->sum('bill_amount')}}</i>
                                        </div>
                                        <ul id="bootstrap-fiesta-list_{{$groupMember[0]?->id}}" style="margin-left: 30px;"
                                            class="collapse">
                                            @foreach ($groupMember as $bill)
                                                <li>
                                                    <span class="d-block">
                                                        - {{$bill->document_type}} <i
                                                            class="float-end labelsmaller">Amount:{{$bill->bill_amount}} </i>
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach                
                @endif
            </ul>
            @if ($access['isinsert'] == 'Y' && count($members) > 0)
                <div class="form-group col-md-3 mb-1">
                    <label class="labelsmaller" for="" class="d-block">&nbsp;</label>
                    <button type="submit" class="btn btn-success labelsmaller btn-sm float-end" id="claimReceived">Intimate
                        Claim
                        <i class="fas fa-save "></i></button>
                </div>
            @endif
        </form>
    </div>
</div>