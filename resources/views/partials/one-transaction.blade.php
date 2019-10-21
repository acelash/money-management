<div class="row align-items-center transaction @if($transaction->type == config('constants.TRANSACTION_TYPES.IN')) in @else out @endif ">
    <div class="col-2 value">
        {{$transaction->type == config('constants.TRANSACTION_TYPES.IN') ? '+' : '-'}}{{number_format($transaction->value,0,'.',' ')}}
        {{$transaction->resource->currency->code}}
        {{$transaction->is_passive_income == 1 ? '*' : ''}}
        {{$transaction->is_exchange == 1 ? '**' : ''}}
    </div>
    <div class="col-3 source">{{$transaction->type == config('constants.TRANSACTION_TYPES.IN') ? 'to' : 'from'}}
        <span>{{$transaction->resource->name}}</span>
    </div>
    <div class="col-4 comment">{{$transaction->comment}}</div>
    <div class="col-3 date" title="{{$transaction->created_at->format('d.m.Y H:i')}}">{{$transaction->created_at->diffForhumans()}}
        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" id="dropdownTransaction{{$transaction->id}}"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownTransaction{{$transaction->id}}">
                <button class="dropdown-item remove-btn" type="button"
                        data-transaction_id="{{$transaction->id}}" data-transaction_name="{{$transaction->comment}}">
                    <i class="fa fw fa-times"></i> Remove
                </button>
            </div>
        </div>
    </div>
</div>