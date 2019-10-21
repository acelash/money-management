<div class="card user-info">
    <div class="card-body row align-items-center">
        <div class="col-6 name">
            <span>Hello,</span> {{auth()->user()->name}}
        </div>
        <div class="col-6 actions">
            <a href=""><i class="fa fa-cog"></i></a>
            <a title="{{ __('Logout') }}" href="{{ route('logout') }}"
               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out-alt"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</div>