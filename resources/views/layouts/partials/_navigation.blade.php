<ul class="nav navbar-nav navbar-right">
    @if(\Illuminate\Support\Facades\Request::is('/*'))
        <li class="active"><a href="#" data-nav-section="home"><span>Home</span></a></li>
        <li><a href="#" data-nav-section="services"><span>Vacancies</span></a></li>
        <li><a href="#" data-nav-section="explore"><span>Industries</span></a></li>
        <li><a href="#" data-nav-section="blog"><span>Blog</span></a></li>
        <li><a href="#" data-nav-section="faq"><span>FAQ</span></a></li>
        {{--@guest
            <li><a href="#" data-nav-section="partner"><span>Partner</span></a></li>@endguest--}}
    @elseif(\Illuminate\Support\Facades\Request::is('agency'))
        <li class="active"><a href="#" data-nav-section="home"><span>Home</span></a></li>
        <li><a href="#" data-nav-section="services"><span>Features</span></a></li>
        <li><a href="#" data-nav-section="pricing"><span>Pricing</span></a></li>
        <li><a href="#" data-nav-section="faq"><span>FAQ</span></a></li>
    @elseif(\Illuminate\Support\Facades\Request::is('info'))
        <li class="active"><a href="#" data-nav-section="home"><span>Home</span></a></li>
        <li><a href="#" data-nav-section="services"><span>Privacy Policy</span></a></li>
        <li><a href="#" data-nav-section="explore"><span>TnC</span></a></li>
        <li><a href="#" data-nav-section="team"><span>Team</span></a></li>
        <li><a href="#" data-nav-section="faq"><span>FAQ</span></a></li>
    @endif
    @if(Auth::guard('web')->check())
        @if(Auth::user()->isAgency())
            <style>
                #fh5co-header #navbar li.call-to-action a:hover {
                    background-color: #00ADB5;
                }

                a:hover, a:active, a:focus {
                    color: #00ADB5;
                }

                #fh5co-header.navbar-fixed-top #navbar li:not(.call-to-action) a:hover,
                #fh5co-header #first-navbar.navbar-fixed-top #navbar li:not(.call-to-action) a:hover {
                    color: #00ADB5;
                }

                @media screen and (max-width: 480px) {
                    #fh5co-header #navbar li.active a {
                        color: #00ADB5;
                    }
                }

                #fh5co-header #navbar li.active a span:before {
                    visibility: visible;
                    -webkit-transform: scaleX(1);
                    transform: scaleX(1);
                    background-color: #00ADB5;
                }

                @media screen and (max-width: 992px) and (max-width: 480px) {
                    #fh5co-header #navbar li.active a {
                        color: #00ADB5;
                    }
                }

                @media screen and (max-width: 992px) {
                    #fh5co-header #navbar li.active a span {
                        display: inline-block;
                        color: #00ADB5;
                    }
                }

                #fh5co-header.navbar-fixed-top #navbar li.active a,
                #fh5co-header #first-navbar.navbar-fixed-top #navbar li.active a {
                    color: #00ADB5 !important;
                }

                @media screen and (max-width: 768px) {
                    #fh5co-header.navbar-fixed-top #navbar li.active a,
                    #fh5co-header #first-navbar.navbar-fixed-top #navbar li.active a {
                        color: #00ADB5 !important;
                    }
                }

                #fh5co-header.navbar-fixed-top #navbar li.active a span:before,
                #fh5co-header #first-navbar.navbar-fixed-top #navbar li.active a span:before {
                    background-color: #00ADB5;
                }
            </style>@endif
        <li class="call-to-action dropdown">
            <a style="cursor: pointer" id="external"
               class="{{ Auth::user()->role == 'agency' ? 'log-in' : 'sign-up' }}"
               data-toggle="dropdown">
                    <span>
                        <img style="margin-right: 7px" width="25" height="25" class="img-circle show_ava"
                             src="@if(Auth::user()->ava == null){{asset('images/avatar.png')}}
                             @elseif(Auth::user()->ava == 'agency.png'){{asset('images/agency.png')}}
                             @elseif(Auth::user()->ava == 'seeker.png'){{asset('images/seeker.png')}}
                             @else{{asset('storage/users/'.Auth::user()->ava)}}@endif">
                        <strong class="aj_name">{{\Illuminate\Support\Str::words(Auth::user()->name, 1,"")}}</strong>
                    </span>
            </a>
            <ul class="dropdown-menu">
                <li><a id="external"
                       style="color: #979797;border-radius: 0;-webkit-border-radius: 0;-moz-border-radius: 0;-ms-border-radius: 0;"
                       target="{{\Illuminate\Support\Facades\Request::is(['quiz','psychoTest']) ? '_blank' : ''}}"
                       href="{{Auth::user()->isSeeker() ? route('seeker.dashboard') : route('agency.dashboard')}}"
                       onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#979797'">
                        <i class="fa fa-tachometer-alt" style="margin-right: 7px"></i>Dashboard</a></li>
                @if(Auth::user()->isAgency())
                    <li><a id="external"
                           style="color: #979797;border-radius: 0;-webkit-border-radius: 0;-moz-border-radius: 0;-ms-border-radius: 0;"
                           href="{{route('agency.vacancy.status')}}"
                           onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#979797'">
                            <i class="fa fa-briefcase" style="margin-right: 9px"></i>Vacancy Status</a></li>
                @endif
                <li><a id="external"
                       style="color: #979797;border-radius: 0;-webkit-border-radius: 0;-moz-border-radius: 0;-ms-border-radius: 0;"
                       target="{{\Illuminate\Support\Facades\Request::is(['quiz','psychoTest']) ? '_blank' : ''}}"
                       href="{{Auth::user()->isSeeker() ? route('seeker.edit.profile') : route('agency.edit.profile')}}"
                       onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#979797'">
                        <i class="fa fa-user-edit" style="margin-right: 5px"></i>Edit Profile</a></li>
                <li><a id="external"
                       style="color: #979797;border-radius: 0;-webkit-border-radius: 0;-moz-border-radius: 0;-ms-border-radius: 0;"
                       target="{{\Illuminate\Support\Facades\Request::is(['quiz','psychoTest']) ? '_blank' : ''}}"
                       href="{{Auth::user()->isSeeker() ? route('seeker.settings') : route('agency.settings')}}"
                       onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#979797'">
                        <i class="fa fa-cogs" style="margin-right: 5px"></i>Account Settings</a></li>
                <li class="divider"></li>
                <li>
                    <a class="btn_signOut" onmouseover="this.style.color='#fff'"
                       onmouseout="this.style.color='#979797'"
                       style="color: #979797;border-radius: 0;-webkit-border-radius: 0;-moz-border-radius: 0;-ms-border-radius: 0;">
                        <i class="fa fa-sign-out-alt" style="margin-right: 8px"></i>Sign Out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                          style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </li>
    @elseif(Auth::guard('admin')->check())
        <style>
            #fh5co-header #navbar li.call-to-action a:hover {
                background-color: #00ADB5;
            }

            a:hover, a:active, a:focus {
                color: #00ADB5;
            }

            #fh5co-header.navbar-fixed-top #navbar li:not(.call-to-action) a:hover,
            #fh5co-header #first-navbar.navbar-fixed-top #navbar li:not(.call-to-action) a:hover {
                color: #00ADB5;
            }

            @media screen and (max-width: 480px) {
                #fh5co-header #navbar li.active a {
                    color: #00ADB5;
                }
            }

            #fh5co-header #navbar li.active a span:before {
                visibility: visible;
                -webkit-transform: scaleX(1);
                transform: scaleX(1);
                background-color: #00ADB5;
            }

            @media screen and (max-width: 992px) and (max-width: 480px) {
                #fh5co-header #navbar li.active a {
                    color: #00ADB5;
                }
            }

            @media screen and (max-width: 992px) {
                #fh5co-header #navbar li.active a span {
                    display: inline-block;
                    color: #00ADB5;
                }
            }

            #fh5co-header.navbar-fixed-top #navbar li.active a,
            #fh5co-header #first-navbar.navbar-fixed-top #navbar li.active a {
                color: #00ADB5 !important;
            }

            @media screen and (max-width: 768px) {
                #fh5co-header.navbar-fixed-top #navbar li.active a,
                #fh5co-header #first-navbar.navbar-fixed-top #navbar li.active a {
                    color: #00ADB5 !important;
                }
            }

            #fh5co-header.navbar-fixed-top #navbar li.active a span:before,
            #fh5co-header #first-navbar.navbar-fixed-top #navbar li.active a span:before {
                background-color: #00ADB5;
            }
        </style>
        <li class="call-to-action dropdown">
            <a style="cursor: pointer" id="external" class="log-in"
               data-toggle="dropdown">
                <span>
                    <img style="margin-right: 7px" width="25" height="25" class="img-circle show_ava"
                         src="{{Auth::guard('admin')->user()->ava == "" ||
                         Auth::guard('admin')->user()->ava == "avatar.png" ? asset('images/avatar.png') :
                         asset('storage/admins/'.Auth::guard('admin')->user()->ava)}}">
                        <strong class="aj_name">{{\Illuminate\Support\Str::words(Auth::guard('admin')->user()
                        ->name, 1,"")}}</strong></span>
            </a>
            <ul class="dropdown-menu">
                <li><a id="external"
                       style="color: #979797;border-radius: 0;-webkit-border-radius: 0;-moz-border-radius: 0;-ms-border-radius: 0;"
                       target="{{\Illuminate\Support\Facades\Request::is(['quiz','psychoTest']) ? '_blank' : ''}}"
                       href="{{Auth::guard('admin')->user()->isInterviewer() ? route('dashboard.interviewer') :
                       route('home-admin')}}" onmouseover="this.style.color='#fff'"
                       onmouseout="this.style.color='#979797'">
                        <i class="fa fa-tachometer-alt" style="margin-right: 5px"></i>Dashboard</a></li>
                @if(Auth::guard('admin')->user()->isRoot() || Auth::guard('admin')->user()->isAdmin())
                <li><a id="external"
                       style="color: #979797;border-radius: 0;-webkit-border-radius: 0;-moz-border-radius: 0;-ms-border-radius: 0;"
                       target="{{\Illuminate\Support\Facades\Request::is(['quiz','psychoTest']) ? '_blank' : ''}}"
                       href="{{route('admin.inbox')}}"
                       onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#979797'">
                        <i class="fa fa-envelope" style="margin-right: 7px"></i>Inbox</a></li>
                <li><a id="external"
                       style="color: #979797;border-radius: 0;-webkit-border-radius: 0;-moz-border-radius: 0;-ms-border-radius: 0;"
                       target="{{\Illuminate\Support\Facades\Request::is(['quiz','psychoTest']) ? '_blank' : ''}}"
                       href="{{route('quiz.info')}}"
                       onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#979797'">
                        <i class="fa fa-grin-beam" style="margin-right: 6px"></i>Quiz</a></li>
                <li><a id="external"
                       style="color: #979797;border-radius: 0;-webkit-border-radius: 0;-moz-border-radius: 0;-ms-border-radius: 0;"
                       target="{{\Illuminate\Support\Facades\Request::is(['quiz','psychoTest']) ? '_blank' : ''}}"
                       href="{{route('psychoTest.info')}}"
                       onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#979797'">
                        <i class="fa fa-comments" style="margin-right: 6px"></i>Psycho Test</a></li>
                @elseif(Auth::guard('admin')->user()->isQuizStaff())
                    <li><a id="external"
                           style="color: #979797;border-radius: 0;-webkit-border-radius: 0;-moz-border-radius: 0;-ms-border-radius: 0;"
                           target="{{\Illuminate\Support\Facades\Request::is(['quiz','psychoTest']) ? '_blank' : ''}}"
                           href="{{route('quiz.questions')}}"
                           onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#979797'">
                            <i class="fa fa-university" style="margin-right: 6px"></i>Bank Soal</a></li>
                @elseif(Auth::guard('admin')->user()->isSyncStaff())
                    <li><a id="external"
                           style="color: #979797;border-radius: 0;-webkit-border-radius: 0;-moz-border-radius: 0;-ms-border-radius: 0;"
                           target="{{\Illuminate\Support\Facades\Request::is(['quiz','psychoTest']) ? '_blank' : ''}}"
                           href="{{route('partners.credentials.show')}}"
                           onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#979797'">
                            <i class="fa fa-shield-alt" style="margin-right: 6px"></i>Partner Credentials</a></li>
                    <li><a id="external"
                           style="color: #979797;border-radius: 0;-webkit-border-radius: 0;-moz-border-radius: 0;-ms-border-radius: 0;"
                           target="{{\Illuminate\Support\Facades\Request::is(['quiz','psychoTest']) ? '_blank' : ''}}"
                           href="{{route('partners.vacancies.show')}}"
                           onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#979797'">
                            <i class="fa fa-briefcase" style="margin-right: 6px"></i>Partner Vacancies</a></li>
                @endif
                <li class="divider"></li>
                <li>
                    <a class="btn_signOut" onmouseover="this.style.color='#fff'"
                       onmouseout="this.style.color='#979797'"
                       style="color: #979797;border-radius: 0;-webkit-border-radius: 0;-moz-border-radius: 0;-ms-border-radius: 0;">
                        <i class="fa fa-sign-out-alt" style="margin-right: 6px"></i>Sign Out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                          style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </li>
    @else
        <li class="call-to-action">
            <a id="external" class="{{ \Illuminate\Support\Facades\Request::is('agency') ? 'log-in' : 'sign-up' }}"
               data-toggle="modal" href="javascript:void(0)" onclick="openRegisterModal();">
                <span>Sign Up</span></a></li>
        <li class="call-to-action">
            <a id="external" class="{{ \Illuminate\Support\Facades\Request::is('agency') ? 'sign-up' : 'log-in' }}"
               href="{{\Illuminate\Support\Facades\Request::is('agency') ? route('home-seeker') : route('home-agency')}}">
                <span>{{ \Illuminate\Support\Facades\Request::is('agency') ? 'Seekers' : 'Agencies' }}</span></a></li>
    @endif
</ul>
