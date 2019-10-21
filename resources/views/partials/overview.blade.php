<div class="card overview">
    <div class="card-body row align-items-center">
        <div class="col-6 add-transaction">
            <button title="Add Input" class="btn btn-success" data-toggle="modal"
                    data-target="#addTransaction"
                    data-type="{{config('constants.TRANSACTION_TYPES.IN')}}">
                <i class="fa fa-plus"></i>
            </button>
            <button title="Add Output" class="btn btn-danger" data-toggle="modal"
                    data-target="#addTransaction"
                    data-type="{{config('constants.TRANSACTION_TYPES.OUT')}}">
                <i class="fa fa-minus"></i>
            </button>
        </div>
        <div class="col-6 balance">
            Balance: <span>{{number_format($totalInMDL,0,'.',' ')}} MDL</span>
        </div>
    </div>
</div>