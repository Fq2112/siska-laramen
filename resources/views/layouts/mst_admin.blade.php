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
    <!-- bootstrap-datepicker -->
    <link href="{{ asset('css/bootstrap-datepicker.css') }}" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->
    <link href="{{asset('_admins/css/prettify.min.css')}}" rel="stylesheet">
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
                                            <li><a>Accounts <span class="fa fa-chevron-down"></span></a>
                                                <ul class="nav child_menu">
                                                    <li><a href="{{route('table.admins')}}">Admins</a></li>
                                                    <li><a href="{{route('table.users')}}">Users</a></li>
                                                    <li><a href="{{route('table.agencies')}}">Agencies</a></li>
                                                    <li><a href="{{route('table.seekers')}}">Seekers</a></li>
                                                </ul>
                                            </li>
                                            <li><a>Requirements <span class="fa fa-chevron-down"></span></a>
                                                <ul class="nav child_menu">
                                                    <li><a href="{{route('table.degrees')}}">Education Degrees</a></li>
                                                    <li><a href="{{route('table.majors')}}">Education Majors</a></li>
                                                    <li><a href="{{route('table.industries')}}">Industries</a></li>
                                                    <li><a href="{{route('table.JobFunctions')}}">Job Functions</a></li>
                                                    <li><a href="{{route('table.JobLevels')}}">Job Levels</a></li>
                                                    <li><a href="{{route('table.JobTypes')}}">Job Types</a></li>
                                                    <li><a href="{{route('table.salaries')}}">Salaries</a></li>
                                                </ul>
                                            </li>
                                            <li><a>Web Contents <span class="fa fa-chevron-down"></span></a>
                                                <ul class="nav child_menu">
                                                    <li><a href="{{route('table.blog')}}">Blog</a></li>
                                                    <li><a href="{{route('table.blogTypes')}}">Blog Types</a></li>
                                                    <li><a href="{{route('table.carousels')}}">Carousels</a></li>
                                                    <li><a href="{{route('table.PaymentCategories')}}">Payment
                                                            Category</a></li>
                                                    <li><a href="{{route('table.PaymentMethods')}}">Payment Method</a>
                                                    </li>
                                                    <li><a href="{{route('table.plans')}}">Plans</a></li>
                                                    <li><a href="{{route('table.nations')}}">Nations</a></li>
                                                    <li><a href="{{route('table.provinces')}}">Provinces</a></li>
                                                    <li><a href="{{route('table.cities')}}">Cities</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a>Data Transaction <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a>Agencies <span class="fa fa-chevron-down"></span></a>
                                                <ul class="nav child_menu">
                                                    <li><a href="{{route('table.vacancies')}}">Job Vacancies</a></li>
                                                    <li><a href="{{route('table.jobPostings')}}">Job Postings</a></li>
                                                </ul>
                                            </li>
                                            <li><a>Seekers <span class="fa fa-chevron-down"></span></a>
                                                <ul class="nav child_menu">
                                                    <li><a href="{{route('table.applications')}}">Applications</a></li>
                                                    <li><a href="{{route('table.invitations')}}">Invitations</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li><a><i class="fa fa-smile"></i> Quiz <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="{{route('quiz.topics')}}">Topics</a></li>
                                    <li><a href="{{route('quiz.questions')}}">Questions</a></li>
                                    <li><a href="{{route('quiz.options')}}">Options</a></li>
                                </ul>
                            </li>
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
                    <a data-toggle="tooltip" title="Logout"
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
                                <li>
                                    <a href="{{route('admin.inbox')}}">
                                        <i class="fa fa-envelope pull-right"></i> Inbox</a>
                                </li>
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
                                    <a onclick="event.preventDefault();document.getElementById('logout-form2').submit();">
                                        <i class="fa fa-sign-out-alt pull-right"></i> Log Out</a>
                                    <form id="logout-form2" action="{{ route('logout') }}" method="POST"
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
                                            <a style="cursor: text">
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
                                <span class="fa fa-lock form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12 has-feedback">
                                <label for="myNew_password">New Password <span class="required">*</span></label>
                                <input id="myNew_password" type="password" class="form-control" minlength="6"
                                       name="myNew_password" placeholder="New Password" required>
                                <span class="fa fa-lock form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12 has-feedback">
                                <label for="myConfirm">Password Confirmation <span class="required">*</span></label>
                                <input id="myConfirm" type="password" class="form-control" minlength="6"
                                       name="myPassword_confirmation" placeholder="Retype password" required>
                                <span class="fa fa-sign-in-alt form-control-feedback right" aria-hidden="true"></span>
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
<!-- Bootstrap -->
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('_admins/js/fastclick.js')}}"></script>
<!-- NProgress -->
<script src="{{asset('_admins/js/nprogress.js')}}"></script>
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
<script src="{{asset('_admins/js/daterangepicker.js')}}"></script>
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

<!-- Custom Theme Scripts -->
<script src="{{asset('_admins/js/custom.min.js')}}"></script>
<script>
    var editor_config;
    $(function () {
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
