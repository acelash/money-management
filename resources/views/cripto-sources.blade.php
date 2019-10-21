@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card overview">
                    <div class="card-body row align-items-center">
                        <div class="col-5 add-transaction">
                            <button title="Add cripto-resource" class="btn btn-success" data-toggle="modal" data-target="#addCriptoResource">
                                <i class="fa fa-plus"></i>
                                Add resourse
                            </button>

                            <button title="Add cripto-investition" class="btn btn-primary" data-toggle="modal" data-target="#addCriptoInvestition">
                                <i class="fa fa-plus"></i>
                                Add investition
                            </button>
                        </div>
                        <div class="col-7 finances">
                            @foreach($finances as $finance)
                                <span>{{number_format($finance['total'],7,'.',' ')}} {{$finance['code']}}</span>
                            @endforeach

                            <i title="Total {{number_format($totalInMDL,0,'.',' ')}} MDL" class="fa fa-info-circle"></i>
                        </div>
                    </div>
                </div>

                @include('partials.form-validation')

                <div class="card-title"><h2>Overview</h2></div>
                <div class="card">
                    <div class="card-body cripto-overview">

                        <div class="row align-items-center article">
                            <div class="col-3"><span>Total invested:</span> {{ceil($overview['total_invested'])}} USD</div>
                            <div class="col-3"><span>Today's worth :</span> {{ceil($overview['investition_worth'])}} USD</div>
                            <div class="col-4">
                                <span>Efficiency :</span>
                                {{round($overview['investition_worth'] / $overview['total_invested'] *100 -100)}} %
                                (@if($overview['investition_worth'] > $overview['total_invested']) + @endif
                                {{ceil($overview['investition_worth'] - $overview['total_invested'])}} USD)
                            </div>
                            <div class="col-7"></div>

                        </div>
                    </div>
                </div>

                <div class="card-title"><h2>Cripto Resources</h2></div>
                <div id="criptoResources" class="card articles">
                    <div class="card-body">

                        @forelse($resources as $resource)
                            <div class="row align-items-center article">
                                <div class="col-2 value">{{number_format($resource->amount->sum('ammount_purchased'),7,'.',' ')}} {{$resource->currency->code}}</div>
                                <div class="col-7 name">{{$resource->name}}</div>
                                <div class="col-3 actions">
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle" type="button" id="dropdownArticle{{$resource->id}}"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownArticle{{$resource->id}}">
                                            <button class="dropdown-item" type="button"
                                                    data-toggle="modal" data-target="#editCriptoResource"
                                                    data-resource_id="{{$resource->id}}">
                                                <i class="fa fw fa-pen"></i> Edit
                                            </button>
                                            <button class="dropdown-item remove-btn" type="button"
                                                    data-resource_id="{{$resource->id}}" data-resource_name="{{$resource->name}}">
                                                <i class="fa fw fa-times"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>There are no resources yet</p>
                        @endforelse
                    </div>
                </div>

                <div class="card-title"><h2>Latest investitions</h2></div>
                <div id="investitions" class="card investitions">
                    <div class="card-body">
                        @forelse($investitions as $investition)
                            <div class="row align-items-center investition">
                                <div class="col-2 investition_value">
                                   {{number_format($investition->investition_value,2,'.',' ')}} USD
                                </div>
                                <div class="col-2 ammount_purchased">
                                    {{number_format($investition->ammount_purchased,7,'.',' ')}}
                                    {{$investition->resource->currency->code}}
                                </div>
                                <div class="col-3 source">
                                    <span><span>to</span>{{$investition->resource->name}}</span>
                                </div>
                                <div class="col-2 current-result {{getClassByProfitRate($investition->getProfitRate())}}">
                                    @if($investition->getProfitRate()*100 - 100 > 0)+@endif{{number_format($investition->getProfitRate()*100 - 100,2,'.',' ')}}%
                                </div>
                                <div class="col-3 date" title="{{$investition->created_at->format('d.m.Y H:i')}}">{{$investition->created_at->diffForhumans()}}
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle" type="button" id="dropdownInvestition{{$investition->id}}"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownInvestition{{$investition->id}}">
                                            <button class="dropdown-item remove-btn" type="button"
                                                    data-investition_id="{{$investition->id}}">
                                                <i class="fa fw fa-times"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>No investitions made yet</p>
                        @endforelse

                        {{--<div class="see-more">
                            <a href="{{route('transactions.list')}}">See more</a>
                        </div>--}}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @include('partials.user-info')
                @include('partials.rates',['rates'=>$rates])
            </div>
        </div>
    </div>
    <form id="criptoResourceDeleteForm" style="display: none" action="{{route('remove-cripto-resource',['id'=>0])}}" method="POST">
        @method('DELETE')
        {{csrf_field()}}
    </form>
    <form id="investitionDeleteForm" style="display: none" action="{{route('remove-cripto-investition',['id'=>0])}}" method="POST">
        @method('DELETE')
        {{csrf_field()}}
    </form>
    @include('partials.modal-add-cripto-resource')
    @include('partials.modal-edit-cripto-resource')
    @include('partials.modal-add-investition')
@endsection


@section('js')

@endsection
