<div class="card-title">
    <h2>Exchange rates
    <a class="update-btn" href="{{route('update-rates')}}"><i class="fas fa-sync-alt"></i></a>
    </h2>
</div>
<div class="card rates">
    <div class="card-body">
        @foreach($rates as $rate)
            <div class="rate">
                {{$rate->currency->code}} <span class="rate-value">{{number_format($rate->rate,2,'.',' ')}}</span>
                {{$rate->currency2->name}} <span class="date">{{$rate->updated_at->diffForhumans()}}</span>
            </div>
        @endforeach
    </div>
</div>