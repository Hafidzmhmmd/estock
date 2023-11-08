@php use App\Helpers\Utils;use Illuminate\Support\Facades\Auth; @endphp

<nav class="navbar navbar-fixed-top py-3">
    <div class="container-fluid">

        <div class="navbar-left">
            <div class="navbar-btn">
                {{-- <a href="index.html"><img src="../assets/images/icon-light.svg" alt="HexaBit Logo" class="img-fluid logo"></a> --}}
                <button type="button" class="btn-toggle-offcanvas"><i class="lnr lnr-menu fa fa-bars"></i></button>
            </div>
            <a href="javascript:void(0);" class="icon-menu btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>
        </div>

        <div class="navbar-right">
            <div id="navbar-menu">
                <ul class="nav navbar-nav">
                    {{-- <li class="dropdown dropdown-animated scale-left">
                        <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                            <i class="icon-bell"></i>
                            <span class="notification-dot"></span>
                            <span class="notification"></span>
                        </a>
                        <ul class="dropdown-menu feeds_widget">
                            <li class="header">You have 5 new Notifications</li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="feeds-left"><i class="fa fa-thumbs-o-up text-success"></i></div>
                                    <div class="feeds-body">
                                        <h4 class="title text-success">7 New Feedback <small class="float-right text-muted">Today</small></h4>
                                        <small>It will give a smart finishing to your site</small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="feeds-left"><i class="fa fa-user"></i></div>
                                    <div class="feeds-body">
                                        <h4 class="title">New User <small class="float-right text-muted">10:45</small></h4>
                                        <small>I feel great! Thanks team</small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="feeds-left"><i class="fa fa-question-circle text-warning"></i></div>
                                    <div class="feeds-body">
                                        <h4 class="title text-warning">Server Warning <small class="float-right text-muted">10:50</small></h4>
                                        <small>Your connection is not private</small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="feeds-left"><i class="fa fa-check text-danger"></i></div>
                                    <div class="feeds-body">
                                        <h4 class="title text-danger">Issue Fixed <small class="float-right text-muted">11:05</small></h4>
                                        <small>WE have fix all Design bug with Responsive</small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="feeds-left"><i class="fa fa-shopping-basket"></i></div>
                                    <div class="feeds-body">
                                        <h4 class="title">7 New Orders <small class="float-right text-muted">11:35</small></h4>
                                        <small>You received a new oder from Tina.</small>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li> --}}
                    <li class="user-account text-light">
                        <div class="dropdown m-0">
                            <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown" aria-expanded="false"><strong>{{ Auth::user()->name }}</strong></a>
                            <ul class="dropdown-menu dropdown-menu-right account" style="will-change: transform; top: 80%;">
                                {{-- <li><a href="page-profile.html"><i class="icon-user"></i>My Profile</a></li>
                                <li><a href="app-inbox.html"><i class="icon-envelope-open"></i>Messages</a></li>
                                <li><a href="javascript:void(0);"><i class="icon-settings"></i>Settings</a></li> --}}
                                {{-- <li class="divider"></li> --}}
                                <li><a href="{{route('logout')}}"><i class="icon-power"></i>Logout</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
