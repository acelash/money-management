@extends('layouts.app')

@section('body-class','reports-page')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @include('partials.overview',['totalInMDL'=>$totalInMDL])
                @include('partials.form-validation')

                <div class="card-title"><h2>Income and expenses</h2></div>
                <div class="card ">
                    <div class="card-body">
                        <canvas id="myChart" width="400"></canvas>
                    </div>
                </div>

                <div class="card-title"><h2>Passive income</h2></div>
                <div class="card ">
                    <div class="card-body">
                        <canvas id="passiveChart" width="400"></canvas>
                    </div>
                </div>

                <div class="card-title"><h2>Passive income to expenses</h2></div>
                <div class="card ">
                    <div class="card-body">
                        <canvas id="passiveChart2" width="400"></canvas>
                    </div>
                </div>

                <div class="card-title"><h2>Monthly change of balance</h2></div>
                <div class="card ">
                    <div class="card-body">
                        <canvas id="balanceChart" width="400"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @include('partials.user-info')
                @include('partials.rates',['rates'=>$rates])
            </div>
        </div>
    </div>
    <script>
        var chartIElabels = {!! json_encode($reportIncomeExpenses['labels']) !!},
            chartIEincome = {!! json_encode($reportIncomeExpenses['dataIncome']) !!},
            chartIEexpenses = {!! json_encode($reportIncomeExpenses['dataExpenses']) !!},
            chartPassivelabels = {!! json_encode($reportPassiveIncome['labels']) !!},
            chartPassiveIncome = {!! json_encode($reportPassiveIncome['dataIncome']) !!},
            chartPassive2labels = {!! json_encode($reportPassiveIncomeToExpenses['labels']) !!},
            chartPassiveIncome2 = {!! json_encode($reportPassiveIncomeToExpenses['dataIncome']) !!},
            balanceChartLabels = {!! json_encode($reportBalance['labels']) !!},
            balanceChart = {!! json_encode($reportBalance['data']) !!};
    </script>
    @include('partials.modal-add-transaction',['resources'=>$resources])
@endsection

