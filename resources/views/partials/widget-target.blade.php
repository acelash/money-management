<div class="card-title">
    <h2>My current target</h2>
</div>
<div class="card target">
    <div class="card-body">
        @if($target)
            <div class="card-actions">
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="dropdownTarget"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-cog"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="dropdownTarget">
                        <button class="dropdown-item" type="button"
                                data-toggle="modal" data-target="#addTarget">
                            <i class="fa fw fa-pen"></i> Edit
                        </button>
                    </div>
                </div>
            </div>
            <div class="value">{{number_format($target->value,0,'.',' ')}} MDL</div>

            <div id='prog-bar-cont'>
                <div id="prog-bar">
                    <div id="background" style="width: {{$target->getCompletedValue()}}%"></div>
                </div>
            </div>
            <p>{{$target->getCompletedValue()}}% completed</p>
        @else
            <button data-toggle="modal"
                    data-target="#addTarget" class="btn btn-primary">Add target</button>
        @endif
    </div>
</div>