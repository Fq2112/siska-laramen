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
        $totalApp = \App\Accepting::wherehas('getVacancy', function ($q) {
            $q->wherenotnull('recruitmentDate_start')->wherenotnull('recruitmentDate_end');
        })->where('seeker_id', $seeker->id)->where('isApply', true)->count();

        $quizInv = \App\Accepting::wherehas('getVacancy', function ($q) {
            $q->wherenotnull('quizDate_start')->wherenotnull('quizDate_end')
            ->where('quizDate_start', '<=', today()->addDay())
            ->where('quizDate_end', '>=', today());
        })->where('seeker_id', $seeker->id)->where('isApply', true)->count();

        $submittedQuizInv = \App\Accepting::wherehas('getVacancy', function ($q) use ($seeker) {
            $q->wherenotnull('quizDate_start')->wherenotnull('quizDate_end')
            ->where('quizDate_start', '<=', today()->addDay())
            ->where('quizDate_end', '>=', today())
            ->whereHas('getQuizInfo', function ($q) use ($seeker){
                 $q->whereHas('getQuizResult', function ($q) use ($seeker){
                    $q->where('seeker_id', $seeker->id);
                 });
            });
        })->where('seeker_id', $seeker->id)->where('isApply', true)->count();

        $totalQuizInv = $quizInv - $submittedQuizInv;

        $psychoTestInv = \App\Accepting::wherehas('getVacancy', function ($vac) use ($seeker) {
            $vac->whereHas('getQuizInfo', function ($info) use ($seeker) {
                $info->whereHas('getQuizResult', function ($res) use ($seeker) {
                    $res->where('seeker_id', $seeker->id)->where('isPassed', true);
                });
            })->wherenotnull('psychoTestDate_start')->wherenotnull('psychoTestDate_end')
            ->where('psychoTestDate_start', '<=', today()->addDay())
            ->where('psychoTestDate_end', '>=', today());
        })->where('seeker_id', $seeker->id)->where('isApply', true)->count();

        $submittedPsychoTestInv = \App\Accepting::wherehas('getVacancy', function ($vac) use ($seeker) {
            $vac->whereHas('getQuizInfo', function ($info) use ($seeker) {
                $info->whereHas('getQuizResult', function ($res) use ($seeker) {
                    $res->where('seeker_id', $seeker->id)->where('isPassed', true);
                });
            })->wherenotnull('psychoTestDate_start')->wherenotnull('psychoTestDate_end')
            ->where('psychoTestDate_start', '<=', today()->addDay())
            ->where('psychoTestDate_end', '>=', today())
            ->whereHas('getPsychoTestInfo', function ($q) use ($seeker){
                $q->whereHas('getPsychoTestResult', function ($q) use ($seeker){
                    $q->where('seeker_id', $seeker->id);
                });
            });
        })->where('seeker_id', $seeker->id)->where('isApply', true)->count();

        $totalPsychoTestInv = $psychoTestInv - $submittedPsychoTestInv;

        $totalExp = $seeker->total_exp != "" ? $seeker->total_exp : 0;
        $degrees = array();
        $educations = \App\Education::whereHas('seekers', function ($q) {
            $q->where('user_id', Auth::user()->id);
        })->wherenotnull('end_period')->get();
        if (count($educations) > 0) {
            foreach ($educations as $education) {
                $degrees[] = $education->tingkatpend_id;
            }
        }

        $rec = \App\Vacancies::where(function ($query) use ($degrees) {
                foreach ($degrees as $degree) {
                    $query->orWhere('tingkatpend_id', '<=', $degree);
                }
        })->where('isPost', true)->where('pengalaman', '<=', $totalExp)->count();

        $totalBook = \App\Accepting::where('seeker_id', $seeker->id)->where('isBookmark', true)->count();
        $totalInvToApply = \App\Invitation::where('seeker_id', $seeker->id)->count();
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
                                            <li><a href="{{route('seeker.dashboard')}}">Application Status
                                                    <span class="badge">{{$totalApp > 999 ? '999+' : $totalApp }}</span>
                                                </a>
                                            </li>
                                            <li><a href="{{route('seeker.invitation.quiz')}}">Quiz Invitation
                                                    <span class="badge">{{$totalQuizInv > 999 ? '999+' : $totalQuizInv}}
                                                    </span></a>
                                            </li>
                                            <li><a href="{{route('seeker.invitation.psychoTest')}}">Psycho Test
                                                    Invitation
                                                    <span class="badge"
                                                          style="background: #FA5555;">{{$totalPsychoTestInv > 999 ? '999+' : $totalPsychoTestInv}}</span></a>
                                            </li>
                                            <li><a href="{{route('seeker.jobInvitation')}}">Job Invitation
                                                    <span class="badge" style="background: #FA5555;">
                                                        {{$totalInvToApply > 999 ? '999+' : $totalInvToApply}}</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-menu-header">
                                        <label class="nav-header glyphicon-icon-rpad">
                                            <span class="fa fa-briefcase m5"
                                                  style="margin-right: 15px"></span>Job Vacancy
                                            <span class="menu-collapsible-icon glyphicon glyphicon-chevron-down"></span>
                                        </label>
                                        <ul class="nav nav-list tree bullets">
                                            <li><a href="{{route('seeker.recommended.vacancy')}}">Recommended Vacancy
                                                    <span class="badge">{{$rec > 999 ? '999+' : $rec}}</span></a>
                                            </li>
                                            <li><a href="{{route('seeker.bookmarked.vacancy')}}">Bookmarked Vacancy
                                                    <span class="badge">{{$totalBook > 999 ? '999+' : $totalBook}}
                                                    </span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-menu-header">
                                        <label class="nav-header glyphicon-icon-rpad">
                                            <span class="fa fa-user-cog m5" style="margin-right: 10px"></span>Account
                                            Settings
                                            <span class="menu-collapsible-icon glyphicon glyphicon-chevron-down"></span>
                                        </label>
                                        <ul class="nav nav-list tree bullets">
                                            <li><a href="{{route('seeker.edit.profile')}}">Edit Profile</a></li>
                                            <li><a href="{{route('seeker.settings')}}">Change Password</a></li>
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
        var CURRENT_URL = window.location.href.split('#')[0].split('?')[0],
            $SIDEBAR_MENU = $('#sidebar-menu'), $TREE_TOGGLE = $('.nav-header');

        function init_sidebar() {
            $SIDEBAR_MENU.find('a[href="' + CURRENT_URL + '"]').addClass('current-page')
                .parents('.nav-menu-header').children('label').addClass('active')
                .parent().children('ul.tree').slideDown().find('a').css('border-right', '5px solid #fa5555');

            $TREE_TOGGLE.on('click', function () {
                var $this = $(this);

                $TREE_TOGGLE.removeClass('active');
                $this.addClass('active');

                if ($this.next().hasClass('show')) {
                    $this.next().slideUp().find('a').css('border-right', 'none');

                } else {
                    $this.parent().parent().find('.tree').slideUp();
                    $this.next().slideDown().find('a').css('border-right', '5px solid #fa5555');
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
