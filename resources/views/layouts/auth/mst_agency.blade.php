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

        .site-wrapper_left-col .logo:before {
            content: '{{substr($user->name,0,1)}}';
        }

        .site-wrapper_left-col {
            background: #006269;
        }

        .site-wrapper_left-col .logo {
            background: linear-gradient(#00939b, #00434a), #00242c;
        }

        .site-wrapper_left-col .logo:hover, .site-wrapper_left-col .logo:focus {
            background: linear-gradient(#00858d, #00353c), #00181e;
        }

        .site-wrapper_left-col .left-nav a {
            border-left: 0 solid #006269;
        }

        .site-wrapper_left-col .left-nav a:hover, .site-wrapper_left-col .left-nav a:focus, .site-wrapper_left-col .left-nav a.current-page {
            background: #004e55;
        }

        .site-wrapper_top-bar a {
            color: #00ADB5;
        }

        .site-wrapper_top-bar a:hover, .site-wrapper_top-bar a.active {
            background: #00ADB5;
        }

        ul.nav-menu-list-style .nav-header.active {
            border-right: 5px solid #00adb5;
            background: linear-gradient(#00adb5, #004e55), #003037;
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

        #vac-tab-content .tab-pane {
            margin: 0 15px;
        }

        .invoice label {
            box-shadow: 0 0 0 0 rgba(0, 173, 181, 0.5);
        }

        .invoice input:checked + label {
            background-color: #00ADB5;
            border-color: #00ADB5;
            box-shadow: 0 0 0 0.5em rgba(13, 165, 142, 0);
        }

        .invoice input:checked + label:after {
            color: #00ADB5;
        }

        .invoice label:after {
            content: "\f571";
        }
    </style>
@endpush
@section('content')
    @php
        $acc = \App\Accepting::wherehas('getVacancy', function ($q) use ($agency) {
            $q->where('agency_id', $agency->id)->where('isPost', true);
        })->where('isApply', true)->count();

        $inv = \App\Invitation::wherehas('GetVacancy', function ($q) use ($agency) {
            $q->where('agency_id', $agency->id)->where('isPost', true);
        })->count();

        $confirm = \App\ConfirmAgency::where('agency_id',$agency->id)->count();
        $vac = \App\Vacancies::where('agency_id',$agency->id)->where('isPost',true)
        ->whereNotNull('active_period')->whereNotNull('plan_id')
        ->whereNull('interview_date')->whereNull('recruitmentDate_start')->whereNull('recruitmentDate_end')->count();
        $reqExp = array();
        $reqEdu = array();
        foreach (\App\Vacancies::where('agency_id', $agency->id)->where('isPost',true)->get() as $vacancy){
            $reqExp[] = filter_var($vacancy->pengalaman, FILTER_SANITIZE_NUMBER_INT);
            $reqEdu[] = $vacancy->tingkatpend_id;
        }
        $rec = \App\Seekers::whereHas('educations',function ($query) use ($reqEdu){
            foreach ($reqEdu as $edu){
                $query->orWhere('tingkatpend_id','>=',$edu);
            }
        })->where(function ($query) use ($reqExp){
            foreach($reqExp as $exp){
                $query->orWhere('total_exp','>=',$exp);
            }
        })->count();
    @endphp
    <section id="fh5co-services" data-section="services" style="padding-top: 2.9em">
        <div class="wrapper">
            <div class="wrapper_container">
                <!-- start content -->
                <div class="site-wrapper active" id="target">
                    <div class="site-wrapper_left-col">
                        <a href="{{route('agency.profile',['id' => $agency->id])}}"
                           class="logo">{{\Illuminate\Support\Str::words($user->name,2,"")}}</a>
                        <div class="left-nav">
                            <div class="well" id="sidebar-menu">
                                <ul class="nav nav-list nav-menu-list-style">
                                    <li class="nav-menu-header">
                                        <label class="nav-header glyphicon-icon-rpad">
                                                <span class="fa fa-tachometer-alt m5"
                                                      style="margin-right: 15px"></span>Dashboard
                                            <span class="menu-collapsible-icon glyphicon glyphicon-chevron-down">
                                                </span>
                                        </label>
                                        <ul class="nav nav-list tree bullets">
                                            <li><a href="{{route('agency.dashboard')}}">Application Received
                                                    <span class="badge">{{$acc > 999 ? '999+' : $acc}}</span></a>
                                            </li>
                                            <li><a href="{{route('agency.recommended.seeker')}}">Recommended Seeker
                                                    <span class="badge">{{$rec > 999 ? '999+' : $rec}}</span></a>
                                            </li>
                                            <li><a href="{{route('agency.invited.seeker')}}">Invited Seeker
                                                    <span class="badge">{{$inv > 999 ? '999+' : $inv}}</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-menu-header">
                                        <label class="nav-header glyphicon-icon-rpad">
                                            <span class="fa fa-briefcase m5" style="margin-right: 15px"></span>Job
                                            Vacancy
                                            <span class="menu-collapsible-icon glyphicon glyphicon-chevron-down">
                                                        </span>
                                        </label>
                                        <ul class="nav nav-list tree bullets">
                                            <li><a href="{{route('agency.vacancy.status')}}">Vacancy Status
                                                    <span class="badge">
                                                                    {{$confirm > 999 ? '999+' : $confirm}}</span></a>
                                            </li>
                                            <li><a href="{{route('agency.vacancy.show')}}">Vacancy Setup
                                                    <span class="badge">
                                                                    {{$vac > 999 ? '999+' : $vac}}</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-menu-header">
                                        <label class="nav-header glyphicon-icon-rpad">
                                                <span class="fa fa-user-edit m5"
                                                      style="margin-right: 10px"></span>Account Settings
                                            <span class="menu-collapsible-icon glyphicon glyphicon-chevron-down">
                                                </span>
                                        </label>
                                        <ul class="nav nav-list tree bullets">
                                            <li><a href="{{route('agency.edit.profile')}}">Edit Profile</a></li>
                                            <li><a href="{{route('agency.settings')}}">Change Password</a></li>
                                        </ul>
                                    </li>
                                </ul>
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
        $(function () {
            if ($(".nicescrolls").length > 0) {
                $(".nicescrolls").niceScroll({
                    cursorcolor: "{{Auth::user()->isAgency() ? 'rgb(0,173,181)' : 'rgb(255,85,85)'}}",
                    cursorwidth: "8px",
                    background: "rgba(222, 222, 222, .75)",
                    cursorborder: 'none',
                    // cursorborderradius:0,
                    autohidemode: 'leave',
                });
            }
        });

        var CURRENT_URL = window.location.href.split('#')[0].split('?')[0],
            $SIDEBAR_MENU = $('#sidebar-menu'), $TREE_TOGGLE = $('.nav-header');

        function init_sidebar() {
            $SIDEBAR_MENU.find('a[href="' + CURRENT_URL + '"]').addClass('current-page')
                .parents('.nav-menu-header').children('label').addClass('active')
                .parent().children('ul.tree').slideDown().find('a').css('border-right', '5px solid #00adb5');

            $TREE_TOGGLE.on('click', function () {
                var $this = $(this);

                $TREE_TOGGLE.removeClass('active');
                $this.addClass('active');

                if ($this.next().hasClass('show')) {
                    $this.next().slideUp().find('a').css('border-right', 'none');

                } else {
                    $this.parent().parent().find('.tree').slideUp();
                    $this.next().slideDown().find('a').css('border-right', '5px solid #00adb5');
                }
            });
        }

        function init_toggleMenu() {
            $("#toggle").on('click', function () {
                $(".logo").text(function (i, text) {
                    return text === "{{\Illuminate\Support\Str::words($user->name,2,"")}}" ?
                        "{{\Illuminate\Support\Str::words($user->name, 1,"")}}" :
                        "{{\Illuminate\Support\Str::words($user->name,2,"")}}";
                });

                $('.nav-header:not(.active)').find('.tree').slideUp();
            });
        }

        $(function () {
            init_sidebar();
            init_toggleMenu();
        });
    </script>
@endpush
