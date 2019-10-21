<div class="menu-left-container">
    <div class="bg"></div>
    <div class="logo">{{config('app.name')}}</div>
    <div class="menu-left">
        <a class="option @if(Route::currentRouteNamed('home')) active @endif " href="{{route('home')}}">
            <i class="fa fa-home"></i>
            <p class="name">Dashboard</p>
        </a>
        <a class="option @if(Route::currentRouteNamed('reports')) active @endif" href="{{route('reports')}}">
            <i class="fas fa-chart-bar"></i>
            <p class="name">Reports</p>
        </a>
        <a class="option @if(Route::currentRouteNamed('budget')) active @endif" href="{{route('budget')}}">
            <i class="fas fa-wallet"></i>
            <p class="name">Budget</p>
        </a>
        <a class="option @if(Route::currentRouteNamed('resource.list')) active @endif" href="{{route('resource.list')}}">
            <i class="fas fa-piggy-bank"></i>
            <p class="name">Resources</p>
        </a>
        <a class="option @if(Route::currentRouteNamed('cripto-resource.list')) active @endif" href="{{route('cripto-resource.list')}}">
            <i class="fab fa-bitcoin"></i>
            <p class="name">Cripto Resources</p>
        </a>
    </div>
</div>