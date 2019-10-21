@extends('layouts.public')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('partials.rates',['rates'=>$rates])
            </div>
        </div>
    </div>
@endsection
