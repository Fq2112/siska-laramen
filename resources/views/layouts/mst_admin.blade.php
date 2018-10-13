<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{asset('favicon.ico')}}" type="image/ico"/>

    <title>@yield('title')</title>

    <!-- Bootstrap -->
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('fonts/fontawesome-free/css/all.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{asset('_admins/css/nprogress.css')}}" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="{{asset('_admins/css/daterangepicker.css')}}" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->
    <link href="{{asset('_admins/css/prettify.min.css')}}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{asset('_admins/css/green.css')}}" rel="stylesheet">
    <!-- Datatables -->
    <link href="{{asset('_admins/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('_admins/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('_admins/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('_admins/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('_admins/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
    <!-- Sweet Alert v2 -->
    <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
    <script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- PNotify -->
    <link href="{{asset('_admins/css/pnotify.css')}}" rel="stylesheet">
    <link href="{{asset('_admins/css/pnotify.buttons.css')}}" rel="stylesheet">
    <link href="{{asset('_admins/css/pnotify.nonblock.css')}}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{asset('_admins/css/custom.css')}}" rel="stylesheet">
    <style>
        .dropdown-menu li:first-child a:before {
            border: none;
        }
    </style>
</head>

<body class="nav-md">
@php
    $auth = Auth::guard('admin')->user();
    $feedback = \App\Feedback::where('created_at', '>=', today()->subDays('3')->toDateTimeString());
@endphp
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="{{route('home-admin')}}" class="site_title"><i class="fa fa-user-secret"></i>
                        <span>SISKA Admins</span></a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <div class="profile clearfix">
                    <div class="profile_pic">
                        <img src="{{$auth->ava == "" || $auth->ava == "avatar.png" ? asset('images/avatar.png') :
                        asset('storage/admins/'.$auth->ava)}}" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Welcome,</span>
                        <h2>{{$auth->name}}</h2>
                    </div>
                </div>
                <!-- /menu profile quick info -->

                <br/>

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <h3>General</h3>
                        <ul class="nav side-menu">
                            <li><a><i class="fa fa-home"></i> Home
                                    <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="{{route('home-admin')}}">Dashboard</a></li>
                                    <li><a href="{{route('admin.inbox')}}">Inbox</a></li>
                                </ul>
                            </li>
                            <li><a><i class="fa fa-table"></i> Tables
                                    <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a>Data Master <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="{{route('table.admins')}}">Admins</a></li>
                                            <li><a href="{{route('table.users')}}">Users</a></li>
                                            <li><a>Requirements <span class="fa fa-chevron-down"></span></a>
                                                <ul class="nav child_menu">
                                                    <li><a href="{{route('table.degrees')}}">Education Degrees</a></li>
                                                    <li><a href="{{route('table.majors')}}">Education Majors</a></li>
                                                    <li><a href="{{route('table.industries')}}">Industries</a></li>
                                                    <li><a href="#">Job Functions</a></li>
                                                    <li><a href="#">Job Levels</a></li>
                                                    <li><a href="#">Job Types</a></li>
                                                    <li><a href="#">Salaries</a></li>
                                                </ul>
                                            </li>
                                            <li><a>Web Contents <span class="fa fa-chevron-down"></span></a>
                                                <ul class="nav child_menu">
                                                    <li><a href="#">Carousels</a></li>
                                                    <li><a href="#">Payment Category</a></li>
                                                    <li><a href="#">Payment Method</a></li>
                                                    <li><a href="#">Plans</a></li>
                                                    <li><a href="#">Nations</a></li>
                                                    <li><a href="#">Provinces</a></li>
                                                    <li><a href="#">Cities</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a>Data Agencies <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="#">Galleries</a></li>
                                            <li><a href="#">Job Vacancies</a></li>
                                        </ul>
                                    </li>
                                    <li><a>Data Seekers <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="#">Attachments</a></li>
                                            <li><a href="#">Educations History</a></li>
                                            <li><a href="#">Language Skills</a></li>
                                            <li><a href="#">Organizations</a></li>
                                            <li><a href="#">Other Skills</a></li>
                                            <li><a href="#">Trainings/Certifications</a></li>
                                            <li><a href="#">Work Experiences</a></li>
                                        </ul>
                                    </li>
                                    <li><a>Data Transaction <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="#">Applications</a></li>
                                            <li><a href="#">Favorite Agencies</a></li>
                                            <li><a href="#">Job Postings</a></li>
                                            <li><a href="#">Job Invitations</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="Settings">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Fullscreen" onclick="fullScreen()">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a href="{{route('home-seeker')}}" data-toggle="tooltip" data-placement="top" title="SISKA">
                        <span class="glyphicon glyphicon-globe" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Logout"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                          style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <nav>
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                               aria-expanded="false">
                                <img src="{{$auth->ava == "" || $auth->ava == "avatar.png" ?
                                asset('images/avatar.png') : asset('storage/admins/'.$auth->ava)}}" alt="">
                                {{$auth->name}}
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li><a href="javascript:;"> Profile</a></li>
                                <li>
                                    <a href="javascript:;">
                                        <span class="badge bg-red pull-right">50%</span>
                                        <span>Settings</span>
                                    </a>
                                </li>
                                <li><a href="javascript:;">Help</a></li>
                                <li>
                                    <a onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out-alt pull-right"></i> Log Out</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>

                        <li role="presentation" class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown"
                               aria-expanded="false">
                                <i class="fa fa-envelope"></i>
                                <span class="badge bg-green">{{$feedback->count()}}</span>
                            </a>
                            <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                @if($feedback->count())
                                    @foreach($feedback->limit(5)->orderByDesc('id')->get() as $row)
                                        @php $user = \App\User::where('email',$row->email); @endphp
                                        <li>
                                            <a>
                                                <span class="image">
                                                    @if($user->count())
                                                        @if($user->first()->ava == "" || $user->first()->ava == "seeker.png")
                                                            <img src="{{asset('images/seeker.png')}}">
                                                        @elseif($user->first()->ava == "agency.png")
                                                            <img src="{{asset('images/agency.png')}}">
                                                        @else
                                                            <img src="{{asset('storage/users/'.$user->first()->ava)}}">
                                                        @endif
                                                    @else
                                                        <img src="{{asset('images/avatar.png')}}">
                                                    @endif
                                                </span>
                                                <span><span>{{$row->name}}</span>
                                                    <span class="time">{{$row->created_at->diffForHumans()}}</span>
                                                </span>
                                                <span class="message">{{\Illuminate\Support\Str::words
                                                ($row->message,15,' ...')}}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                @else
                                    <li><a style="text-decoration: none;cursor: text"><span class="message">
                                                There seems to be none of the feedback was found this 3 days&hellip;</span></a>
                                    </li>
                                @endif
                                <li>
                                    <div class="text-center">
                                        <a href="{{route('admin.inbox')}}">
                                            <strong>See All Feedback</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
    @yield('content')
    <!-- /page content -->

        <!-- footer content -->
        <footer>
            <div class="pull-right">
                &copy; 2018 SISKA. All right reserved. Designed by <a href="http://rabbit-media.net">Rabbit Media</a>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>

<!-- jQuery -->
<script src="{{asset('js/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('_admins/js/fastclick.js')}}"></script>
<!-- NProgress -->
<script src="{{asset('_admins/js/nprogress.js')}}"></script>
<!-- morris.js -->
<script src="{{asset('_admins/js/raphael.min.js')}}"></script>
<script src="{{asset('_admins/js/morris.min.js')}}"></script>
<!-- Chart.js -->
<script src="{{asset('_admins/js/Chart.min.js')}}"></script>
<!-- jQuery Sparklines -->
<script src="{{asset('_admins/js/jquery.sparkline.min.js')}}"></script>
<!-- Flot -->
<script src="{{asset('_admins/js/jquery.flot.js')}}"></script>
<script src="{{asset('_admins/js/jquery.flot.pie.js')}}"></script>
<script src="{{asset('_admins/js/jquery.flot.time.js')}}"></script>
<script src="{{asset('_admins/js/jquery.flot.stack.js')}}"></script>
<script src="{{asset('_admins/js/jquery.flot.resize.js')}}"></script>
<!-- Flot plugins -->
<script src="{{asset('_admins/js/jquery.flot.orderBars.js')}}"></script>
<script src="{{asset('_admins/js/jquery.flot.spline.min.js')}}"></script>
<script src="{{asset('_admins/js/curvedLines.js')}}"></script>
<!-- DateJS -->
<script src="{{asset('_admins/js/date.js')}}"></script>
<!-- bootstrap-daterangepicker -->
<script src="{{asset('js/moment.js')}}"></script>
<script src="{{asset('_admins/js/daterangepicker.js')}}"></script>
<!-- bootstrap-wysiwyg -->
<script src="{{asset('_admins/js/bootstrap-wysiwyg.min.js')}}"></script>
<script src="{{asset('_admins/js/jquery.hotkeys.js')}}"></script>
<script src="{{asset('_admins/js/prettify.js')}}"></script>
<!-- iCheck -->
<script src="{{asset('_admins/js/icheck.min.js')}}"></script>
<!-- Datatables -->
<script src="{{asset('_admins/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('_admins/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('_admins/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('_admins/js/buttons.bootstrap.min.js')}}"></script>
<script src="{{asset('_admins/js/buttons.flash.min.js')}}"></script>
<script src="{{asset('_admins/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('_admins/js/buttons.print.min.js')}}"></script>
<script src="{{asset('_admins/js/dataTables.fixedHeader.min.js')}}"></script>
<script src="{{asset('_admins/js/dataTables.keyTable.min.js')}}"></script>
<script src="{{asset('_admins/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('_admins/js/responsive.bootstrap.js')}}"></script>
<script src="{{asset('_admins/js/dataTables.scroller.min.js')}}"></script>
<script src="{{asset('_admins/js/jszip.min.js')}}"></script>
<script src="{{asset('_admins/js/pdfmake.min.js')}}"></script>
<script src="{{asset('_admins/js/vfs_fonts.js')}}"></script>
<!-- PNotify -->
<script src="{{asset('_admins/js/pnotify.js')}}"></script>
<script src="{{asset('_admins/js/pnotify.buttons.js')}}"></script>
<script src="{{asset('_admins/js/pnotify.nonblock.js')}}"></script>

<!-- Custom Theme Scripts -->
<script src="{{asset('_admins/js/custom.min.js')}}"></script>
<script>
    $(function () {
        // $('.ui-pnotify').remove();
    });

    function fullScreen() {
        if ((document.fullScreenElement && document.fullScreenElement !== null) ||
            (!document.mozFullScreen && !document.webkitIsFullScreen)) {
            if (document.documentElement.requestFullScreen) {
                document.documentElement.requestFullScreen();
            } else if (document.documentElement.mozRequestFullScreen) {
                document.documentElement.mozRequestFullScreen();
            } else if (document.documentElement.webkitRequestFullScreen) {
                document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
            }
        } else {
            if (document.cancelFullScreen) {
                document.cancelFullScreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitCancelFullScreen) {
                document.webkitCancelFullScreen();
            }
        }
    }

    var title = document.getElementsByTagName("title")[0].innerHTML;
    (function titleScroller(text) {
        document.title = text;
        setTimeout(function () {
            titleScroller(text.substr(1) + text.substr(0, 1));
        }, 500);
    }(title + " ~ "));
</script>
@include('layouts.partials._confirm')
@include('layouts.partials.auth.Admins._pnotify')
@stack('scripts')
</body>
</html>
