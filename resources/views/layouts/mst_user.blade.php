<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{env('APP_NAME')}}"/>
    <meta name="keywords" content="free html5, free template, free bootstrap, html5, css3, mobile first, responsive"/>
    <meta name="author" content="FreeHTML5.co"/>

    <!-- Facebook and Twitter integration -->
    <meta property="og:title" content=""/>
    <meta property="og:image" content=""/>
    <meta property="og:url" content=""/>
    <meta property="og:site_name" content=""/>
    <meta property="og:description" content=""/>
    <meta name="twitter:title" content=""/>
    <meta name="twitter:image" content=""/>
    <meta name="twitter:url" content=""/>
    <meta name="twitter:card" content=""/>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}">

    {{--<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>--}}
    <link href="https://fonts.googleapis.com/css?family=Oswald:400,700,400italic,700italic" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="{{asset('css/animate.css')}}">
    <!-- Icomoon Icon Fonts-->
    <link rel="stylesheet" href="{{asset('css/icomoon.css')}}">
    <!-- Simple Line Icons -->
    <link rel="stylesheet" href="{{asset('css/simple-line-icons.css')}}">
    <!-- Bootstrap  -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-toggle.css') }}">
    <link rel="stylesheet" href="{{asset('css/daterangepicker.css')}}">
    <!-- Owl Carousel  -->
    <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.theme.default.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{asset('fonts/fontawesome-free/css/all.css')}}">
    <script src="{{asset('fonts/fontawesome-free/js/all.js')}}"></script>
    <!-- Style -->
    <link rel="stylesheet" href="{{asset('jquery-ui/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/myBtn-myInput.css')}}">
    <link rel="stylesheet" href="{{asset('css/additional.css')}}">
    <link rel="stylesheet" href="{{asset('css/stickyAlert.css')}}">
    <link rel="stylesheet" href="{{asset('css/card.css')}}">
    <link rel="stylesheet" href="{{ asset('css/downloadCard-gridList.css') }}">
    <link rel="stylesheet" href="{{asset('css/carousel.css')}}">
    <link rel="stylesheet" href="{{asset('css/scroll-to-top.css')}}">
    <link rel="stylesheet" href="{{asset('css/responsive-list.css')}}">
    <link rel="stylesheet" href="{{ asset('css/loading.css') }}">
    <link rel="stylesheet" href="{{ asset('css/media-query.css') }}">
    <style>
        #fh5co-header .navbar-brand {
            padding-left: 3rem;
            letter-spacing: 1px;
            background: -webkit-linear-gradient(left, #00adb5 ,#fa5555);
            background: -o-linear-gradient(right, #00adb5, #fa5555);
            background: -moz-linear-gradient(right, #00adb5, #fa5555);
            background: linear-gradient(to right, #00adb5 ,#fa5555);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .carousel-indicators {
            position: absolute;
            bottom: 10px;
            left: 50%;
            z-index: 15;
            width: 60%;
            margin-left: -30%;
            padding-left: 0;
            list-style: none;
            text-align: center;
        }

        .carousel-indicators li, .carousel-indicators li.active {
            display: inline-block;
            width: 30px;
            height: 3px;
            margin: 0 3px;
            text-indent: -999px;
            border: unset;
            border-radius: unset;
            cursor: pointer;
            background-color: rgba(255, 255, 255, .5);
        }

        .carousel-indicators li.active {
            background-color: #fff !important;
        }

        .carousel-indicators li::after {
            position: absolute;
            bottom: -10px;
            left: 0;
            display: inline-block;
            width: 100%;
            height: 10px;
            content: "";
        }

        .carousel-indicators li::before {
            position: absolute;
            top: -10px;
            left: 0;
            display: inline-block;
            width: 100%;
            height: 10px;
            content: "";
        }

        .carousel-indicators .active {
            margin: unset;
            width: 12px;
            height: 12px;
            background-color: #fff;
        }

        .anim-icon label {
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
        }

        .dc-view-switcher > button {
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
        }

        #list-lokasi input {
            width: 340px;
            z-index: 2;
            position: fixed;
            margin-top: -5px;
            background-color: rgba(255, 255, 255, .1);
        }

        #list-lokasi input {
            width: 325px;
            background: transparent url({{asset('images/map.png')}}) 98% 50% no-repeat;
            background-size: 8%;
            -webkit-transition: .5s all ease-out;
            transition: .5s all ease-out;
        }

        #list-lokasi:hover input, #list-lokasi:focus input {
            background-color: rgba(255, 255, 255, 1);
        }

        #list-lokasi input:hover, #list-lokasi input:focus {
            width: 325px;
            background: transparent url({{asset('images/map.png')}}) 2% 50% no-repeat;
            background-size: 8%;
            padding-left: 2.25em;
            -webkit-transition: .5s all ease-out;
            transition: .5s all ease-out;
        }

        ul.ui-autocomplete {
            color: #fa5555;
            border-color: #e4e4e4 !important;
            border-radius: 0 0 6px 6px;
        }

        ul.ui-autocomplete .ui-menu-item .ui-state-active,
        ul.ui-autocomplete .ui-menu-item .ui-state-active:hover,
        ul.ui-autocomplete .ui-menu-item .ui-state-active:focus {
            background: #fa5555;
            color: #fff;
            border: 1px solid #fa5555;
        }

        ul.ui-autocomplete .ui-menu-item:last-child .ui-state-active,
        ul.ui-autocomplete .ui-menu-item:last-child .ui-state-active:hover,
        ul.ui-autocomplete .ui-menu-item:last-child .ui-state-active:focus {
            border-radius: 0 0 6px 6px;
        }

        #custom-search-input input {
            padding: 10px;
        }

        .images-preloader {
            width: 100%;
            height: 100%;
            position: fixed;
            z-index: 10000000;
            background-color: #fff;
        }

        .images-preloader .preloader {
            display: block;
            position: absolute;
            top: 50%;
            left: 50%;
            height: 50px;
            width: 50px;
            margin: -25px 0 0 -25px;
            border-radius: 50%;
        }

        .images-preloader .preloader:before,
        .images-preloader .preloader:after {
            content: "";
            border: 3px solid {{Auth::guard('admin')->check() || Auth::check() && Auth::user()->isAgency() ? '#00ADB5' : '#FA5555'}};
            border-radius: 50%;
            width: 50px;
            height: 50px;
            position: absolute;
            left: 0;
        }

        .images-preloader .preloader:before {
            transform: scale(1, 1);
            opacity: 1;
            -webkit-animation: outside .6s infinite linear;
            animation: outside .6s infinite linear
        }

        .images-preloader .preloader:after {
            transform: scale(0, 0);
            opacity: 0;
            -webkit-animation: inside .6s infinite linear;
            animation: inside .6s infinite linear
        }

        @-webkit-keyframes inside {
            from {
                -webkit-transform: scale(.5, .5);
                opacity: 0
            }
            to {
                -webkit-transform: scale(1, 1);
                opacity: 1
            }
        }

        @keyframes inside {
            from {
                transform: scale(.5, .5);
                opacity: 0
            }
            to {
                transform: scale(1, 1);
                opacity: 1
            }
        }

        @-webkit-keyframes outside {
            from {
                -webkit-transform: scale(1, 1);
                opacity: 1
            }
            to {
                -webkit-transform: scale(1.5, 1.5);
                opacity: 0
            }
        }

        @keyframes outside {
            from {
                -webkit-transform: scale(1, 1);
                opacity: 1
            }
            to {
                -webkit-transform: scale(1.5, 1.5);
                opacity: 0
            }
        }
    </style>
@stack('styles')
<!-- Sweet Alert v2 -->
    <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
    <script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Modal -->
    <script src="{{ asset('js/modal.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    <!-- Modernizr JS -->
    <script src="{{asset('js/modernizr-2.6.2.min.js')}}"></script>
    <!-- FOR IE9 below -->
<!--[if lt IE 9]>
    <script src="{{asset('js/respond.min.js')}}"></script>
    <![endif]-->
    <script src='https://www.google.com/recaptcha/api.js?onload=recaptchaCallback&render=explicit' async defer></script>
</head>
<body class="use-nicescroll">
<div class="images-preloader">
    <div class="preloader"></div>
</div>
<a href="#" onclick="scrollToTop()" title="Go to top"><strong class="to-top" style="color: #fff">TOP</strong></a>

<header role="banner" id="fh5co-header">
    <div class="fluid-container">
        <nav class="navbar navbar-default" id="first-navbar">
            <div class="navbar-header">
                <!-- Mobile Toggle Menu Button -->
                <a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle" data-toggle="collapse"
                   data-target="#navbar" aria-expanded="false" aria-controls="navbar"><i></i></a>
                <a class="navbar-brand" target="{{\Illuminate\Support\Facades\Request::is(['quiz','psychoTest']) ?
                '_blank' : ''}}" href="{{Auth::check() && Auth::user()->isAgency() ? route('home-agency') :
                route('home-seeker')}}">{{env('APP_NAME')}}</a>
                @if(Auth::guest() || Auth::user()->isAgency() && \Illuminate\Support\Facades\Request::is('search*') ||
                Auth::user()->isSeeker() && !\Illuminate\Support\Facades\Request::is
                (['account/job_vacancy/recommended_vacancy','quiz','psychoTest']))
                    <form class="navbar-form search-form form-horizontal" role="search"
                          action="{{route('search.vacancy')}}"
                          style="display: {{Auth::guard('admin')->check() && \Illuminate\Support\Facades\Request::is(['quiz','psychoTest']) ? 'none' : ''}}">
                        <div id="custom-search-input">
                            <div class="input-group">
                                <div class="input-group-btn dropdown">
                                    <button id="lokasi" type="button" class="btn btn-default dropdown-toggle"
                                            data-toggle="dropdown" aria-expanded="false" title="Pilih lokasi">
                                        {{empty($location) ? 'filter' : $location}}
                                        <span class="fa fa-caret-down"></span>
                                    </button>
                                    <ul class="dropdown-menu scrollable-menu" id="list-lokasi">
                                        <input class="form-control" type="text" placeholder="Search location&hellip;"
                                               id="txt_filter" onkeyup="filterFunction()" autofocus>
                                        <li id="divider" class="divider"></li>
                                        @foreach($provinces as $province)
                                            <li class="province{{$province->id}} dropdown-header">
                                                <strong style="font-size: 15px;margin-left: -1em">{{$province->name}}</strong>
                                            </li>
                                            @foreach($province->cities as $city)
                                                <li data-value="{{$city->id}}" data-id="{{$province->id}}">
                                                    <a style="font-size: 15px;cursor: pointer;">{{substr($city->name, 0, 2)=="Ko" ? substr($city->name,5) : substr($city->name,10)}}</a>
                                                </li>
                                            @endforeach
                                            <li class="province{{$province->id}} divider"></li>
                                        @endforeach
                                        <li class="not_found dropdown-header" style="display: none;">
                                            <strong>&nbsp;</strong></li>
                                    </ul>
                                </div>
                                <input id="txt_keyword" type="text" name="q" class="form-control myInput input-lg"
                                       onkeyup="showResetBtn(this.value)" autocomplete="off"
                                       placeholder="Job Title or Agency's Name&hellip;"
                                       value="{{!empty($keyword) ? $keyword : ''}}">
                                <input type="hidden" name="loc" id="txt_location"
                                       value="{{!empty($location) ? $location : ''}}">
                                @if(\Illuminate\Support\Facades\Request::is('search*'))
                                    <input type="hidden" value="{{$sort}}" name="sort" id="txt_sort">
                                @endif
                                <span class="input-group-btn">
                                    <button type="reset" class="btn btn-info btn-lg" id="btn_reset">
                                        <span class="glyphicon glyphicon-remove">
                                            <span class="sr-only">Close</span>
                                        </span>
                                    </button>
                                    <button id="cari" class="btn btn-info btn-lg" type="submit">
                                        <i class="glyphicon glyphicon-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                @include('layouts.partials._navigation')
            </div>
        </nav>
    </div>
</header>

<!-- modal sign up -->
<div class="modal fade login" id="loginModal">
    <div class="modal-dialog login animated">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Login with</h4>
            </div>
            <div class="modal-body">
                <!-- Sign in form -->
                <div class="box">
                    <div class="content">
                        @if(!\Illuminate\Support\Facades\Request::is('agency'))
                            <div class="social">
                                <a class="circle github" href="{{route('redirect', ['provider' => 'github'])}}"
                                   data-toggle="tooltip" data-title="Github" data-placement="left">
                                    <i class="fab fa-github fa-fw"></i>
                                </a>
                                <a id="facebook_login" class="circle facebook"
                                   href="{{route('redirect', ['provider' => 'facebook'])}}"
                                   data-toggle="tooltip" data-title="Facebook" data-placement="top">
                                    <i class="fab fa-facebook-f fa-fw"></i>
                                </a>
                                <a id="linkedin_login" class="circle linkedin"
                                   href="{{route('redirect', ['provider' => 'linkedin'])}}"
                                   data-toggle="tooltip" data-title="Linkedin" data-placement="bottom">
                                    <i class="fab fa-linkedin-in fa-fw"></i>
                                </a>
                                {{--<a class="circle twitter" href="{{route('redirect', ['provider' => 'twitter'])}}"
                                   data-toggle="tooltip" data-title="Twitter" data-placement="bottom">
                                    <i class="fab fa-twitter fa-fw"></i>
                                </a>--}}
                                <a id="google_login" class="circle google"
                                   href="{{route('redirect', ['provider' => 'google'])}}"
                                   data-toggle="tooltip" data-title="Google+" data-placement="right">
                                    <i class="fab fa-google-plus-g fa-fw"></i>
                                </a>
                            </div>
                            <div class="division">
                                <div class="line l"></div>
                                <span>or</span>
                                <div class="line r"></div>
                            </div>
                        @endif
                        <div class="error"></div>
                        <div class="form loginBox">
                            @if(session('success') || session('recovered'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                    </button>
                                    <h4><i class="icon fa fa-check"></i> Alert!</h4>
                                    {{session('success') ? session('success') : session('recovered')}}
                                </div>
                            @elseif(session('error') || session('inactive'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                    </button>
                                    <h4><i class="icon fa fa-times"></i> Alert!</h4>
                                    {{session('error') ? session('error') : session('inactive')}}
                                </div>
                            @endif
                            <form method="post" accept-charset="UTF-8" class="form-horizontal"
                                  action="{{ route('login') }}" id="form-login">
                                {{ csrf_field() }}

                                <div class="row has-feedback">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="email" placeholder="Email"
                                               name="email" value="{{ old('email') }}" required>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row has-feedback">
                                    <div class="col-lg-12">
                                        <input id="log_password" class="form-control" type="password"
                                               placeholder="Password" name="password" minlength="6" required>
                                        <span class="glyphicon glyphicon-eye-open form-control-feedback"></span>
                                        <span class="help-block">
                                            @if(session('error'))
                                                <strong>{{ $errors->first('password') }}</strong>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="row form-group" style="font-size: 15px">
                                    <div class="col-lg-6 checkbox" style="margin: -10px 0">
                                        <label>
                                            <input type="checkbox" name="remember" {{old('remember') ? 'checked' : ''}}
                                            style="position: relative"> Remember me
                                        </label>
                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <a href="javascript:openEmailModal()" style="text-decoration: none">Forgot
                                            password?</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input id="btn_login" class="btn btn-default btn-login" type="submit"
                                               value="SIGN IN" style="background: #FA5555;border-color: #FA5555">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sign up form -->
                <div class="box">
                    <div class="content registerBox" style="display:none;">
                        <div class="form">
                            @if ($errors->has('email'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                    </button>
                                    <h4><i class="icon fa fa-times"></i> Alert!</h4>
                                    {{ $errors->first('email') }}
                                </div>
                            @elseif($errors->has('password') || $errors->has('name'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                    </button>
                                    <h4><i class="icon fa fa-times"></i> Alert!</h4>
                                    {{ $errors->has('password') ? $errors->first('password') : $errors->first('name') }}
                                </div>
                            @endif
                            <div id="reg_errorAlert"></div>
                            <form method="post" accept-charset="UTF-8" class="form-horizontal"
                                  action="{{ route('register') }}" id="form-register">
                                {{ csrf_field() }}
                                <input type="hidden" name="role" value="{{\Illuminate\Support\Facades\Request::is
                                ('agency*') ? 'agency' : 'seeker'}}">
                                <div class="row has-feedback">
                                    <div class="col-lg-12">
                                        <input id="reg_name" type="text" placeholder="Full name"
                                               class="form-control" name="name" required>
                                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row has-feedback">
                                    <div class="col-lg-12">
                                        <input id="reg_email" class="form-control" type="email"
                                               placeholder="Email" name="email" required>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row has-feedback">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="password" placeholder="Password"
                                               id="reg_password" name="password" minlength="6" required>
                                        <span class="glyphicon glyphicon-eye-open form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row has-feedback">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="password" placeholder="Retype password"
                                               id="reg_password_confirm" name="password_confirmation"
                                               minlength="6" required>
                                        <span class="glyphicon glyphicon-eye-open form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12" style="font-size: 14px;text-align: justify">
                                        <small>
                                            By continuing this, you acknowledge that you accept on {{env('APP_NAME')}}
                                            <a href="{{route('info.siska')}}#privacy-policy" target="_blank"
                                               style="text-decoration: none">Privacy Policies</a> and
                                            <a href="{{route('info.siska')}}#terms-conditions" target="_blank"
                                               style="text-decoration: none">Terms & Conditions</a>.
                                        </small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12" id="recaptcha-register"></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input id="btn_register" class="btn btn-default btn-register" type="submit"
                                               value="CREATE ACCOUNT" style="background: #00ADB5;border-color: #00ADB5"
                                               disabled>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Reset password form -->
                <div class="box">
                    <div class="content emailBox" style="display:none;">
                        <div class="form">
                            @if(session('resetLink') || session('resetLink_failed'))
                                <div class="alert alert-{{session('resetLink') ? 'success' : 'danger'}} alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                    </button>
                                    <h4><i class="icon fa fa-{{session('resetLink') ? 'check' : 'times'}}"></i> Alert!
                                    </h4>
                                    {{session('resetLink') ? session('resetLink') : session('resetLink_failed')}}
                                </div>
                            @endif
                            <form method="post" accept-charset="UTF-8" class="form-horizontal"
                                  action="{{ route('password.email') }}">
                                {{ csrf_field() }}

                                <div class="row {{ $errors->has('Email') ? ' has-error' : '' }} has-feedback">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="email" placeholder="Email" name="email"
                                               value="{{ old('email') }}" required>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input class="btn btn-default btn-login" type="submit"
                                               value="send password reset link"
                                               style="background: #FA5555;border-color: #FA5555">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Recovery password form -->
                <div class="box">
                    @if(session('recover_failed'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                            </button>
                            <h4><i class="icon fa fa-times"></i> Alert!</h4>
                            {{ session('recover_failed') }}
                        </div>
                    @endif
                    <div class="content passwordBox" style="display:none;">
                        <div id="forg_errorAlert"></div>
                        <div class="form">
                            <form id="form-recovery" method="post" accept-charset="UTF-8" class="form-horizontal"
                                  action="{{route('password.request',
                                  ['token' => session('reset') ? session('reset')['token'] : old('token')])}}">
                                {{ csrf_field() }}
                                <div class="row {{ $errors->has('Email') ? ' has-error' : '' }} has-feedback">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="email" placeholder="Email" name="email"
                                               value="{{ old('email') }}" required>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row {{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
                                    <div class="col-lg-12">
                                        <input id="forg_password" class="form-control" type="password"
                                               placeholder="New Password" name="password" minlength="6" required>
                                        <span class="glyphicon glyphicon-eye-open form-control-feedback"></span>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row {{ $errors->has('password_confirmation') ? ' has-error' : '' }} has-feedback">
                                    <div class="col-lg-12">
                                        <input id="forg_password_confirm" class="form-control" type="password"
                                               placeholder="Retype password" name="password_confirmation"
                                               minlength="6" onkeyup="return checkForgotPassword()" required>
                                        <span class="glyphicon glyphicon-eye-open form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input class="btn btn-default btn-login btn-password" type="submit"
                                               value="reset password" style="background: #FA5555;border-color: #FA5555">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Partnership -->
                <div class="box">
                    <div class="content partnershipBox" style="display: none">
                        <div class="form">
                            <form method="post" accept-charset="UTF-8" class="form-horizontal" id="form-partnership">
                                {{ csrf_field() }}
                                <div class="row has-feedback">
                                    <div class="col-lg-12">
                                        <input id="partnership_name" type="text"
                                               placeholder="University/institution/instance name"
                                               class="form-control" name="name" autofocus required>
                                        <span class="glyphicon glyphicon-education form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row has-feedback">
                                    <div class="col-lg-12">
                                        <input id="partnership_email" class="form-control" type="email"
                                               placeholder="Email address" name="email" required>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row has-feedback">
                                    <div class="col-lg-12">
                                        <input id="partnership_phone" placeholder="Phone number" type="text"
                                               maxlength="13" class="form-control" name="phone"
                                               onkeypress="return numberOnly(event, false)" required>
                                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row has-feedback">
                                    <div class="col-lg-12">
                                        <input id="partnership_uri" placeholder="SiskaLTE base URI: http://&hellip;"
                                               type="text" class="form-control" name="uri" required>
                                        <span class="glyphicon glyphicon-globe form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12" id="recaptcha-partnership"></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input id="btn_partnership" class="btn btn-default btn-login" type="submit"
                                               value="SUBMIT"
                                               style="background: linear-gradient(#eb4b4b, #732f2f), #4b2222;;border-color: transparent"
                                               disabled>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="forgot login-footer">
                    <span>Looking to <a href="javascript:showRegisterForm()"
                                        style="color: #00ADB5;">create an account</a>?</span>
                </div>
                <div class="forgot register-footer" style="display:none">
                    <span>Already have an account? <a href="javascript:showLoginForm()"
                                                      style="color: #FA5555">Sign In</a></span>
                </div>
                <div class="forgot partnership-footer" style="display:none">
                    <span style="font-size: 17px">Looking for <a href="https://github.com/Fq2124/siska-lte"
                                                                 target="_blank"
                                                                 style="color: #fa5555;">SiskaLTE</a> installation guide?</span>
                </div>
            </div>
        </div>
    </div>
</div>

@yield('content')

<div id="fh5co-footer" role="contentinfo">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <h3 class="section-title">Unduh Aplikasi Kami, Gratis!</h3>
                <div class="row" style="border-bottom: 1px solid #eee">
                    <div class="col-lg-12">
                        <img class="download-phone-ico" src="{{asset('images/phone.png')}}">
                        <div class="download-apps-ico">
                            <a href="https://play.google.com/store/apps/details?id=com.kariernesia.mobile">
                                <img class="zoom img-responsive" src="{{asset('images/GooglePlay.png')}}">
                            </a>
                            <hr>
                            <a href="https://itunes.apple.com/id/app/kariernesia.com/id1143444473?mt=8">
                                <img class="zoom img-responsive" src="{{asset('images/AppStore.png')}}">
                            </a>
                        </div>
                    </div>
                </div>
                <p style="margin-top: 0;" class="copy-right">
                    <a href="{{route('info.siska')}}#privacy-policy" target="_blank">
                        Privacy Policy</a><span> &middot; </span>
                    <a href="{{route('info.siska')}}#terms-conditions" target="_blank">
                        Terms & Conditions</a><span> &middot; </span>
                    <a href="{{route('info.siska')}}#team" target="_blank">
                        Get in Touch</a><span> &middot; </span>
                    <a href="{{route('info.siska')}}#faqs" target="_blank">
                        FAQ</a><br>
                    &copy; {{now()->format('Y').' '.env('APP_NAME')}}. All Rights Reserved.<br>Designed by
                    <a href="https://rabbit-media.net/" target="_blank">Rabbit Media</a>.<br>
                </p>
            </div>

            <div class="col-lg-4">
                <h3 class="section-title">Lokasi Kami</h3>
                <ul class="contact-info">
                    <li><i class="icon-map-marker"></i>Ketintang, Gayungan, Ketintang, Gayungan, Surabaya, Jawa Timur
                        &mdash; 60231
                    </li>
                    <li><i class="icon-phone"></i><a href="tel:{{env('APP_PHONE')}}">{{env('APP_PHONE')}}</a></li>
                    <li><i class="icon-envelope"></i><a href="mailto:{{env('MAIL_USERNAME')}}">{{env('MAIL_USERNAME')}}</a></li>
                    <li><i class="icon-globe2"></i><a href="{{env('APP_URL')}}" target="_blank">{{str_replace('https://', 'www.', env('APP_URL'))}}</a></li>
                </ul>
                <h3 class="section-title">Ikuti Kami</h3>
                <ul class="social-media">
                    <li><a href="https://fb.com/kariernesia" class="facebook" target="_blank"><i class="icon-facebook"></i></a>
                    </li>
                    <li><a href="https://twitter.com/kariernesia" class="twitter" target="_blank"><i
                                    class="icon-twitter"></i></a></li>
                    <li><a href="https://instagram.com/kariernesia" class="instagram" target="_blank"><i
                                    class="icon-instagram"></i></a></li>
                    <li><a href="https://github.com/Fq2112/siska-laramen" class="github" target="_blank"><i
                                    class="icon-github"></i></a></li>
                </ul>
            </div>

            <div class="col-lg-4">
                <h3 class="section-title">Tinggalkan Kami Pesan</h3>
                <form class="contact-form" method="post" action="{{route('contact.submit')}}">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="name" class="sr-only">Name</label>
                        <input name="name" type="text" class="form-control" id="name" placeholder="Name"
                               value="{{ Auth::guest() ? '' : Auth::user()->name}}"
                               {{\Illuminate\Support\Facades\Request::is(['quiz','psychoTest']) ? 'disabled' : ''}}
                               required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="sr-only">Email</label>
                        <input name="email" type="email" class="form-control" id="email" placeholder="Email"
                               value="{{ Auth::guest() ? '' : Auth::user()->email}}"
                               {{\Illuminate\Support\Facades\Request::is(['quiz','psychoTest']) ? 'disabled' : ''}}
                               required>
                    </div>
                    <div class="form-group">
                        <label for="subject" class="sr-only">Subject</label>
                        <input name="subject" type="text" class="form-control" id="subject" placeholder="Subject"
                                {{\Illuminate\Support\Facades\Request::is(['quiz','psychoTest']) ? 'disabled' : ''}}>
                    </div>
                    <div class="form-group">
                        <label for="message" class="sr-only">Message</label>
                        <textarea name="message" class="form-control" id="message" rows="5" placeholder="Message"
                                  {{\Illuminate\Support\Facades\Request::is(['quiz','psychoTest']) ? 'disabled' : ''}}
                                  required></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="btn-submit" class="btn btn-send-message btn-md"
                                {{\Illuminate\Support\Facades\Request::is(['quiz','psychoTest']) ? 'disabled' : ''}}>
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@if(\Illuminate\Support\Facades\Request::is('/*','agency*','info*'))
    <div id="map" class="fh5co-map"></div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIljHbKjgtTrpZhEiHum734tF1tolxI68"></script>
    <script>
        var google;

        function init() {
            var myLatlng = new google.maps.LatLng(-7.317174, 112.725614);

            var mapOptions = {
                zoom: 19,
                center: myLatlng,
                scrollwheel: true,
                styles: [{
                    "featureType": "administrative.land_parcel",
                    "elementType": "all",
                    "stylers": [{"visibility": "on"}]
                }, {
                    "featureType": "landscape.man_made",
                    "elementType": "all",
                    "stylers": [{"visibility": "on"}]
                }, {"featureType": "poi", "elementType": "labels", "stylers": [{"visibility": "on"}]}, {
                    "featureType": "road",
                    "elementType": "labels",
                    "stylers": [{"visibility": "simplified"}, {"lightness": 20}]
                }, {
                    "featureType": "road.highway",
                    "elementType": "geometry",
                    "stylers": [{"hue": "#f49935"}]
                }, {
                    "featureType": "road.highway",
                    "elementType": "labels",
                    "stylers": [{"visibility": "simplified"}]
                }, {
                    "featureType": "road.arterial",
                    "elementType": "geometry",
                    "stylers": [{"hue": "#fad959"}]
                }, {
                    "featureType": "road.arterial",
                    "elementType": "labels",
                    "stylers": [{"visibility": "on"}]
                }, {
                    "featureType": "road.local",
                    "elementType": "geometry",
                    "stylers": [{"visibility": "simplified"}]
                }, {
                    "featureType": "road.local",
                    "elementType": "labels",
                    "stylers": [{"visibility": "simplified"}]
                }, {
                    "featureType": "transit",
                    "elementType": "all",
                    "stylers": [{"visibility": "on"}]
                }, {
                    "featureType": "water",
                    "elementType": "all",
                    "stylers": [{"hue": "#a1cdfc"}, {"saturation": 30}, {"lightness": 49}]
                }]
            };

            var mapElement = document.getElementById('map');

            var map = new google.maps.Map(mapElement, mapOptions);

            var contentString =
                '<div id="iw-container">' +
                '<div class="iw-title">JTIF UNESA</div>' +
                '<div class="iw-content">' +
                '<div class="iw-subTitle">Brief History</div>' +
                '<img src="{{asset('images/unesa.jpg')}}" style="width: 50%">' +
                '<p><b>JTIF</b> (Jurusan Teknik Informatika), merupakan sebuah Jurusan baru yang sangat bergengsi ' +
                'di Fakultas Teknik Universitas Negeri Surabaya. Diresmikan pada tahun 2014 dan menjadi jurusan kelima ' +
                'FT Unesa merupakan suatu pencapaian yang ditempuh dengan perjuangan yang amat sangat panjang. ' +
                'Di tahun 2000 antusiasme pemuda bangsa untuk mengikuti perkembangan teknologi sangatlah tinggi, ' +
                'serta dengan adanya industri yang menunggu lulusan diploma yang kompeten di bidang teknologi informasi ' +
                'menjadikan Unesa tergertak untuk membuat program studi berbasis teknologi informasi dengan harapan ' +
                'kedepannya akan terbentuk generasi hebat di bidang teknologi. Diawali dengan pembukaan ' +
                'program studi D3 Manajemen Informatika tahun 2009 sebagai pioner dan S1 Pendidikan Teknologi Informasi ' +
                'tahun 2012 yang saat itu masih menjadi prodi di Jurusan Teknik Elektro. Karena sudah tidak relevan lagi ' +
                'dengan bidang keilmuan dengan jurusan teknik elektro akhirya Universitas Negeri Surabaya membuka ' +
                'jurusan baru yaitu jurusan teknik informatika. Kemudian di tahun 2015 menjadi tahun pertama bagi ' +
                'prodi S1 Teknik Informatika dan S1 Sistem Informasi. Hingga akhirnya kini JTIf memiliki 4 prodi yaitu ' +
                'D3 Manajemen Informatika, S1 Pendidikan Teknologi Informasi, S1 Teknik Informatika, S1 Sistem Informasi.</p>' +
                '<div class="iw-subTitle">Contacts</div>' +
                '<p>Kampus Universitas Negeri Surabaya, Jl. Ketintang, Ketintang, Gayungan, Kota SBY, Jawa Timur 60231<br>' +
                '<br>Phone: <a href="tel:+62318299563">(031) 8299563</a><br>' +
                'E-mail: <a href="mailto:info@unesa.ac.id">info@unesa.ac.id</a><br>' +
                'Website: <a href="http://if.unesa.ac.id/" target="_blank">http://if.unesa.ac.id/</a></p>' +
                '</div><div class="iw-bottom-gradient"></div></div>';

            var infowindow = new google.maps.InfoWindow({
                content: contentString,
                maxWidth: 500
            });

            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                icon: '{{asset('images/pin-home.png')}}',
                anchorPoint: new google.maps.Point(0, -40)
            });
            marker.addListener('click', function () {
                infowindow.open(map, marker);
            });
            google.maps.event.addListener(map, 'click', function () {
                infowindow.close();
            });
            google.maps.event.addListener(infowindow, 'domready', function () {
                var iwOuter = $('.gm-style-iw');
                var iwBackground = iwOuter.prev();

                iwBackground.children(':nth-child(2)').css({'display': 'none'});
                iwBackground.children(':nth-child(4)').css({'display': 'none'});

                iwOuter.css({left: '25px', top: '15px'});
                iwOuter.parent().parent().css({left: '0'});

                iwBackground.children(':nth-child(1)').attr('style', function (i, s) {
                    return s + 'left: -39px !important;'
                });

                iwBackground.children(':nth-child(3)').attr('style', function (i, s) {
                    return s + 'left: -39px !important;'
                });

                iwBackground.children(':nth-child(3)').find('div').children().css({
                    'box-shadow': 'rgba(72, 181, 233, 0.6) 0 1px 6px',
                    'z-index': '1'
                });

                var iwCloseBtn = iwOuter.next();
                iwCloseBtn.css({
                    background: '#fff',
                    opacity: '1',
                    width: '30px',
                    height: '30px',
                    right: '15px',
                    top: '6px',
                    border: '6px solid #48b5e9',
                    'border-radius': '50%',
                    'box-shadow': '0 0 5px #3990B9'
                });

                if ($('.iw-content').height() < 140) {
                    $('.iw-bottom-gradient').css({display: 'none'});
                }

                iwCloseBtn.mouseout(function () {
                    $(this).css({opacity: '1'});
                });
            });
        }

        google.maps.event.addDomListener(window, 'load', init);
    </script>
@endif
<div class="progress">
    <div class="bar"></div>
</div>

<!-- jQuery -->
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{asset('js/jquery.maskMoney.js')}}"></script>
<script src="{{asset('js/simple.gpa.format.js')}}"></script>
<script src="{{asset('js/filesize.min.js')}}"></script>
<script src="{{asset('js/hideShowPassword.min.js')}}"></script>
<!-- jQuery Easing -->
<script src="{{asset('js/jquery.easing.1.3.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/moment.js')}}"></script>
<script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-select.js') }}"></script>
<script src="{{ asset('js/bootstrap-toggle.js') }}"></script>
<script src="{{asset('js/daterangepicker.js')}}"></script>
<!-- Waypoints -->
<script src="{{asset('js/jquery.waypoints.min.js')}}"></script>
<!-- Stellar Parallax -->
<script src="{{asset('js/jquery.stellar.min.js')}}"></script>
<!-- Smooth scroll -->
<script src="{{asset('js/smooth-scrollbar.js')}}"></script>
<!-- Owl Carousel -->
<script src="{{asset('js/owl.carousel.min.js')}}"></script>
<!-- Counters -->
<script src="{{asset('js/jquery.countTo.js')}}"></script>
<!-- TinyMCE -->
<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
<!-- Main JS (Do not remove) -->
<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset('js/checkMobileDevice.js')}}"></script>
<!-- Nicescroll -->
<script src="{{asset('nicescroll/jquery.nicescroll.js')}}"></script>
<!-- Ajax Lumen -->
@stack('lumen.ajax')

@include('layouts.partials._scripts')
@include('layouts.partials._alert')
@include('layouts.partials._confirm')
@include('layouts.partials.auth.notif_alert')
<script>
    $("#txt_keyword").autocomplete({
        source: function (request, response) {
            $.getJSON('{{route('get.keyword.vacancy', ['keyword' => ''])}}/' + $("#txt_keyword").val(), {
                name: request.term,
            }, function (data) {
                response(data);
            });
        },
        focus: function (event, ui) {
            event.preventDefault();
        },
        select: function (event, ui) {
            event.preventDefault();
            @if(\Illuminate\Support\Facades\Request::is('search*'))
            $("#txt_keyword").val(ui.item.keyword).trigger('keyup');
            @else
            $("#txt_keyword").val(ui.item.keyword);
            $("form[role='search']")[0].submit();
            @endif
        }
    });

    $(document).on('mouseover', '.use-nicescroll', function () {
        $(this).getNiceScroll().resize();
    });
</script>
@stack('scripts')
</body>
</html>
