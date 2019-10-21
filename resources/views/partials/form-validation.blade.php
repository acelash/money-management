<div>
    @if (session('message'))
        <div class="alert @if(session('success') == true) alert-success
                              @elseif(session('success') == false) alert-danger
                            @endif alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
            {!! session('message') !!}
        </div>
    @endif
    @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissible show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{!! $error !!}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>