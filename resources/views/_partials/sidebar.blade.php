@php
use App\Http\Helpers\MenuHelpers;
use Illuminate\Support\Facades\Route;

$permissions = MenuHelpers::Permissions();
$currentRoute = Route::currentRouteName();
@endphp


<div id="left-sidebar" class="sidebar">
    <div class="navbar-brand">
        <i class="fa fa-ravelry" aria-hidden="true"></i> {{ config('app.name')}}
        <button type="button" class="btn-toggle-offcanvas btn btn-sm btn-default float-right"><i class="lnr lnr-menu fa fa-chevron-circle-left"></i></button>
    </div>
    <div class="sidebar-scroll">
        <nav id="left-sidebar-nav" class="sidebar-nav mt-3">
            <ul id="main-menu" class="metismenu">
                @foreach ($permissions as $key=>$value)
                    @if (is_array($value))
                        @php
                            $vals = array_values($value);
                            $active = in_array($currentRoute, $vals) ? 'active' : '';
                        @endphp
                        <li class="{{$active}}"><a href="#uiElements" class="has-arrow"><i class="icon-energy"></i><span>{{$key}}</span></a><ul>
                        @foreach ($value as $menu=>$route)
                            @php
                                $active = $route == $currentRoute ? 'active' : '';
                                $getRoute = Route::has(@$route) ? route($route) : '';
                            @endphp
                            <li class="{{$active}}"><a href="{{$getRoute}}">{{$menu}}</a></li>
                        @endforeach
                        </ul></li>
                    @else
                        @php
                            $active = $value == $currentRoute ? 'active' : '';
                            $getRoute = Route::has(@$value) ? route($value) : '';
                        @endphp
                        <li class="{{$active}}"><a href="{{$getRoute}}"><i class="icon-home"></i><span>{{$key}}</span></a></li>
                    @endif
                @endforeach
            </ul>
        </nav>
    </div>
</div>
