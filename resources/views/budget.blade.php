@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card overview">
                    <div class="card-body row align-items-center">
                        <div class="col-6 add-transaction">
                            <button title="Add Input" class="btn btn-success" data-toggle="modal" data-target="#addBudget">
                                <i class="fa fa-plus"></i>
                                Add article of expenditure
                            </button>
                        </div>
                        <div class="col-6 balance">
                            Montly budget: <span>{{number_format($montlyBudget,0,'.',' ')}} MDL</span>
                        </div>
                    </div>
                </div>

                @include('partials.form-validation')

                <div class="card-title"><h2>Articles of expenditure</h2></div>
                <div id="articles" class="card articles">
                    <div class="card-body">

                        @forelse($articles as $article)
                            <div class="row align-items-center article">
                                <div class="col-2 value">{{number_format($article->value,0,'.',' ')}} {{$article->currency->code}}</div>
                                <div class="col-7 name">{{$article->name}}</div>
                                <div class="col-3 actions">
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle" type="button" id="dropdownArticle{{$article->id}}"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownArticle{{$article->id}}">
                                            <button class="dropdown-item" type="button"
                                                    data-toggle="modal" data-target="#editBudget"
                                                    data-article_id="{{$article->id}}">
                                                <i class="fa fw fa-pen"></i> Edit
                                            </button>
                                            <button class="dropdown-item remove-btn" type="button"
                                                    data-article_id="{{$article->id}}" data-article_name="{{$article->name}}">
                                                <i class="fa fw fa-times"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>There are no articles yet</p>
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
    <form id="budgetDeleteForm" style="display: none" action="{{route('remove-budget',['id'=>0])}}" method="POST">
        @method('DELETE')
        {{csrf_field()}}
    </form>
    @include('partials.modal-add-budget')
    @include('partials.modal-edit-budget')
@endsection


@section('js')

@endsection
