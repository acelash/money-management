@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card overview">
                    <div class="card-body row align-items-center">
                        <div class="col-3 add-transaction">
                            <button title="Add Input" class="btn btn-success" data-toggle="modal" data-target="#addResource">
                                <i class="fa fa-plus"></i>
                                Add resourse
                            </button>
                        </div>
                        <div class="col-9 finances">
                            @foreach($finances as $finance)
                                <span>{{number_format($finance['total'],0,'.',' ')}} {{$finance['code']}}</span>
                            @endforeach

                            <i title="Total {{number_format($totalInMDL,0,'.',' ')}} MDL" class="fa fa-info-circle"></i>
                        </div>
                    </div>
                </div>

                @include('partials.form-validation')

                <div class="card-title"><h2>Resources</h2></div>
                <div id="resources" class="card articles">
                    <div class="card-body">

                        @forelse($resources as $resource)
                            <div class="row align-items-center article">
                                <div class="col-2 value">{{number_format($resource->value,0,'.',' ')}} {{$resource->currency->code}}</div>
                                <div class="col-7 name">{{$resource->name}}</div>
                                <div class="col-3 actions">
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle" type="button" id="dropdownArticle{{$resource->id}}"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownArticle{{$resource->id}}">
                                            <button class="dropdown-item" type="button"
                                                    data-toggle="modal" data-target="#editResource"
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
            </div>
            <div class="col-md-4">
                @include('partials.user-info')
                @include('partials.rates',['rates'=>$rates])
            </div>
        </div>
    </div>
    <form id="resourceDeleteForm" style="display: none" action="{{route('remove-resource',['id'=>0])}}" method="POST">
        @method('DELETE')
        {{csrf_field()}}
    </form>
    @include('partials.modal-add-resource')
    @include('partials.modal-edit-resource')
@endsection


@section('js')

@endsection
