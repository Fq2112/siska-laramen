@extends('layouts.mst_user')
@push('styles')
    <link href="{{ asset('css/myDashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/myTree-Sidenav.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mySearchFilter.css') }}" rel="stylesheet">
    <link href="{{ asset('css/myPagination.css') }}" rel="stylesheet">
    <link href="{{ asset('css/myCheckbox.css') }}" rel="stylesheet">
    <style>
        .site-wrapper {
            min-height: 563px;
        }

        .site-wrapper_left-col .logo:before {
            content: '{{substr($user->name,0,1)}}';
        }

        .myCheckbox li:hover {
            box-shadow: -3px 0 #FA5555;
            color: #FA5555;
        }

        .myCheckbox li:hover input[type='checkbox'] {
            border-color: #FA5555;
        }

        .myCheckbox input[type='checkbox']:checked {
            background-color: #FA5555;
            border: 8px solid #FA5555;
        }

        .myCheckbox .active {
            color: #FA5555;
        }
    </style>
@endpush
@section('content')
    @php
        $degrees = array();
        foreach ($seeker->educations as $education) {
            $degrees[] = $education->tingkatpend_id;
        }
        if ($seeker->total_exp == "") {
            $totalExp = 0;
        } else {
            $totalExp = $seeker->total_exp;
        }
        $rec = \App\Vacancies::where('isPost', true)->where('pengalaman', '<=', $totalExp)
        ->where(function ($query) use ($degrees) {
            foreach ($degrees as $degree) {
                $query->orWhere('tingkatpend_id', '<=', $degree);
            }
        })->count();
    @endphp
    <section id="fh5co-services" data-section="services" style="padding-top: 2.9em">
        <div class="wrapper">
            <div class="wrapper_container">
                <!-- start content -->
                <div class="site-wrapper active" id="target">
                    <div class="site-wrapper_left-col">
                        <a href="{{route('seeker.profile',['id' => $seeker->id])}}"
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
                                                <li><a href="{{route('seeker.dashboard')}}"
                                                       class="{{ \Illuminate\Support\Facades\Request::is('account/dashboard/application_status') ? 'active' : '' }}">Application
                                                        Status <span class="badge">
                                                            {{$totalApp > 999 ? '999+' : $totalApp }}</span></a>
                                                </li>
                                                <li><a href="{{route('seeker.invitation.quiz')}}"
                                                       class="{{ \Illuminate\Support\Facades\Request::is('account/dashboard/quiz') ? 'active' : '' }}">Quiz
                                                        Invitation<span class="badge">0</span></a>
                                                </li>
                                                <li><a href="{{route('seeker.invitation.interview')}}"
                                                       class="{{ \Illuminate\Support\Facades\Request::is('account/dashboard/interview') ? 'active' : '' }}">Interview
                                                        Invitation<span class="badge"
                                                                        style="background: #FA5555;">0</span></a>
                                                </li>
                                                <li><a href="{{route('seeker.jobInvitation')}}"
                                                       class="{{ \Illuminate\Support\Facades\Request::is('account/dashboard/job_invitation') ? 'active' : '' }}">Job
                                                        Invitation <span class="badge" style="background: #FA5555;">
                                                            {{$totalInvToApply > 999 ? '999+' : $totalInvToApply}}
                                                        </span></a>
                                                </li>
                                                <li>
                                                    <label class="tree-toggle nav-header glyphicon-icon-rpad">
                                                        <span class="fa fa-briefcase m5"
                                                              style="font-size:22px;padding-right: 5px"></span>Job
                                                        Vacancy
                                                        <span class="menu-collapsible-icon glyphicon glyphicon-chevron-down">
                                                        </span>
                                                    </label>
                                                    <ul class="nav nav-list tree bullets">
                                                        <li><a href="{{route('seeker.recommended.vacancy')}}"
                                                               class="{{ \Illuminate\Support\Facades\Request::is
                                                       ('account/dashboard/recommended_vacancy') ? 'active' : '' }}">
                                                                Recommended Vacancy
                                                                <span class="badge">
                                                                    {{$rec > 999 ? '999+' : $rec}}</span></a>
                                                        </li>
                                                        <li><a href="{{route('seeker.bookmarked.vacancy')}}"
                                                               class="{{ \Illuminate\Support\Facades\Request::is('account/dashboard/bookmarked_vacancy') ? 'active' : '' }}">Bookmarked
                                                                Vacancy<span class="badge">
                                                            {{$totalBook > 999 ? '999+' : $totalBook}}</span></a></li>
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
                                                <li><a href="{{route('seeker.edit.profile')}}"
                                                       class="{{ \Illuminate\Support\Facades\Request::is('account/profile') ? 'active' : '' }}">Edit
                                                        Profile</a></li>
                                                <li><a href="{{route('seeker.settings')}}"
                                                       class="{{ \Illuminate\Support\Facades\Request::is('account/settings') ? 'active' : '' }}">Change
                                                        Password</a></li>
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
