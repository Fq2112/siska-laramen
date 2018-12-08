@extends('layouts.mst_user')
@section('title', ''.$user->name.'\'s Profile | SISKA &mdash; Sistem Informasi Karier')
@push('styles')
    <link href="{{ asset('css/mySearchFilter.css') }}" rel="stylesheet">
    <link href="{{ asset('css/myProfile.css') }}" rel="stylesheet">
    <link href="{{ asset('css/myMaps.css') }}" rel="stylesheet">
    <style>
        .site-name {
            font-size: 36px;
            margin-top: -120px;
        }

        .site-jobTitle {
            color: #fff;
            font-size: 26px;
            float: left;
            margin-top: -80px;
            margin-left: 16px;
            text-shadow: 0 4px 3px rgba(0, 0, 0, 0.4), 0 8px 13px rgba(0, 0, 0, 0.1), 0 18px 23px rgba(0, 0, 0, 0.1);
        }

        .site-description {
            font-size: 20px;
            margin-top: -40px;
        }
    </style>
@endpush
@section('content')
    <section id="fh5co-services" data-section="services" style="padding-top: 2.9em">
        <div class="fh5co-services">
            <div class="container to-animate" style="width: 100%;padding: 0;">
                <header id="header">
                    <div class="slider" style="cursor: pointer">
                        <div id="carousel-example" class="carousel slide carousel-fullscreen" data-ride="carousel">
                            <div class="carousel-inner">
                                @if($seeker->background == "")
                                    <div class="item show_background"
                                         style="background-image: url({{asset('images/carousel/c0.png')}});">
                                        <div class="carousel-overlay"></div>
                                    </div>
                                @else
                                    <div class="item show_background" style="background-image: url({{asset('storage/users/seekers/background/'
                                         .$seeker->background)}});">
                                        <div class="carousel-overlay"></div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <nav class="profilebar navbar-default">
                        <div class="profilebar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                    data-target="#mainNav">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="profilebar-brand" style="cursor: pointer">
                                @if($user->ava == ""||$user->ava == "seeker.png")
                                    <img class="img-responsive" src="{{asset('images/seeker.png')}}"
                                         style="width: 100%;height: 100%">
                                @else
                                    <img class="img-responsive" src="{{asset('storage/users/'.$user->ava)}}"
                                         style="width: 100%;height: 100%">
                                @endif
                            </a>
                            <span class="site-name">{{$user->name}}</span>
                            <span class="site-jobTitle">
                                {{count($job_title->get()) != 0 ? '['.$job_title->first()->job_title.']' :
                                '[Looking for a Job]'}}
                            </span>
                            <span class="site-description">{{$seeker->address}}</span>
                        </div>
                        <div class="collapse navbar-collapse" id="mainNav">
                            <ul class="nav main-menu navbar-nav to-animate">
                                <li data-placement="left" data-toggle="tooltip" title="Expected Salary">
                                    <a id="salary">
                                        @if($seeker->lowest_salary != "")
                                            <script>
                                                var low = ("{{$seeker->lowest_salary}}") / 1000000,
                                                    high = ("{{$seeker->highest_salary}}") / 1000000;
                                                document.getElementById("salary").innerHTML =
                                                    "<i class='fa fa-hand-holding-usd'></i> &nbsp;IDR " + low +
                                                    " to " + high + " millions";
                                            </script>
                                        @else
                                            <i class='fa fa-hand-holding-usd'></i> &nbsp;Anything
                                        @endif
                                    </a>
                                </li>
                                <li data-placement="bottom" data-toggle="tooltip" title="Total Work Experience">
                                    <a><i class="fa fa-briefcase"></i>
                                        &nbsp;{{$seeker->total_exp != "" ? $seeker->total_exp.' years' : '0 year'}}
                                    </a>
                                </li>
                                <li data-placement="bottom" data-toggle="tooltip" title="Latest Degree">
                                    <a><i class="fa fa-graduation-cap"></i>
                                        &nbsp;{{count($last_edu->get()) != 0 ? \App\Tingkatpend::find($last_edu->first()
                                        ->tingkatpend_id)->name : 'Latest Degree (-)'}}
                                    </a>
                                </li>
                                <li data-placement="bottom" data-toggle="tooltip" title="Latest Major">
                                    <a><i class="fa fa-user-graduate"></i>
                                        &nbsp;{{count($last_edu->get()) != 0 ? \App\Jurusanpend::find($last_edu->first()
                                        ->jurusanpend_id)->name : 'Latest Major (-)'}}
                                    </a>
                                </li>
                                <li data-placement="right" data-toggle="tooltip" title="Latest GPA">
                                    <a><i class="fa fa-grin-stars"></i>
                                        &nbsp;{{count($last_edu->get()) != 0 && $last_edu->first()->nilai != "" ?
                                        $last_edu->first()->nilai : 'Latest GPA (-)'}}
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav to-animate-2 navbar-nav navbar-right">
                                @if(Auth::check() && Auth::user()->isSeeker())
                                    <li class="ld ld-breath" id="btn_edit">
                                        <a href="{{route('seeker.edit.profile')}}" class="btn btn-info btn-block">
                                            <i class="fa fa-user-edit"></i>&ensp;<strong>Edit</strong>
                                        </a>
                                    </li>
                                @elseif(Auth::check() && Auth::user()->isAgency())
                                    <li class="ld ld-heartbeat" id="invite" data-placement="top"
                                        data-toggle="tooltip">
                                        <button type="button" class="btn btn-info btn-block">
                                            <i class="fa fa-envelope"></i>&ensp;<strong>Invite</strong>
                                        </button>
                                    </li>
                                @elseif(Auth::guard('admin')->check())
                                    <li id="invite" data-placement="top" data-toggle="tooltip">
                                        <button type="button" class="btn btn-info btn-block" disabled>
                                            <i class="fa fa-envelope"></i>&ensp;<strong>Invite</strong>
                                        </button>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </nav>
                </header>

                <div class="row to-animate detail">
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="img-card">
                                        @if($seeker->video_summary != "")
                                            <video class="aj_video" style="width: 100%;height: auto"
                                                   src="{{asset('storage/users/seekers/video/'.$seeker->video_summary)}}"
                                                   controls></video>
                                        @else
                                            <video class="aj_video" style="width: 100%;height: auto"
                                                   src="{{asset('images/vid-placeholder.mp4')}}"></video>
                                        @endif
                                    </div>
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small>Video Summary</small>
                                            <hr class="hr-divider">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small>Personal Data</small>
                                            <hr class="hr-divider">
                                            <table style="font-size: 14px; margin-top: 0">
                                                <tr>
                                                    <td><i class="fa fa-id-card"></i></td>
                                                    <td>&nbsp;Name</td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td>{{$user->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-birthday-cake"></i></td>
                                                    <td>&nbsp;Birthday</td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td>
                                                        {{$seeker->birthday == "" ? '-' : \Carbon\Carbon::parse
                                                        ($seeker->birthday)->format('j F Y')}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-transgender"></i></td>
                                                    <td>&nbsp;Gender</td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td>{{$seeker->gender != "" ? $seeker->gender : '-'}}</td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-hand-holding-heart"></i></td>
                                                    <td>&nbsp;Relationship</td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td>{{$seeker->relationship != "" ? $seeker->relationship : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-flag"></i></td>
                                                    <td>&nbsp;Nationality</td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td>{{$seeker->nationality != "" ? $seeker->nationality : '-'}}</td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-globe"></i></td>
                                                    <td>&nbsp;Personal Website</td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td style="text-transform: none">
                                                        @if($seeker->website != "")
                                                            <a href="{{$seeker->website}}" target="_blank"
                                                               style="color: #fa5555">
                                                                {{$seeker->website}}</a>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-hand-holding-usd"></i></td>
                                                    <td>&nbsp;Expected Salary</td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td style="text-transform: none" id="expected_salary2">
                                                        @if($seeker->lowest_salary != "")
                                                            <script>
                                                                var low = ("{{$seeker->lowest_salary}}") / 1000000,
                                                                    high = ("{{$seeker->highest_salary}}") / 1000000;
                                                                document.getElementById("expected_salary2").innerText =
                                                                    "IDR " + low + " to " + high + " millions";
                                                            </script>
                                                        @else
                                                            Anything
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small>Contact</small>
                                            <hr class="hr-divider">
                                            <table style="font-size: 14px; margin-top: 0">
                                                <tr>
                                                    <td><i class="fa fa-envelope"></i></td>
                                                    <td>&nbsp;E-mail</td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td style="text-transform: none">
                                                        <a href="mailto:{{$user->email}}" style="color: #fa5555">
                                                            {{$user->email}}</a></td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-phone"></i></td>
                                                    <td>&nbsp;Phone</td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td>
                                                        @if($seeker->phone != "")
                                                            <a href="tel:{{$seeker->phone}}" style="color: #fa5555">
                                                                {{$seeker->phone}}</a>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-home"></i></td>
                                                    <td>&nbsp;Address</td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td>{{$seeker->address != "" ? $seeker->address : '-'}}</td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-address-card"></i></td>
                                                    <td>&nbsp;ZIP Code</td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td>{{$seeker->zip_code != "" ? $seeker->zip_code : '-'}}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small>Language Skill</small>
                                            <hr class="hr-divider">
                                            @if(count($languages) == 0)
                                                <blockquote><p>(empty)</p></blockquote>
                                            @else
                                                @foreach($languages as $row)
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="media">
                                                                <div class="media-left media-middle">
                                                                    <img width="100"
                                                                         class="media-object"
                                                                         src="{{asset('images/lang.png')}}">
                                                                </div>
                                                                <div class="media-body">
                                                                    <p class="media-heading">
                                                                        <i class="fa fa-language">&nbsp;</i>
                                                                        <small style="text-transform: uppercase">{{$row->name}}</small>
                                                                    </p>
                                                                    <blockquote
                                                                            style="font-size: 12px;text-transform: none">
                                                                        <table style="font-size: 14px; margin-top: 0">
                                                                            <tr>
                                                                                <td><i class="fa fa-comments"></i>
                                                                                </td>
                                                                                <td>&nbsp;Speaking Level</td>
                                                                                <td>&nbsp;:&nbsp;</td>
                                                                                <td style="text-transform: uppercase">
                                                                                    {{$row->spoken_lvl == "" ? '(-)' :
                                                                                    $row->spoken_lvl}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><i class="fa fa-pencil-alt"></i>
                                                                                </td>
                                                                                <td>&nbsp;Writing Level</td>
                                                                                <td>&nbsp;:&nbsp;</td>
                                                                                <td style="text-transform: uppercase">
                                                                                    {{$row->written_lvl == "" ?
                                                                                    '(-)' : $row->written_lvl}}</td>
                                                                            </tr>
                                                                        </table>
                                                                    </blockquote>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="hr-divider">
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small>Skill</small>
                                            <hr class="hr-divider">
                                            @if(count($skills) == 0)
                                                <blockquote><p>(empty)</p></blockquote>
                                            @else
                                                @foreach($skills as $row)
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="media">
                                                                <div class="media-left media-middle">
                                                                    <img width="100"
                                                                         class="media-object"
                                                                         src="{{asset('images/skill.png')}}">
                                                                </div>
                                                                <div class="media-body">
                                                                    <p class="media-heading">
                                                                        <i class="fa fa-user-secret">&nbsp;</i>
                                                                        <small style="text-transform: uppercase">{{$row->name}}</small>
                                                                    </p>
                                                                    <blockquote
                                                                            style="font-size: 12px;text-transform: none">
                                                                        <table style="font-size: 14px; margin-top: 0">
                                                                            <tr>
                                                                                <td><i class="fa fa-chart-line"></i>
                                                                                </td>
                                                                                <td>&nbsp;Skill Level</td>
                                                                                <td>&nbsp;:&nbsp;</td>
                                                                                <td style="text-transform: uppercase">
                                                                                    {{$row->level == "" ? '(-)' :
                                                                                    $row->level}}</td>
                                                                            </tr>
                                                                        </table>
                                                                    </blockquote>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="hr-divider">
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small>Test Result</small>
                                            <hr class="hr-divider">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="media">
                                                        <div class="media-left media-middle">
                                                            <img width="100" class="media-object"
                                                                 alt="English First"
                                                                 src="{{asset('images/ef.png')}}">
                                                        </div>
                                                        <div class="media-body">
                                                            <small class="media-heading">
                                                                EF Standard English Test - Express
                                                            </small>
                                                            <blockquote style="font-size: 12px"><p>(empty)</p>
                                                            </blockquote>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="hr-divider">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="media">
                                                        <div class="media-left media-middle">
                                                            <img width="100" class="media-object"
                                                                 alt="Communication Test"
                                                                 src="{{asset('images/comm_test.png')}}">
                                                        </div>
                                                        <div class="media-body">
                                                            <small class="media-heading">Communication Style Test
                                                            </small>
                                                            <blockquote style="font-size: 12px"><p>(empty)</p>
                                                            </blockquote>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="hr-divider">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="media">
                                                        <div class="media-left media-middle">
                                                            <img width="100" class="media-object"
                                                                 alt="Interest Test"
                                                                 src="{{asset('images/int_test.png')}}">
                                                        </div>
                                                        <div class="media-body">
                                                            <small class="media-heading">Interest Test</small>
                                                            <blockquote style="font-size: 12px"><p>(empty)</p>
                                                            </blockquote>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small>Summary
                                                <span class="pull-right" style="color: #FA5555">
                                                    Last Update: {{$seeker->updated_at->diffForHumans()}}</span>
                                            </small>
                                            <hr class="hr-divider">
                                            <blockquote>
                                                {!!$seeker->summary != "" ? $seeker->summary : '<p>(empty)</p>'!!}
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small>Attachments</small>
                                            <hr class="hr-divider">
                                            @if(count($attachments) != 0)
                                                @foreach($attachments as $row)
                                                    <div class="media">
                                                        <div class="media-left media-middle">
                                                            @if(strtolower(pathinfo($row->files, PATHINFO_EXTENSION)) == "jpg"||strtolower(pathinfo($row->files, PATHINFO_EXTENSION)) == "jpeg"||strtolower(pathinfo($row->files, PATHINFO_EXTENSION)) == "png"||strtolower(pathinfo($row->files, PATHINFO_EXTENSION)) == "gif")
                                                                <img width="100"
                                                                     class="media-object"
                                                                     src="{{asset('storage/users/seekers/attachments/'
                                                                     .$row->files)}}">
                                                            @else
                                                                <img width="100"
                                                                     class="media-object"
                                                                     src="{{asset('images/files.png')}}">
                                                            @endif
                                                        </div>
                                                        <div class="media-body">
                                                            @if(Auth::check() && Auth::user()->isAgency())
                                                                <form class="pull-right to-animate-2"
                                                                      id="form-download-attachments{{$row->id}}"
                                                                      action="{{route('download.seeker.attachments',
                                                                          ['files' => $row->files])}}"
                                                                      data-toggle="tooltip" data-placement="left"
                                                                      title="Download {{$row->files}}">
                                                                    {{csrf_field()}}
                                                                    <div class="anim-icon anim-icon-md download ld ld-breath"
                                                                         id="{{$row->id}}"
                                                                         onclick="downloadAttachments(id)"
                                                                         style="font-size: 25px">
                                                                        <input type="hidden" name="attachments_id"
                                                                               value="{{$row->id}}">
                                                                        <input type="checkbox">
                                                                        <label for="download"></label>
                                                                    </div>
                                                                </form>
                                                            @endif
                                                            <blockquote style="font-size: 12px;text-transform: none">
                                                                {{$row->files}}
                                                            </blockquote>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <blockquote><p>(empty)</p></blockquote>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small>Work Experience</small>
                                            <hr class="hr-divider">
                                            @if(count($experiences) == 0)
                                                <blockquote><p>(empty)</p></blockquote>
                                            @else
                                                @foreach($experiences as $row)
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="media">
                                                                <div class="media-left media-middle">
                                                                    <img width="100"
                                                                         class="media-object"
                                                                         src="{{asset('images/exp.png')}}">
                                                                </div>
                                                                <div class="media-body">
                                                                    <p class="media-heading">
                                                                        <i class="fa fa-briefcase">&nbsp;</i>
                                                                        <small style="text-transform: uppercase">
                                                                            {{$row->job_title}}
                                                                        </small>
                                                                    </p>
                                                                    <blockquote
                                                                            style="font-size: 14px;text-transform: none">
                                                                        <table style="font-size: 14px; margin-top: 0">
                                                                            <tr>
                                                                                <td><i class="fa fa-building"></i></td>
                                                                                <td>&nbsp;Agency Name</td>
                                                                                <td>&nbsp;:&nbsp;</td>
                                                                                <td>{{$row->company}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><i class="fa fa-level-up-alt"></i>
                                                                                </td>
                                                                                <td>&nbsp;Job Level</td>
                                                                                <td>&nbsp;:&nbsp;</td>
                                                                                <td>{{\App\JobLevel::find
                                                                                    ($row->joblevel_id)->name}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><i class="fa fa-warehouse"></i></td>
                                                                                <td>&nbsp;Job Function</td>
                                                                                <td>&nbsp;:&nbsp;</td>
                                                                                <td>{{\App\FungsiKerja::find
                                                                                    ($row->fungsikerja_id)->nama}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><i class="fa fa-industry"></i></td>
                                                                                <td>&nbsp;Industry</td>
                                                                                <td>&nbsp;:&nbsp;</td>
                                                                                <td>{{\App\Industri::find
                                                                                    ($row->industri_id)->nama}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><i class="fa fa-map-marked"></i>
                                                                                </td>
                                                                                <td>&nbsp;Location</td>
                                                                                <td>&nbsp;:&nbsp;</td>
                                                                                <td>{{substr(\App\Cities::find
                                                                                    ($row->city_id)->name,0,2) == "Ko" ?
                                                                                    substr(\App\Cities::find($row->city_id)
                                                                                    ->name,5) : substr(\App\Cities::find
                                                                                    ($row->city_id)->name,10)}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                    <i class="fa fa-money-bill-wave"></i>
                                                                                </td>
                                                                                <td>&nbsp;Salary</td>
                                                                                <td>&nbsp;:&nbsp;</td>
                                                                                <td>{{$row->salary_id != "" ?
                                                                                    \App\Salaries::find($row->salary_id)
                                                                                    ->name : 'Rather not say'}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                    <i class="fa fa-calendar-alt"></i>
                                                                                </td>
                                                                                <td>&nbsp;Since</td>
                                                                                <td>&nbsp;:&nbsp;</td>
                                                                                <td>{{\Carbon\Carbon::parse
                                                                                    ($row->start_date)->format('j F Y')}}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><i class="fa fa-calendar-check"></i>
                                                                                </td>
                                                                                <td>&nbsp;Until</td>
                                                                                <td>&nbsp;:&nbsp;</td>
                                                                                <td>{{$row->end_date != "" ?
                                                                                    \Carbon\Carbon::parse($row->end_date)
                                                                                    ->format('j F Y') : 'Present'}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><i class="fa fa-user-clock"></i>
                                                                                </td>
                                                                                <td>&nbsp;Job Type</td>
                                                                                <td>&nbsp;:&nbsp;</td>
                                                                                <td>{{$row->jobtype_id != "" ?
                                                                                    \App\JobType::find($row->jobtype_id)
                                                                                    ->name : '(empty)'}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><i class="fa fa-user-tie"></i>
                                                                                </td>
                                                                                <td>&nbsp;Report to</td>
                                                                                <td>&nbsp;:&nbsp;</td>
                                                                                <td>{{$row->report_to != "" ?
                                                                                    $row->report_to : '(empty)'}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><i class="fa fa-comments"></i>
                                                                                </td>
                                                                                <td>&nbsp;Job Description</td>
                                                                                <td>&nbsp;:&nbsp;</td>
                                                                                <td>&nbsp;</td>
                                                                            </tr>
                                                                        </table>
                                                                        {!! $row->job_desc != "" ?
                                                                        $row->job_desc : '(empty)'!!}
                                                                    </blockquote>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="hr-divider">
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small>Education</small>
                                            <hr class="hr-divider">
                                            @if(count($educations) == 0)
                                                <blockquote><p>(empty)</p></blockquote>
                                            @else
                                                @foreach($educations as $row)
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="media">
                                                                <div class="media-left media-middle">
                                                                    <img width="100"
                                                                         class="media-object"
                                                                         src="{{asset('images/edu.png')}}">
                                                                </div>
                                                                <div class="media-body">
                                                                    <p class="media-heading">
                                                                        <i class="fa fa-school">&nbsp;</i>
                                                                        <small style="text-transform: uppercase">
                                                                            {{$row->school_name}}
                                                                        </small>
                                                                    </p>
                                                                    <blockquote
                                                                            style="font-size: 14px;text-transform: none">
                                                                        <table style="font-size: 14px; margin-top: 0">
                                                                            <tr>
                                                                                <td><i class="fa fa-graduation-cap"></i>
                                                                                </td>
                                                                                <td>&nbsp;Education Degree</td>
                                                                                <td>&nbsp;:&nbsp;</td>
                                                                                <td>{{\App\Tingkatpend::find
                                                                                ($row->tingkatpend_id)->name}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><i class="fa fa-user-graduate"></i>
                                                                                </td>
                                                                                <td>&nbsp;Education Major</td>
                                                                                <td>&nbsp;:&nbsp;</td>
                                                                                <td>{{\App\Jurusanpend::find
                                                                                ($row->jurusanpend_id)->name}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                    <i class="fa fa-hourglass-start"></i>
                                                                                </td>
                                                                                <td>&nbsp;Start Period</td>
                                                                                <td>&nbsp;:&nbsp;</td>
                                                                                <td>{{$row->start_period}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><i class="fa fa-hourglass-end"></i>
                                                                                </td>
                                                                                <td>&nbsp;End Period</td>
                                                                                <td>&nbsp;:&nbsp;</td>
                                                                                <td>{{$row->end_period == "" ?
                                                                                'Present' : $row->end_period}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><i class="fa fa-grin-stars"></i>
                                                                                </td>
                                                                                <td>&nbsp;GPA</td>
                                                                                <td>&nbsp;:&nbsp;</td>
                                                                                <td>{{$row->nilai != "" ?
                                                                                    $row->nilai : '(-)'}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><i class="fa fa-trophy"></i>
                                                                                </td>
                                                                                <td>&nbsp;Honors/Awards</td>
                                                                                <td>&nbsp;:&nbsp;</td>
                                                                                <td>&nbsp;</td>
                                                                            </tr>
                                                                        </table>
                                                                        {!! $row->awards != "" ?
                                                                        $row->awards : '(empty)'!!}
                                                                    </blockquote>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="hr-divider">
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small>Training / Certification</small>
                                            <hr class="hr-divider">
                                            @if(count($trainings) == 0)
                                                <blockquote><p>(empty)</p></blockquote>
                                            @else
                                                @foreach($trainings as $row)
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="media">
                                                                <div class="media-left media-middle">
                                                                    <img width="100"
                                                                         class="media-object"
                                                                         src="{{asset('images/cert.png')}}">
                                                                </div>
                                                                <div class="media-body">
                                                                    <p class="media-heading">
                                                                        <i class="fa fa-certificate">&nbsp;</i>
                                                                        <small style="text-transform: uppercase">
                                                                            {{$row->name}}
                                                                        </small>
                                                                    </p>
                                                                    <blockquote
                                                                            style="font-size: 14px;text-transform: none">
                                                                        <table style="font-size: 14px; margin-top: 0">
                                                                            <tr>
                                                                                <td><i class="fa fa-university"></i>
                                                                                </td>
                                                                                <td>&nbsp;Issued by</td>
                                                                                <td>&nbsp;:&nbsp;</td>
                                                                                <td>{{$row->issuedby}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><i class="fa fa-calendar-alt"></i>
                                                                                </td>
                                                                                <td>&nbsp;Issued Date</td>
                                                                                <td>&nbsp;:&nbsp;</td>
                                                                                <td>{{\Carbon\Carbon::parse
                                                                                ($row->isseuddate)->format('j F Y')}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><i class="fa fa-comments"></i>
                                                                                </td>
                                                                                <td>&nbsp;Job Description</td>
                                                                                <td>&nbsp;:&nbsp;</td>
                                                                                <td>&nbsp;</td>
                                                                            </tr>
                                                                        </table>
                                                                        {!! $row->descript != "" ?
                                                                        $row->descript : '(empty)'!!}
                                                                    </blockquote>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="hr-divider">
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small>Organization Experience</small>
                                            <hr class="hr-divider">
                                            @if(count($organizations) == 0)
                                                <blockquote><p>(empty)</p></blockquote>
                                            @else
                                                @foreach($organizations as $row)
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="media">
                                                                <div class="media-left media-middle">
                                                                    <img width="100"
                                                                         class="media-object"
                                                                         src="{{asset('images/org.png')}}">
                                                                </div>
                                                                <div class="media-body">
                                                                    <p class="media-heading">
                                                                        <i class="fa fa-briefcase">&nbsp;</i>
                                                                        <small style="text-transform: uppercase">
                                                                            {{$row->title}}
                                                                        </small>
                                                                    </p>
                                                                    <blockquote
                                                                            style="font-size: 14px;text-transform: none">
                                                                        <table style="font-size: 14px; margin-top: 0">
                                                                            <tr>
                                                                                <td>
                                                                                    <i class="fa fa-hourglass-start"></i>
                                                                                </td>
                                                                                <td>&nbsp;Start Period</td>
                                                                                <td>&nbsp;:&nbsp;</td>
                                                                                <td>{{$row->start_period}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><i class="fa fa-hourglass-end"></i>
                                                                                </td>
                                                                                <td>&nbsp;End Period</td>
                                                                                <td>&nbsp;:&nbsp;</td>
                                                                                <td>{{$row->end_period == "" ?
                                                                                'Present' : $row->end_period}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><i class="fa fa-comments"></i>
                                                                                </td>
                                                                                <td>&nbsp;Description</td>
                                                                                <td>&nbsp;:&nbsp;</td>
                                                                                <td>&nbsp;</td>
                                                                            </tr>
                                                                        </table>
                                                                        {!! $row->descript != "" ?
                                                                        $row->descript : '(empty)'!!}
                                                                    </blockquote>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="hr-divider">
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade login" id="avaModal">
        <div class="modal-dialog login animated">
            @if($user->ava == ""||$user->ava == "seeker.png")
                <img style="width: 100%" class="img-responsive" src="{{asset('images/seeker.png')}}">
            @else
                <img style="width: 100%" class="img-responsive" src="{{asset('storage/users/'.$user->ava)}}">
            @endif
        </div>
    </div>
    <div class="modal fade login" id="backgroundModal">
        <div class="modal-dialog login animated">
            @if($seeker->background == "")
                <img class="img-responsive" src="{{asset('images/carousel/c0.png')}}">
            @else
                <img class="img-responsive" src="{{asset('storage/users/seekers/background/'.$seeker->background)}}">
            @endif
        </div>
    </div>
    @if(Auth::check() && Auth::user()->isAgency())
        <style>
            .card-read-more button {
                color: #00ADB5;
            }

            .card-read-more button:hover {
                color: #fff;
            }
        </style>
        <div class="modal fade login" id="inviteModal">
            <div class="modal-dialog login animated">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Hi {{Auth::user()->name}},</h4>
                    </div>
                    <form method="post" action="{{route('invite.seeker')}}" id="form-invite">
                        {{csrf_field()}}
                        <div class="modal-body">
                            <div class="box">
                                <div class="content">
                                    <p style="font-size: 17px" align="justify">
                                        You will invite this seeker with the following details:</p>
                                    <hr class="hr-divider">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="media">
                                                <div class="media-left media-middle">
                                                    @if($user->ava == ""||$user->ava == "seeker.png")
                                                        <img width="100" class="media-object"
                                                             src="{{asset('images/seeker.png')}}">
                                                    @else
                                                        <img width="100" class="media-object"
                                                             src="{{asset('storage/users/'.$user->ava)}}">
                                                    @endif
                                                </div>
                                                <div class="media-body">
                                                    <small class="media-heading" style="font-size: 17px;">
                                                        <a href="{{route('seeker.profile',['id'=>$seeker->id])}}"
                                                           style="color: #00ADB5">
                                                            {{$user->name}}</a>
                                                        <a href="mailto:{{$user->email}}" style="color: #fa5555">
                                                            <sub>&ndash; {{$user->email}}</sub></a>
                                                    </small>
                                                    <blockquote style="font-size: 16px;color: #7f7f7f">
                                                        <ul class="list-inline">
                                                            <li>
                                                                <a class="tag">
                                                                    <i class="fa fa-user-tie"></i>&ensp;
                                                                    {{count($job_title->get()) != 0 ?
                                                                    'Current Title: '.$job_title->first()->job_title
                                                                    : 'Current Status: Looking for a Job'}}
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="tag">
                                                                    <i class="fa fa-briefcase"></i>&ensp;
                                                                    Work Experience: {{$seeker->total_exp}} years
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="tag" id="expected_salary3">
                                                                    @if($seeker->lowest_salary != "")
                                                                        <script>
                                                                            var low = ("{{$seeker->lowest_salary}}") / 1000000,
                                                                                high = ("{{$seeker->highest_salary}}") / 1000000;
                                                                            document.getElementById("expected_salary3").innerHTML = "<i class='fa fa-hand-holding-usd'></i>&ensp;Expected Salary: IDR " + low + " to " + high + " millions";
                                                                        </script>
                                                                    @else
                                                                        Anything
                                                                    @endif
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="tag">
                                                                    <i class="fa fa-graduation-cap"></i>&ensp;
                                                                    {{count($last_edu->get()) != 0 ?
                                                                    'Latest Degree: '.\App\Tingkatpend::find
                                                                    ($last_edu->first()->tingkatpend_id)->name :
                                                                    'Latest Degree (-)'}}
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="tag">
                                                                    <i class="fa fa-user-graduate"></i>&ensp;
                                                                    {{count($last_edu->get()) != 0 ?
                                                                    'Latest Major: '.\App\Jurusanpend::find
                                                                    ($last_edu->first()->jurusanpend_id)->name :
                                                                    'Latest Major (-)'}}
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <table style="font-size: 12px">
                                                            <tr>
                                                                <td><i class="fa fa-calendar-check"></i></td>
                                                                <td>&nbsp;Member Since</td>
                                                                <td>
                                                                    : {{$seeker->created_at->format('j F Y')}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><i class="fa fa-clock"></i></td>
                                                                <td>&nbsp;Last Update</td>
                                                                <td>
                                                                    : {{$seeker->updated_at->diffForHumans()}}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <hr>
                                                        <div class="row form-group">
                                                            <div class="col-lg-12">
                                                                <p align="justify"
                                                                   style="font-size:17px;margin-bottom: .5em">
                                                                    Select one of the following vacancies that you
                                                                    have in order to offer it for this Job Seeker.
                                                                </p>
                                                                <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-briefcase"></i></span>
                                                                    <select class="form-control selectpicker"
                                                                            name="vacancy_id" data-container="body"
                                                                            id="vacancy_id" required>
                                                                        <option value="" selected disabled>
                                                                            -- Choose Vacancy --
                                                                        </option>
                                                                        @foreach(\App\Vacancies::where('agency_id',
                                                                        \App\Agencies::where
                                                                        ('user_id',Auth::user()->id)->first()->id)
                                                                        ->get() as $vacancy)
                                                                            <option value="{{$vacancy->id}}"
                                                                                    {{$vacancy->isPost == false ?
                                                                                    'disabled' : ''}}>
                                                                                {{$vacancy->judul}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <small style="font-size: 10px;color: #00ADB5;float: left">
                                                                    P.S.: You're only permitted to select your
                                                                    vacancy that has been posted.
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </blockquote>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="card-read-more" id="btn-invite">
                                <input type="hidden" name="seeker_id" value="{{$seeker->id}}">
                                <button class="btn btn-link btn-block" type="button">
                                    <i class="fa fa-envelope"></i>&ensp;Invite
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
@push("scripts")
    <script>
        var $btnInvite = $("#invite button");

        $btnInvite.on("click", function () {
            $("#inviteModal").modal('show');
            $("#btn-invite button").click(function () {
                if ($("#vacancy_id").val()) {
                    $("#inviteModal").modal('hide');
                    $("#invite").toggleClass('ld ld-heartbeat');
                    $btnInvite.css('background', '#393e46').attr('disabled', true)
                        .html('<i class="fa fa-envelope"></i>&ensp;Invited');
                    $('#form-invite')[0].submit();
                } else {
                    swal({
                        title: 'ATTENTION!',
                        text: 'Please select one of your vacancies in order to offer it for this Job Seeker.',
                        type: 'warning',
                        timer: '3500'
                    });
                }
            });
        });

        @if($invitation->count() && $invitation->first()->isInvite == true)
        $("#invite").removeClass('ld ld-heartbeat').attr('title', 'Please, check Invited Seeker ' +
            'in your Dashboard.');
        $btnInvite.css('background', '#393e46').attr('disabled', true).html('<i class="fa fa-envelope">' +
            '</i>&ensp;Invited');
        @endif

        function downloadAttachments(id) {
            $("#" + id).removeClass('ld ld-breath');
            $("#" + id + ' input[type=checkbox]').prop('checked', true);
            $("#form-download-attachments" + id)[0].submit();
        }

        $(document).on('show.bs.modal', '.modal', function (event) {
            var zIndex = 1040 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function () {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        });

        $(".profilebar-brand img").on("click", function () {
            $("#avaModal").modal('show');
        });
        $(".slider").on("click", function () {
            $("#backgroundModal").modal('show');
        });
    </script>
@endpush