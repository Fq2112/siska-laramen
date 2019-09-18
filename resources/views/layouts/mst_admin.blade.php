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
    <link href="{{asset('css/daterangepicker.css')}}" rel="stylesheet">
    <!-- bootstrap-datepicker -->
    <link href="{{ asset('css/bootstrap-datepicker.css') }}" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->
    <link href="{{asset('_admins/css/prettify.min.css')}}" rel="stylesheet">
    <!-- bootstrap-select -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.css') }}">
    <!-- Switchery -->
    <link href="{{asset('_admins/css/switchery.min.css')}}" rel="stylesheet">
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
    @stack('styles')
    <style>
        .main_menu .fa {
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
        }

        .anim-icon label {
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
        }

        .dc-view-switcher > button {
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
        }

        .dropdown-menu li:first-child a:before {
            border: none;
        }

        #myDataTable_wrapper .dataTables_filter {
            width: 70%;
            float: left;
        }

        #datatable-buttons_wrapper .dataTables_length {
            width: 35%;
        }

        .myTags {
            list-style: none;
            margin: 0;
            overflow: hidden;
            padding: 0 0 0 .2em;
        }

        .myTags li {
            float: left;
        }

        .myTags li a {
            text-decoration: none;
            cursor: pointer;
        }

        .myTag {
            font-size: 14px;
            background: #eee;
            border-radius: 3px 0 0 3px;
            color: #999;
            display: inline-block;
            height: 26px;
            line-height: 26px;
            padding: 0 20px 0 23px;
            position: relative;
            margin: 0 10px 10px 0;
            -webkit-transition: color 0.2s;
            text-transform: none;
        }

        .myTag::before {
            background: #fff;
            border-radius: 10px;
            box-shadow: inset 0 1px rgba(0, 0, 0, 0.25);
            content: '';
            height: 6px;
            left: 10px;
            position: absolute;
            width: 6px;
            top: 10px;
        }

        .myTag::after {
            background: #fff;
            border-bottom: 13px solid transparent;
            border-left: 10px solid #eee;
            border-top: 13px solid transparent;
            content: '';
            position: absolute;
            right: 0;
            top: 0;
        }

        .myTag:hover {
            background-color: #fa5555;
            color: white;
        }

        .myTag:hover::after {
            border-left-color: #fa5555;
        }

        .myTag-plans:hover {
            background-color: #00ADB5;
            color: white;
        }

        .myTag-plans:hover::after {
            border-left-color: #00ADB5;
        }

        .myTag:hover .myTag-icon {
            display: none;
        }

        .myTag:hover .myTag-close::before {
            font-family: "Font Awesome 5 Free";
            content: '\f057';
            font-style: normal;
        }

        .scroll-content {
            max-height: 470px;
        }

        #myPassword + .glyphicon, #myNew_password + .glyphicon, #myConfirm + .glyphicon {
            cursor: pointer;
            pointer-events: all;
        }
    </style>
</head>

<body class="nav-md">
@php
    $auth = Auth::guard('admin')->user();

    if($auth->isRoot()){
        $feedback = \App\Feedback::where('created_at', '>=', today()->subDays('3')->toDateTimeString())
        ->orderByDesc('id')->get();

        $postings = \App\ConfirmAgency::where('isPaid',false)->wherenotnull('payment_proof')->get();

        $quizSetup = \App\Vacancies::whereHas('getPlan', function ($plan) {
            $plan->where('isQuiz', true);
        })->where('isPost', true)->whereDoesntHave('getQuizInfo')->get();

        $psychoTestSetup = \App\Vacancies::whereHas('getPlan', function ($plan) {
            $plan->where('isPsychoTest', true);
        })->whereHas('getQuizInfo', function ($quiz){
            $quiz->whereHas('getQuizResult');
        })->wherenotnull('psychoTestDate_start')->wherenotnull('psychoTestDate_end')
        ->whereDate('quizDate_end','<=',today())->whereDoesntHave('getPsychoTestInfo')->get();

        $invitations = \App\Vacancies::whereHas('getInvitation', function ($inv){
            $inv->where('isApply', true);
        })->whereDate('recruitmentDate_end', today())->get();

        $acceptings = \App\Vacancies::whereHas('getAccepting', function ($acc){
            $acc->where('isApply', true);
        })->whereDate('recruitmentDate_end', today())->get();

        $quiz_results = \App\Vacancies::whereHas('getAccepting', function ($acc){
            $acc->where('isApply', true);
        })->whereHas('getQuizInfo', function ($info){
            $info->whereHas('getQuizResult');
        })->whereDate('quizDate_end', today())->get();

        $psychoTest_results = \App\Vacancies::whereHas('getAccepting', function ($acc){
            $acc->where('isApply', true);
        })->whereHas('getQuizInfo', function ($info){
            $info->whereHas('getQuizResult');
        })->whereHas('getPsychoTestInfo', function ($psycho){
            $psycho->whereHas('getPsychoTestResult');
        })->whereDate('psychoTestDate_end', today())->get();

        $partnerAPI = \App\PartnerCredential::where('status', false)->get();

        $partnerVacs = \App\PartnerCredential::whereHas('getPartnerVacancy', function($q){
            $q->whereHas('getVacancy', function($vac){
                $vac->where('isPost', false);
            });
        })->get();

        $notifications = count($postings) + count($quizSetup) + count($psychoTestSetup) + count($invitations) +
        count($acceptings) + count($quiz_results) + count($psychoTest_results) + count($partnerAPI) + count($partnerVacs);

    } elseif($auth->isAdmin()){
        $feedback = \App\Feedback::where('created_at', '>=', today()->subDays('3')->toDateTimeString())
        ->orderByDesc('id')->get();

        $postings = \App\ConfirmAgency::where('isPaid',false)->wherenotnull('payment_proof')
        ->whereDate('created_at', '>=', now()->subDay())->get();

        $quizSetup = \App\Vacancies::whereHas('getPlan', function ($plan) {
            $plan->where('isQuiz', true);
        })->where('isPost', true)->whereDoesntHave('getQuizInfo')->get();

        $psychoTestSetup = \App\Vacancies::whereHas('getPlan', function ($plan) {
            $plan->where('isPsychoTest', true);
        })->whereHas('getQuizInfo', function ($quiz){
            $quiz->whereHas('getQuizResult');
        })->wherenotnull('psychoTestDate_start')->wherenotnull('psychoTestDate_end')
        ->whereDate('quizDate_end','<=',today())->whereDoesntHave('getPsychoTestInfo')->get();

        $invitations = \App\Vacancies::whereHas('getInvitation', function ($inv){
            $inv->where('isApply', true);
        })->whereDate('recruitmentDate_end', today())->get();

        $acceptings = \App\Vacancies::whereHas('getAccepting', function ($acc){
            $acc->where('isApply', true);
        })->whereDate('recruitmentDate_end', today())->get();

        $quiz_results = \App\Vacancies::whereHas('getAccepting', function ($acc){
            $acc->where('isApply', true);
        })->whereHas('getQuizInfo', function ($info){
            $info->whereHas('getQuizResult');
        })->whereDate('quizDate_end', today())->get();

        $psychoTest_results = \App\Vacancies::whereHas('getAccepting', function ($acc){
            $acc->where('isApply', true);
        })->whereHas('getQuizInfo', function ($info){
            $info->whereHas('getQuizResult');
        })->whereHas('getPsychoTestInfo', function ($psycho){
            $psycho->whereHas('getPsychoTestResult');
        })->whereDate('psychoTestDate_end', today())->get();

        $notifications = count($postings) + count($quizSetup) + count($psychoTestSetup) + count($invitations) +
        count($acceptings) + count($quiz_results) + count($psychoTest_results);

    } elseif($auth->isSyncStaff()){
        $partnerAPI = \App\PartnerCredential::where('status', false)->get();

        $partnerVacs = \App\PartnerCredential::whereHas('getPartnerVacancy', function($q){
            $q->whereHas('getVacancy', function($vac){
                $vac->where('isPost', false);
            });
        })->get();

        $notifications = count($partnerAPI) + count($partnerVacs);
    }
@endphp
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="{{$auth->isInterviewer() ? route('dashboard.interviewer') : route('home-admin')}}"
                       class="site_title"><i class="fa fa-user-{{$auth->isInterviewer() ? 'tie' : 'secret'}}"></i>
                        <span>SISKA {{$auth->isInterviewer() ? 'Interviewer' : 'Admins'}}</span></a>
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
                            @if(Auth::guard('admin')->user()->isRoot())
                                @include('layouts.partials.sidemenu.root')
                            @elseif(Auth::guard('admin')->user()->isAdmin())
                                @include('layouts.partials.sidemenu.admin')
                            @elseif(Auth::guard('admin')->user()->isInterviewer())
                                @include('layouts.partials.sidemenu.interviewer')
                            @elseif(Auth::guard('admin')->user()->isQuizStaff())
                                @include('layouts.partials.sidemenu.quiz')
                            @elseif(Auth::guard('admin')->user()->isSyncStaff())
                                @include('layouts.partials.sidemenu.sync')
                            @endif
                        </ul>
                    </div>

                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" title="Fullscreen" onclick="fullScreen()">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a href="{{route('home-seeker')}}" data-toggle="tooltip" title="SISKA">
                        <span class="glyphicon glyphicon-globe" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" title="Account Settings" class="btn_settings">
                        <span class="fa fa-user-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" title="Sign Out" class="btn_signOut">
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
                                @if($auth->isRoot() || $auth->isAdmin())
                                    <li><a href="{{route('admin.inbox')}}">
                                            <i class="fa fa-envelope pull-right"></i> Inbox</a></li>
                                @endif
                                <li>
                                    <a class="btn_editProfile">
                                        <span class="badge {{$auth->ava == "" || $auth->ava == "avatar.png" ? 'bg-red' :
                                        'bg-green'}} pull-right">
                                            {{$auth->ava == "" || $auth->ava == "avatar.png" ? '50%' : '100%'}}</span>
                                        <span>Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="btn_settings">
                                        <i class="fa fa-user-cog pull-right"></i> Account Settings</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a class="btn_signOut2">
                                        <i class="fa fa-sign-out-alt pull-right"></i> Sign Out</a>
                                    <form id="logout-form2" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>

                        @if($auth->isRoot() || $auth->isAdmin())
                            <li role="presentation" class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle info-number" data-toggle="dropdown"
                                   aria-expanded="false">
                                    <i class="fa fa-envelope"></i>
                                    <span class="badge bg-green">{{count($feedback)}}</span>
                                </a>
                                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                    @if(count($feedback) > 0)
                                        @foreach($feedback as $row)
                                            @php $user = \App\User::where('email',$row->email); @endphp
                                            <li>
                                                <a href="{{route('admin.inbox',['id' => $row->id])}}">
                                                <span class="image">
                                                    @if($user->count())
                                                        @if($user->first()->ava == "" ||
                                                        $user->first()->ava == "seeker.png")
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
                                        <li>
                                            <a style="text-decoration: none;cursor: text">
                                            <span class="message">There seems to be none of the feedback was found
                                                this 3 days&hellip;</span>
                                            </a>
                                        </li>
                                    @endif
                                    <li>
                                        <div class="text-center">
                                            <a href="{{route('admin.inbox')}}">
                                                <strong>More Messages</strong>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if($auth->isRoot() || $auth->isAdmin() || $auth->isSyncStaff())
                            <li role="presentation" class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle info-number" data-toggle="dropdown"
                                   aria-expanded="false">
                                    <i class="fa fa-bell"></i>
                                    <span class="badge bg-orange">{{$notifications}}</span>
                                </a>
                                <ul id="menu2" class="dropdown-menu list-unstyled msg_list" role="menu">
                                    @if($notifications > 0)
                                        @if(($auth->isRoot() || $auth->isAdmin()) && count($postings) > 0)
                                            <li style="padding: 0;">
                                                <a style="text-decoration: none;cursor: text">
                                                <span><i class="fa fa-briefcase"></i>
                                                    <strong style="margin-left: 5px;text-transform: uppercase">Job Postings</strong></span>
                                                </a>
                                            </li>
                                            @foreach($postings as $posting)
                                                <li>
                                                    <a href="{{route('table.jobPostings').'?q='.$posting->GetAgency->user->name}}">
                                                    <span class="image">
                                                        @if($posting->GetAgency->user->ava == "" ||
                                                        $posting->GetAgency->user->ava == "agency.png")
                                                            <img src="{{asset('images/agency.png')}}">
                                                        @else
                                                            <img src="{{asset('storage/users/'.$posting->GetAgency->user
                                                            ->ava)}}">
                                                        @endif
                                                    </span>
                                                        <span>
                                                        <span>{{$posting->GetAgency->user->name}}</span>
                                                    </span>
                                                        <span class="message">
                                                        The job posting request with <strong
                                                                    style="text-transform: uppercase">{{$posting
                                                        ->getPlan->name}}</strong> from this agency hasn't been approve yet!
                                                    </span>
                                                    </a>
                                                </li>
                                            @endforeach
                                            <li class="divider"
                                                style="margin: 0 6px;padding: 3px;background: none;border-bottom: 2px solid #d8d8d845;"></li>
                                        @endif

                                        @if(($auth->isRoot() || $auth->isAdmin()) && count($quizSetup) > 0)
                                            <li style="padding: 0">
                                                <a style="text-decoration: none;cursor: text">
                                                <span><i class="fa fa-grin-beam"></i>
                                                    <strong style="margin-left: 5px;text-transform: uppercase">Quiz Setup</strong></span>
                                                </a>
                                            </li>
                                            @foreach($quizSetup as $vacancy)
                                                <li>
                                                    <a href="{{route('quiz.info',['vac_ids' => $vacancy->id])}}">
                                                    <span class="image">
                                                        @if($vacancy->agencies->user->ava == "" ||
                                                        $vacancy->agencies->user->ava == "agency.png")
                                                            <img src="{{asset('images/agency.png')}}">
                                                        @else
                                                            <img src="{{asset('storage/users/'.$vacancy->agencies->user->ava)}}">
                                                        @endif
                                                    </span>
                                                        <span>
                                                        <span>{{$vacancy->judul}}</span>
                                                    </span>
                                                        <span class="message">
                                                        Quiz for this vacancy hasn't been set yet!
                                                    </span>
                                                    </a>
                                                </li>
                                            @endforeach
                                            <li class="divider"
                                                style="margin: 0 6px;padding: 3px;background: none;border-bottom: 2px solid #d8d8d845;"></li>
                                        @endif

                                        @if(($auth->isRoot() || $auth->isAdmin()) && count($psychoTestSetup) > 0)
                                            <li style="padding: 0">
                                                <a style="text-decoration: none;cursor: text">
                                                <span><i class="fa fa-comments"></i>
                                                    <strong style="margin-left: 5px;text-transform: uppercase">Psycho Test Setup</strong></span>
                                                </a>
                                            </li>
                                            @foreach($psychoTestSetup as $vacancy)
                                                <li>
                                                    <a href="{{route('psychoTest.info',['vac_ids' => $vacancy->id])}}">
                                                    <span class="image">
                                                        @if($vacancy->agencies->user->ava == "" ||
                                                        $vacancy->agencies->user->ava == "agency.png")
                                                            <img src="{{asset('images/agency.png')}}">
                                                        @else
                                                            <img src="{{asset('storage/users/'.$vacancy->agencies->user->ava)}}">
                                                        @endif
                                                    </span>
                                                        <span>
                                                        <span>{{$vacancy->judul}}</span>
                                                    </span>
                                                        <span class="message">
                                                        Psycho test for this vacancy hasn't been set yet!
                                                    </span>
                                                    </a>
                                                </li>
                                            @endforeach
                                            <li class="divider"
                                                style="margin: 0 6px;padding: 3px;background: none;border-bottom: 2px solid #d8d8d845;"></li>
                                        @endif

                                        @if(($auth->isRoot() || $auth->isAdmin()) && count($invitations) > 0)
                                            <li style="padding: 0">
                                                <a style="text-decoration: none;cursor: text">
                                                <span><i class="fa fa-envelope"></i>
                                                    <strong style="margin-left: 5px;text-transform: uppercase">Applied Invitations</strong></span>
                                                </a>
                                            </li>
                                            @foreach($invitations as $vacancy)
                                                <li>
                                                    <a href="{{route('table.appliedInvitations').'?q='.$vacancy->judul}}">
                                                    <span class="image">
                                                        @if($vacancy->agencies->user->ava == "" ||
                                                        $vacancy->agencies->user->ava == "agency.png")
                                                            <img src="{{asset('images/agency.png')}}">
                                                        @else
                                                            <img src="{{asset('storage/users/'.$vacancy->agencies->user->ava)}}">
                                                        @endif
                                                    </span>
                                                        <span>
                                                        <span>{{$vacancy->judul}}</span>
                                                    </span>
                                                        <span class="message">
                                                        Make sure the applied invitation list for this vacancy are sent today
                                                        to <strong>{{$vacancy->agencies->user->name}}</strong>!
                                                        <span style="color: #fa5555">#This message only appears today.</span>
                                                    </span>
                                                    </a>
                                                </li>
                                            @endforeach
                                            <li class="divider"
                                                style="margin: 0 6px;padding: 3px;background: none;border-bottom: 2px solid #d8d8d845;"></li>
                                        @endif

                                        @if(($auth->isRoot() || $auth->isAdmin()) && count($acceptings) > 0)
                                            <li style="padding: 0">
                                                <a style="text-decoration: none;cursor: text">
                                                <span><i class="fa fa-paper-plane"></i>
                                                    <strong style="margin-left: 5px;text-transform: uppercase">Job Applications</strong></span>
                                                </a>
                                            </li>
                                            @foreach($acceptings as $vacancy)
                                                <li>
                                                    <a href="{{route('table.applications').'?q='.$vacancy->judul}}">
                                                    <span class="image">
                                                        @if($vacancy->agencies->user->ava == "" ||
                                                        $vacancy->agencies->user->ava == "agency.png")
                                                            <img src="{{asset('images/agency.png')}}">
                                                        @else
                                                            <img src="{{asset('storage/users/'.$vacancy->agencies->user->ava)}}">
                                                        @endif
                                                    </span>
                                                        <span>
                                                        <span>{{$vacancy->judul}}</span>
                                                    </span>
                                                        <span class="message">
                                                        Make sure the application list for this vacancy are sent today
                                                        to <strong>{{$vacancy->agencies->user->name}}</strong>!
                                                        <span style="color: #fa5555">#This message only appears today.</span>
                                                    </span>
                                                    </a>
                                                </li>
                                            @endforeach
                                            <li class="divider"
                                                style="margin: 0 6px;padding: 3px;background: none;border-bottom: 2px solid #d8d8d845;"></li>
                                        @endif

                                        @if(($auth->isRoot() || $auth->isAdmin()) && count($quiz_results) > 0)
                                            <li style="padding: 0">
                                                <a style="text-decoration: none;cursor: text">
                                                <span><i class="fa fa-grin-beam"></i>
                                                    <strong style="margin-left: 5px;text-transform: uppercase">Quiz Results</strong></span>
                                                </a>
                                            </li>
                                            @foreach($quiz_results as $vacancy)
                                                <li>
                                                    <a href="{{route('table.quizResults').'?q='.$vacancy->judul}}">
                                                    <span class="image">
                                                        @if($vacancy->agencies->user->ava == "" ||
                                                        $vacancy->agencies->user->ava == "agency.png")
                                                            <img src="{{asset('images/agency.png')}}">
                                                        @else
                                                            <img src="{{asset('storage/users/'.$vacancy->agencies->user->ava)}}">
                                                        @endif
                                                    </span>
                                                        <span>
                                                        <span>{{$vacancy->judul}}</span>
                                                    </span>
                                                        <span class="message">
                                                        Make sure the quiz result list for this vacancy are sent today
                                                        to <strong>{{$vacancy->agencies->user->name}}</strong>!
                                                        <span style="color: #fa5555">#This message only appears today.</span>
                                                    </span>
                                                    </a>
                                                </li>
                                            @endforeach
                                            <li class="divider"
                                                style="margin: 0 6px;padding: 3px;background: none;border-bottom: 2px solid #d8d8d845;"></li>
                                        @endif

                                        @if(($auth->isRoot() || $auth->isAdmin()) && count($psychoTest_results) > 0)
                                            <li style="padding: 0">
                                                <a style="text-decoration: none;cursor: text">
                                                <span><i class="fa fa-comments"></i>
                                                    <strong style="margin-left: 5px;text-transform: uppercase">Psycho Test Results</strong></span>
                                                </a>
                                            </li>
                                            @foreach($psychoTest_results as $vacancy)
                                                <li>
                                                    <a href="{{route('table.psychoTestResults').'?q='.$vacancy->judul}}">
                                                    <span class="image">
                                                        @if($vacancy->agencies->user->ava == "" ||
                                                        $vacancy->agencies->user->ava == "agency.png")
                                                            <img src="{{asset('images/agency.png')}}">
                                                        @else
                                                            <img src="{{asset('storage/users/'.$vacancy->agencies->user->ava)}}">
                                                        @endif
                                                    </span>
                                                        <span>
                                                        <span>{{$vacancy->judul}}</span>
                                                    </span>
                                                        <span class="message">
                                                        Make sure the psycho test result list for this vacancy are sent
                                                        today to <strong>{{$vacancy->agencies->user->name}}</strong>!
                                                        <span style="color: #fa5555">#This message only appears today.</span>
                                                    </span>
                                                    </a>
                                                </li>
                                            @endforeach
                                            <li class="divider"
                                                style="margin: 0 6px;padding: 3px;background: none;border-bottom: 2px solid #d8d8d845;"></li>
                                        @endif

                                        @if(($auth->isRoot() || $auth->isSyncStaff()) && count($partnerAPI) > 0)
                                            <li style="padding: 0;">
                                                <a style="text-decoration: none;cursor: text">
                                                <span><i class="fa fa-handshake"></i>
                                                    <strong style="margin-left: 5px;text-transform: uppercase">Partnership Request</strong></span>
                                                </a>
                                            </li>
                                            @foreach($partnerAPI as $partner)
                                                <li>
                                                    <a href="{{route('partners.credentials.show').'?q='.$partner->name}}">
                                                    <span class="image">
                                                        <img src="{{asset('images/mitra.jpg')}}">
                                                    </span>
                                                        <span><span>{{$partner->email}}</span></span>
                                                        <span class="message">
                                                        Partnership request from
                                                        <strong style="text-transform: uppercase">{{$partner->name}}</strong>
                                                        hasn't been approve yet!
                                                    </span>
                                                    </a>
                                                </li>
                                            @endforeach
                                            <li class="divider"
                                                style="margin: 0 6px;padding: 3px;background: none;border-bottom: 2px solid #d8d8d845;"></li>
                                        @endif

                                        @if(($auth->isRoot() || $auth->isSyncStaff()) && count($partnerVacs) > 0)
                                            <li style="padding: 0;">
                                                <a style="text-decoration: none;cursor: text">
                                                <span><i class="fa fa-handshake"></i>
                                                    <strong style="margin-left: 5px;text-transform: uppercase">Partner Vacancies</strong></span>
                                                </a>
                                            </li>
                                            @foreach($partnerVacs as $partnerVac)
                                                <li>
                                                    <a href="{{route('partners.vacancies.show').'?q='.$partnerVac->name}}">
                                                    <span class="image">
                                                        <img src="{{asset('images/mitra.jpg')}}">
                                                    </span>
                                                        <span>
                                                        <span>{{$partnerVac->name}}</span>
                                                    </span>
                                                        <span class="message">
                                                        Vacancies from this partner hasn't been post yet!
                                                    </span>
                                                    </a>
                                                </li>
                                            @endforeach
                                            <li class="divider"
                                                style="margin: 0 6px;padding: 3px;background: none;border-bottom: 2px solid #d8d8d845;"></li>
                                        @endif
                                    @else
                                        <li>
                                            <a style="text-decoration: none;cursor: text">
                                            <span class="message">There seems to be none of the notification was found&hellip;
                                            </span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endunless
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
                &copy; {{now()->format('Y')}} SISKA. All right reserved. Designed by <a href="https://rabbit-media.net">Rabbit
                    Media</a>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
    <div id="profileModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" style="width: 30%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Edit Profile</h4>
                </div>
                <form method="post" action="{{route('admin.update.profile')}}" enctype="multipart/form-data">
                    {{csrf_field()}} {{method_field('PUT')}}
                    <div class="modal-body">
                        <div class="row form-group">
                            <img src="{{$auth->ava == "" || $auth->ava == "avatar.png" ? asset('images/avatar.png') :
                            asset('storage/admins/'.$auth->ava)}}" class="img-responsive" id="myBtn_img"
                                 style="margin: 0 auto;width: 50%;cursor: pointer" data-toggle="tooltip"
                                 data-placement="bottom"
                                 title="Allowed extension: jpg, jpeg, gif, png. Allowed size: < 2 MB">
                            <hr style="margin: .5em auto">
                            <div class="col-lg-12">
                                <label for="myAva">Avatar</label>
                                <input type="file" name="myAva" style="display: none;" accept="image/*" id="myAva"
                                       value="{{$auth->ava}}">
                                <div class="input-group">
                                    <input type="text" id="myTxt_ava" value="{{$auth->ava}}"
                                           class="browse_files form-control"
                                           placeholder="Upload file here..."
                                           readonly style="cursor: pointer" data-toggle="tooltip"
                                           title="Allowed extension: jpg, jpeg, gif, png. Allowed size: < 2 MB">
                                    <span class="input-group-btn">
                                        <button class="browse_files btn btn-info" type="button">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12 has-feedback">
                                <label for="myName">Name <span class="required">*</span></label>
                                <input id="myName" type="text" class="form-control" maxlength="191" name="myName"
                                       placeholder="Full name" value="{{$auth->name}}" required>
                                <span class="fa fa-id-card form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="settingsModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" style="width: 30%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Account Settings</h4>
                </div>
                <form method="post" action="{{route('admin.update.account')}}">
                    {{csrf_field()}} {{method_field('PUT')}}
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col-lg-12 has-feedback">
                                <label for="myEmail">Email <span class="required">*</span></label>
                                <input id="myEmail" type="email" class="form-control" name="myEmail"
                                       placeholder="Email" value="{{$auth->email}}"
                                        {{$auth->isRoot() ? 'required' : 'readonly'}}>
                                <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12 has-feedback">
                                <label for="myPassword">Current Password <span class="required">*</span></label>
                                <input id="myPassword" type="password" class="form-control" minlength="6"
                                       name="myPassword"
                                       placeholder="Current Password" required>
                                <span class="glyphicon glyphicon-eye-open form-control-feedback right"
                                      aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12 has-feedback">
                                <label for="myNew_password">New Password <span class="required">*</span></label>
                                <input id="myNew_password" type="password" class="form-control" minlength="6"
                                       name="myNew_password" placeholder="New Password" required>
                                <span class="glyphicon glyphicon-eye-open form-control-feedback right"
                                      aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12 has-feedback">
                                <label for="myConfirm">Password Confirmation <span class="required">*</span></label>
                                <input id="myConfirm" type="password" class="form-control" minlength="6"
                                       name="myPassword_confirmation" placeholder="Retype password" required>
                                <span class="glyphicon glyphicon-eye-open form-control-feedback right"
                                      aria-hidden="true"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/hideShowPassword.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('_admins/js/fastclick.js')}}"></script>
<!-- NProgress -->
<script src="{{asset('_admins/js/nprogress.js')}}"></script>
<!-- jQuery Smart Wizard -->
<script src="{{asset('_admins/js/jquery.smartWizard.js')}}"></script>
<!-- morris.js -->
<script src="{{asset('_admins/js/raphael.min.js')}}"></script>
<script src="{{asset('_admins/js/morris.min.js')}}"></script>
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
<!-- bootstrap-progressbar -->
<script src="{{asset('_admins/js/bootstrap-progressbar.min.js')}}"></script>
<!-- bootstrap-daterangepicker -->
<script src="{{asset('js/moment.js')}}"></script>
<script src="{{asset('js/daterangepicker.js')}}"></script>
<!-- bootstrap-datepicker -->
<script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
<!-- bootstrap-datetimepicker -->
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<!-- TinyMCE -->
<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
<!-- bootstrap-wysiwyg -->
<script src="{{asset('_admins/js/bootstrap-wysiwyg.min.js')}}"></script>
<script src="{{asset('_admins/js/jquery.hotkeys.js')}}"></script>
<script src="{{asset('_admins/js/prettify.js')}}"></script>
<!-- bootstrap-select -->
<script src="{{ asset('js/bootstrap-select.js') }}"></script>
<!-- iCheck -->
<script src="{{asset('_admins/js/icheck.min.js')}}"></script>
<!-- Switchery -->
<script src="{{asset('_admins/js/switchery.min.js')}}"></script>
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
<!-- ECharts -->
<script src="{{asset('_admins/js/echarts.min.js')}}"></script>
<!-- Smooth scroll -->
<script src="{{asset('js/smooth-scrollbar.js')}}"></script>
<!-- Custom Theme Scripts -->
<script src="{{asset('_admins/js/custom.min.js')}}"></script>
<script src="{{asset('js/checkMobileDevice.js')}}"></script>
<!-- Nicescroll -->
<script src="{{asset('nicescroll/jquery.nicescroll.js')}}"></script>
<script>
    var editor_config;
    $(function () {
        window.mobilecheck() ? $("body").removeClass('use-nicescroll') : '';
        $(".use-nicescroll").niceScroll({
            cursorcolor: "rgba(0, 0, 0, .5)",
            cursorwidth: "8px",
            background: "rgba(222, 222, 222, .75)",
            cursorborder: 'none',
            // cursorborderradius:0,
            autohidemode: 'leave',
            zindex: 99999999,
        });

        editor_config = {
            branding: false,
            path_absolute: '{{url('/')}}',
            selector: '.use-tinymce',
            height: 250,
            themes: 'modern',
            plugins: [
                'advlist autolink lists link image charmap print preview anchor textcolor',
                'searchreplace visualblocks code',
                'insertdatetime media table contextmenu paste code help wordcount'
            ],
            toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            relative_urls: false,
            file_browser_callback: function (field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth ||
                    document.getElementsByTagName('body')[0].clientWidth,
                    y = window.innerHeight || document.documentElement.clientHeight ||
                        document.getElementsByTagName('body')[0].clientHeight,
                    cmsURL = editor_config.path_absolute + 'filemanager?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + '&type=Images';
                } else {
                    cmsURL = cmsURL + '&type=Files';
                }

                tinyMCE.activeEditor.windowManager.open({
                    file: cmsURL,
                    title: 'File Manager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: 'yes',
                    close_previous: 'no'
                });
            }
        };
        tinymce.init(editor_config);

        $('.datepicker').datepicker({format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, todayBtn: true});

        Scrollbar.initAll();

        @if(session('signed'))
        swal('Signed In!', 'Welcome {{Auth::guard('admin')->user()->name}}! You\'re now signed in.', 'success');
        @endif
    });

    $(".btn_editProfile").on("click", function () {
        $("#profileModal").modal("show");
        $(".browse_files,#myBtn_img").on('click', function () {
            $("#myAva").trigger('click');
        });
        $("#myAva").on('change', function () {
            var files = $(this).prop("files");
            var names = $.map(files, function (val) {
                return val.name;
            });
            var txt = $("#myTxt_ava");
            txt.val(names);
            $("#myTxt_ava[data-toggle=tooltip]").attr('data-original-title', names).tooltip('show');
        });
    });

    $(".btn_settings").on("click", function () {
        $("#settingsModal").modal("show");
    });

    $('#myPassword + .glyphicon').on('click', function () {
        $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
        $('#myPassword').togglePassword();
    });

    $('#myNew_password + .glyphicon').on('click', function () {
        $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
        $('#myNew_password').togglePassword();
    });

    $('#myConfirm + .glyphicon').on('click', function () {
        $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
        $('#myConfirm').togglePassword();
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

    function numberOnly(e, decimal) {
        var key;
        var keychar;
        if (window.event) {
            key = window.event.keyCode;
        } else if (e) {
            key = e.which;
        } else return true;
        keychar = String.fromCharCode(key);
        if ((key == null) || (key == 0) || (key == 8) || (key == 9) || (key == 13) || (key == 27) || (key == 188)) {
            return true;
        } else if ((("0123456789").indexOf(keychar) > -1)) {
            return true;
        } else if (decimal && (keychar == ".")) {
            return true;
        } else return false;
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