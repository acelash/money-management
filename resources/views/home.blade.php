@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('partials.overview',['totalInMDL'=>$totalInMDL])

                @include('partials.form-validation')

                <div class="card-title"><h2>Latest transactions</h2></div>
                <div id="transactions" class="card transactions">
                    <div class="card-body">
                        @forelse($transactions as $transaction)
                            @include('partials.one-transaction',['transaction'=>$transaction])
                        @empty
                            <p>No transactions made yet</p>
                        @endforelse

                        <div class="see-more">
                            <a href="{{route('transactions.list')}}">See more</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @include('partials.user-info')
                @include('partials.widget-target',['target' => $target])
                @include('partials.rates',['rates'=>$rates])
            </div>
        </div>
    </div>
    <form id="transactionDeleteForm" style="display: none" action="{{route('remove-transaction',['id'=>0])}}" method="POST">
        @method('DELETE')
        {{csrf_field()}}
    </form>
    @include('partials.modal-add-transaction',['resources'=>$resources])
    @include('partials.modal-add-target')
@endsection
