@extends('layouts.mst_user')
@push('styles')
    <link href="{{ asset('css/myDashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/myTree-Sidenav.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mySearchFilter.css') }}" rel="stylesheet">
    <link href="{{ asset('css/myPagination.css') }}" rel="stylesheet">
    <link href="{{ asset('css/myCheckbox.css') }}" rel="stylesheet">
    <link href="{{ asset('css/myMaps.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fileUploader.css') }}" rel="stylesheet">
    <style>
        .well {
            background: #006269;
        }

        .well .badge {
            background: #00ADB5;
        }

        ul.nav-menu-list-style .nav-header {
            border-top: 1px solid #004e55;
        }

        ul.nav-menu-list-style > li a {
            border-top: 1px solid #004e55;
        }

        .site-wrapper_left-col .logo:before {
            content: '{{substr($user->name,0,1)}}';
        }

        .site-wrapper_left-col {
            background: #006269;
        }

        .site-wrapper_left-col .logo {
            background: #00ADB5;
        }

        .site-wrapper_left-col .logo:hover, .site-wrapper_left-col .logo:focus {
            background: #009da5;
        }

        .site-wrapper_left-col .left-nav a {
            border-left: 0 solid #006269;
        }

        .site-wrapper_left-col .left-nav a:hover, .site-wrapper_left-col .left-nav a:focus, .site-wrapper_left-col .left-nav a.active {
            background: #004e55;
            border-left-color: #00ADB5;
        }

        .site-wrapper_top-bar a {
            color: #00ADB5;
        }

        .site-wrapper_top-bar a:hover, .site-wrapper_top-bar a.active {
            background: #00ADB5;
        }

        .user-item_info .name {
            color: #006269;
        }

        .user-item_info .controls a {
            background: #00ADB5;
        }

        .user-item_info .controls a:hover {
            background: #009da5;
        }

        .chat .head {
            background: #00ADB5;
        }

        .chat .footer {
            background: #006269;
        }

        .chat .footer button {
            background: #00ADB5;
        }

        .chat .footer button:hover {
            background: #009da5;
        }

        .card-read-more button, .card-read-more a {
            color: #00ADB5;
        }

        .browse_files {
            background-color: #00ADB5;
        }

        .tag {
            font-size: 12px;
        }

        .myPagination ul.pagination > li > a,
        .myPagination ul.pagination > li > span {
            color: #00ADB5;
        }

        .myPagination ul.pagination > li > a:hover,
        .myPagination ul.pagination > li > a:focus,
        .myPagination ul.pagination > li > span:hover,
        .myPagination ul.pagination > li > span:focus {
            background-color: #00ADB5;
            border-color: #00ADB5;
        }

        .myPagination ul.pagination > .active > a,
        .myPagination ul.pagination > .active > a:hover,
        .myPagination ul.pagination > .active > a:focus,
        .myPagination ul.pagination > .active > span,
        .myPagination ul.pagination > .active > span:hover,
        .myPagination ul.pagination > .active > span:focus {
            background-color: #00ADB5;
            border-color: #00ADB5;
        }
    </style>
@endpush
@section('content')
    <section id="fh5co-services" data-section="services" style="padding-top: 2.9em">
        <div class="wrapper">
            <div class="wrapper_container">
                <!-- start content -->
                <div class="site-wrapper active" id="target">
                    <div class="site-wrapper_left-col">
                        <a href="{{route('agency.profile',['id' => $agency->id])}}"
                           class="logo">{{\Illuminate\Support\Str::words($user->name,2,"")}}</a>
                        <div class="left-nav">
                            <div class="well">
                                <div>
                                    <ul class="nav nav-list nav-menu-list-style">
                                        <li>
                                            <label class="tree-toggle nav-header glyphicon-icon-rpad">
                                                <span class="fa fa-tachometer-alt m5"
                                                      style="font-size:22px;padding-right: 5px"></span>Dashboard
                                                <span class="menu-collapsible-icon glyphicon glyphicon-chevron-down">
                                                </span>
                                            </label>
                                            <ul class="nav nav-list tree bullets">
                                                <li><a href="#" class="{{ \Illuminate\Support\Facades\Request::is
                                                ('account/agency/dashboard/application_received') ? 'active' : '' }}">
                                                        Application Received<span class="badge">0</span></a></li>
                                                <li><a href="{{route('agency.invited.seeker')}}"
                                                       class="{{ \Illuminate\Support\Facades\Request::is
                                                       ('account/agency/dashboard/invited_seeker') ? 'active' : '' }}">
                                                        Invited Seeker<span class="badge">{{\App\Invitation::where
                                                        ('agency_id',$agency->id)->count()}}</span></a></li>
                                                <li>
                                                    <label class="tree-toggle nav-header glyphicon-icon-rpad">
                                                        <span class="fa fa-briefcase m5"
                                                              style="font-size:22px;padding-right: 5px"></span>Job
                                                        Vacancy
                                                        <span class="menu-collapsible-icon glyphicon glyphicon-chevron-down">
                                                        </span>
                                                    </label>
                                                    <ul class="nav nav-list tree bullets">
                                                        <li><a href="{{route('agency.vacancy.status')}}"
                                                               class="{{ \Illuminate\Support\Facades\Request::is
                                                       ('account/agency/vacancy/status') ? 'active' : '' }}">
                                                                Vacancy Status<span class="badge">
                                                                    {{\App\ConfirmAgency::where('agency_id',$agency->id)
                                                                    ->where('isPaid',false)->count()}}</span></a></li>
                                                        <li><a href="{{route('agency.vacancy.show')}}"
                                                               class="{{ \Illuminate\Support\Facades\Request::is
                                                       ('account/agency/vacancy') ? 'active' : '' }}">
                                                                Vacancy Setup<span
                                                                        class="badge">{{\App\Vacancies::where('agency_id',$agency->id)->where('isPost',true)->whereNotNull('active_period')->whereNull('interview_date')->whereNull('recruitmentDate_start')->whereNull('recruitmentDate_end')->count()}}</span></a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <label class="tree-toggle nav-header glyphicon-icon-rpad">
                                                <span class="fa fa-user-edit m5"
                                                      style="font-size:22px;padding-right: 5px"></span>Account Settings
                                                <span class="menu-collapsible-icon glyphicon glyphicon-chevron-down">
                                                </span>
                                            </label>
                                            <ul class="nav nav-list tree">
                                                <li><a href="{{route('agency.edit.profile')}}"
                                                       class="{{ \Illuminate\Support\Facades\Request::is
                                                       ('account/agency/profile') ? 'active' : '' }}">
                                                        Edit Profile</a></li>
                                                <li><a href="{{route('agency.settings')}}"
                                                       class="{{ \Illuminate\Support\Facades\Request::is
                                                       ('account/agency/settings') ? 'active' : '' }}">
                                                        Change Password</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="site-wrapper_top-bar">
                        <a href="#" id="toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <!-- inner content -->
                @yield('inner-content')
                <!-- end inner content -->
                </div>
                <!-- end content -->
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('js/filter-gridList.js') }}"></script>
    <script>
        $("#toggle").click(function () {
            $(".logo").text(function (i, text) {
                return text === "{{\Illuminate\Support\Str::words($user->name,2,"")}}" ? "{{\Illuminate\Support\Str::words($user->name, 1,"")}}" : "{{\Illuminate\Support\Str::words($user->name,2,"")}}";
            });
            $('.tree-toggle').parent().children('ul.tree').toggle(200);
        });
    </script>
@endpush
