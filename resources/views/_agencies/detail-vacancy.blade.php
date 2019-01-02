@extends('layouts.mst_user')
@section('title', ''.$vacancy->judul.'\'s Details | SISKA &mdash; Sistem Informasi Karier')
@push('styles')
    <link href="{{ asset('css/mySearchFilter.css') }}" rel="stylesheet">
    <link href="{{ asset('css/myProfile.css') }}" rel="stylesheet">
    <link href="{{ asset('css/myMaps.css') }}" rel="stylesheet">
    <style>
        [data-scrollbar] {
            max-height: 350px;
        }
    </style>
@endpush
@section('content')
    <section id="fh5co-services" data-section="services" style="padding-top: 2.9em">
        <div class="fh5co-services">
            <div class="container to-animate" style="width: 100%;padding: 0;">
                <header id="header">
                    <div class="slider">
                        <div id="carousel-example" class="carousel slide carousel-fullscreen"
                             data-ride="carousel">
                            <div class="carousel-inner">
                                @if(\App\Gallery::where('agency_id',$agency->id)->count())
                                    @foreach(\App\Gallery::where('agency_id',$agency->id)->get() as $row)
                                        @if($row->image == 'c1.jpg' || $row->image == 'c2.jpg'||
                                        $row->image == 'c3.jpg')
                                            <div class="item"
                                                 style="background-image: url({{
                                                 asset('images/carousel/'.$row->image)}});">
                                                <div class="carousel-overlay"></div>
                                            </div>
                                        @else
                                            <div class="item"
                                                 style="background-image: url({{
                                                 asset('storage/users/agencies/galleries/'.$row->image)}});">
                                                <div class="carousel-overlay"></div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="item"
                                         style="background-image: url({{asset('images/carousel/c1.jpg')}});">
                                        <div class="carousel-overlay"></div>
                                    </div>
                                    <div class="item"
                                         style="background-image: url({{asset('images/carousel/c2.jpg')}});">
                                        <div class="carousel-overlay"></div>
                                    </div>
                                    <div class="item"
                                         style="background-image: url({{asset('images/carousel/c3.jpg')}});">
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
                                @if($user->ava == ""||$user->ava == "agency.png")
                                    <img class="img-responsive" src="{{asset('images/agency.png')}}">
                                @else
                                    <img class="img-responsive" src="{{asset('storage/users/'.$user->ava)}}">
                                @endif
                            </a>
                            <span class="site-name">{{$vacancy->judul}}</span>
                            <span class="site-description">{{$user->name}}</span>
                        </div>
                        <div class="collapse navbar-collapse" id="mainNav">
                            <ul class="nav main-menu navbar-nav to-animate">
                                <li data-placement="left" data-toggle="tooltip" title="Location">
                                    <a target="_blank" href="{{route('search.vacancy',
                                    ['loc' => substr($city, 0, 2)=="Ko" ? substr($city,5) : substr($city,10)])}}">
                                        <i class="fa fa-map-marked"></i>&ensp;{{substr($city, 0, 2)=="Ko" ?
                                        substr($city,5) : substr($city,10)}}
                                    </a>
                                </li>
                                <li data-placement="bottom" data-toggle="tooltip" title="Salary">
                                    <a target="_blank" href="{{route('search.vacancy',['salary_ids' => $salary->id])}}">
                                        <i class="fa fa-money-bill-wave"></i>&ensp;IDR {{$salary->name}}
                                    </a>
                                </li>
                                <li data-placement="bottom" data-toggle="tooltip" title="Work Experience">
                                    <a><i class="fa fa-briefcase"></i>&ensp;At least {{$vacancy->pengalaman > 1 ?
                                    $vacancy->pengalaman.' years' : $vacancy->pengalaman.' year'}}
                                    </a>
                                </li>
                                <li data-placement="bottom" data-toggle="tooltip" title="Education Degree">
                                    <a><i class="fa fa-graduation-cap"></i>
                                        &nbsp;{{$degrees->name}}
                                    </a>
                                </li>
                                @if($vacancy->isPost == true || Auth::check() && Auth::user()->isAgency() ||
                                Auth::guard('admin')->check())
                                    <li data-placement="right" data-toggle="tooltip" title="Total Applicant">
                                        <a><i class="fa fa-paper-plane"></i>&ensp;<strong>{{$applicants}}</strong>
                                            applicants</a>
                                    </li>
                                @endif
                            </ul>
                            <ul class="nav to-animate-2 navbar-nav navbar-right">
                                <li data-placement="left" data-toggle="tooltip" id="bm"
                                    title="{{$vacancy->isPost == true ? 'Bookmark this vacancy' : ''}}">
                                    <form method="post" action="{{route('bookmark.vacancy')}}" id="form-bookmark">
                                        {{csrf_field()}}
                                        <div class="anim-icon anim-icon-md bookmark ld ld-breath">
                                            <input type="hidden" name="vacancy_id" value="{{$vacancy->id}}">
                                            <input type="checkbox" id="bookmark" {{$vacancy->isPost == false ?
                                            'disabled' : ''}}>
                                            <label for="bookmark" style="cursor: {{$vacancy->isPost == false ?
                                            'not-allowed' : 'pointer'}}"></label>
                                        </div>
                                        <div class="anim-icon anim-icon-md info">
                                            <input type="checkbox" id="info">
                                            <label for="info" style="cursor: help;" data-toggle="popover"
                                                   data-placement="top" title="FYI"></label>
                                        </div>
                                    </form>
                                </li>
                                <li class=" {{Auth::check() && Auth::user()->isAgency() ||
                                Auth::guard('admin')->check() ? '' : 'ld ld-heartbeat'}}" id="apply"
                                    data-placement="top" data-toggle="tooltip">
                                    <button type="button" class="btn btn-danger btn-block"
                                            {{Auth::check() && Auth::user()->isAgency() ||
                                            Auth::guard('admin')->check() ? 'disabled' : ''}}>
                                        <i class="fa fa-paper-plane"></i>&ensp;<strong>Apply</strong>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </header>

                <div class="row to-animate detail">
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="img-card" id="map"></div>
                                    <div class="card-content">
                                        <div class="card-title">
                                            <table class="stats" style="margin-top: -.5em">
                                                <tr>
                                                    <td><i class="fa fa-map-marker-alt"></i></td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        <span data-placement="bottom" data-toggle="tooltip"
                                                              title="Agency Address">{{$agency->alamat}}</span>
                                                    </td>
                                                </tr>
                                            </table>
                                            <hr class="hr-divider">
                                            <table class="stats" style="text-transform: none">
                                                <tr>
                                                    <td><i class="fa fa-warehouse"></i></td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        <span data-placement="right" data-toggle="tooltip"
                                                              title="Job Function">{{$jobfunc->nama}}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-industry"></i></td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        <span data-placement="right" data-toggle="tooltip"
                                                              title="Industry">{{$industry->nama}}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-level-up-alt"></i></td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        <span data-placement="right" data-toggle="tooltip"
                                                              title="Job Level">{{$joblevel->name}}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-user-clock"></i></td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        <span data-placement="right" data-toggle="tooltip"
                                                              title="Job Type">{{$jobtype->name}}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-money-bill-wave"></i></td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        <span data-placement="right" data-toggle="tooltip"
                                                              title="Salary">IDR {{$salary->name}}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-graduation-cap"></i></td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        <span data-placement="right" data-toggle="tooltip"
                                                              title="Education Degree">{{$degrees->name}}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-user-graduate"></i></td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        <span data-placement="right" data-toggle="tooltip"
                                                              title="Education Major">{{$majors->name}}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-briefcase"></i></td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        <span data-placement="right" data-toggle="tooltip"
                                                              title="Work Experience">At least
                                                            {{$vacancy->pengalaman > 1 ? $vacancy->pengalaman.' years' :
                                                            $vacancy->pengalaman.' year'}}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-paper-plane"></i></td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        <span data-placement="right" data-toggle="tooltip"
                                                              title="Total Applicant">{{$applicants}} applicants</span>
                                                    </td>
                                                </tr>
                                            </table>
                                            <hr>
                                            <table class="stats">
                                                <tr>
                                                    <td><i class="fa fa-users"></i></td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        <span data-placement="right" data-toggle="tooltip"
                                                              title="Recruitment Date">
                                                            {{$vacancy->recruitmentDate_start &&
                                                            $vacancy->recruitmentDate_end != "" ? \Carbon\Carbon::parse
                                                            ($vacancy->recruitmentDate_start)->format('j F Y')." - ".
                                                            \Carbon\Carbon::parse($vacancy->recruitmentDate_end)
                                                            ->format('j F Y') : '-'}}
                                                        </span>
                                                    </td>
                                                </tr>
                                                @if($vacancy->plan_id != "" && $vacancy->plan_id == 2)
                                                    <tr>
                                                        <td><i class="fa fa-grin-beam"></i></td>
                                                        <td>&nbsp;</td>
                                                        <td>
                                                            <span data-placement="right" data-toggle="tooltip"
                                                                  title="Online Quiz (TPA & TKD) Date">
                                                                {{$vacancy->quizDate_start && $vacancy->quizDate_end !=
                                                                "" ? \Carbon\Carbon::parse($vacancy->quizDate_start)
                                                                ->format('j F Y')." - ".\Carbon\Carbon::parse
                                                                ($vacancy->quizDate_end)->format('j F Y') : '-'}}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @elseif($vacancy->plan_id != "" &&
                                                $vacancy->plan_id == 3)
                                                    <tr>
                                                        <td><i class="fa fa-grin-beam"></i></td>
                                                        <td>&nbsp;</td>
                                                        <td>
                                                            <span data-placement="right" data-toggle="tooltip"
                                                                  title="Online Quiz (TPA & TKD) Date">
                                                                {{$vacancy->quizDate_start && $vacancy->quizDate_end !=
                                                                "" ? \Carbon\Carbon::parse($vacancy->quizDate_start)
                                                                ->format('j F Y')." - ".\Carbon\Carbon::parse
                                                                ($vacancy->quizDate_end)->format('j F Y') : '-'}}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><i class="fa fa-comments"></i></td>
                                                        <td>&nbsp;</td>
                                                        <td>
                                                            <span data-placement="right" data-toggle="tooltip"
                                                                  title="Psycho Test (Online Interview) Date">
                                                                {{$vacancy->psychoTestDate_start &&
                                                                $vacancy->psychoTestDate_end != "" ?
                                                                \Carbon\Carbon::parse($vacancy->psychoTestDate_start)
                                                                ->format('j F Y')." - ".\Carbon\Carbon::parse
                                                                ($vacancy->psychoTestDate_end)->format('j F Y') : '-'}}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td><i class="fa fa-user-tie"></i></td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        <span data-placement="right" data-toggle="tooltip"
                                                              title="Job Interview Date">
                                                            {{$vacancy->interview_date != "" ? \Carbon\Carbon::parse
                                                            ($vacancy->interview_date)->format('l, j F Y') : '-'}}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </table>
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
                                            <small>Requirements</small>
                                            <hr class="hr-divider">
                                            <blockquote style="font-size: 14px" class="ulTinyMCE" data-scrollbar>
                                                {!! $vacancy->syarat !!}
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
                                            <small>Responsibilities</small>
                                            <hr class="hr-divider">
                                            <blockquote style="font-size: 14px" class="ulTinyMCE" data-scrollbar>
                                                {!! $vacancy->syarat !!}
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
                                            <small>
                                                About {{$user->name}}
                                                <a href="{{$agency->link}}" target="_blank"
                                                   style="text-transform: none">
                                                    <span class="pull-right"
                                                          style="color: #FA5555">{{$agency->link}}</span></a>
                                            </small>
                                            <hr class="hr-divider">
                                            <blockquote data-scrollbar>
                                                {!! $agency->tentang != "" ? $agency->tentang : '' !!}
                                                <small>{{$agency->alasan != "" ? 'Why Choose Us?' : ''}}</small>
                                                {!! $agency->alasan != "" ? $agency->alasan : '' !!}
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
                                            <small>Vacancies in {{$user->name}}</small>
                                            <hr class="hr-divider">
                                            <div data-scrollbar>
                                                @foreach(\App\Vacancies::where('agency_id',$agency->id)
                                                ->where('isPost',true)->orderByDesc('updated_at')->get() as $row)
                                                    @php
                                                        $agency_list = \App\Agencies::find($row->agency_id);
                                                        $user_list = \App\User::find(\App\Agencies::find($row->agency_id)
                                                        ->user_id);
                                                        $city_list = \App\Cities::find($row->cities_id)->name;
                                                        $salary_list = \App\Salaries::find($row->salary_id);
                                                        $jobfunc_list = \App\FungsiKerja::find($row->fungsikerja_id);
                                                        $industry_list = \App\Industri::find($row->industry_id);
                                                        $degrees_list = \App\Tingkatpend::find($row->tingkatpend_id);
                                                        $majors_list = \App\Jurusanpend::find($row->jurusanpend_id);
                                                        $applicants_list = \App\Accepting::where('vacancy_id', $row->id)
                                                        ->where('isApply', true)->count();
                                                    @endphp
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="media">
                                                                <div class="media-left media-middle">
                                                                    @if($user_list->ava == ""||$user_list->ava == "agency.png")
                                                                        <img width="100" class="media-object"
                                                                             src="{{asset('images/agency.png')}}">
                                                                    @else
                                                                        <img width="100" class="media-object"
                                                                             src="{{asset('storage/users/'.$user_list->ava)}}">
                                                                    @endif
                                                                </div>
                                                                <div class="media-body">
                                                                    <small class="media-heading">
                                                                        <a href="{{route('detail.vacancy',['id'=>$row->id])}}">
                                                                            {{$row->judul}}</a>
                                                                        <sub style="color: #fa5555;text-transform: none">&ndash; {{$row->updated_at
                                                                            ->diffForHumans()}}</sub>
                                                                    </small>
                                                                    <blockquote style="font-size: 12px;color: #7f7f7f">
                                                                        <ul class="list-inline">
                                                                            <li>
                                                                                <a class="tag" target="_blank"
                                                                                   href="{{route('search.vacancy',['loc' => substr($city_list, 0, 2)=="Ko" ? substr($city_list,5) : substr($city_list,10)])}}">
                                                                                    <i class="fa fa-map-marked"></i>&ensp;
                                                                                    {{substr($city_list, 0, 2)=="Ko" ? substr($city_list,5) : substr($city_list,10)}}
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="tag" target="_blank"
                                                                                   href="{{route('search.vacancy',['jobfunc_ids' => $row->fungsikerja_id])}}">
                                                                                    <i class="fa fa-warehouse"></i>&ensp;
                                                                                    {{$jobfunc_list->nama}}
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="tag" target="_blank"
                                                                                   href="{{route('search.vacancy',['industry_ids' => $row->industry_id])}}">
                                                                                    <i class="fa fa-industry"></i>&ensp;
                                                                                    {{$industry_list->nama}}
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="tag" target="_blank"
                                                                                   href="{{route('search.vacancy',['salary_ids' => $salary->id])}}">
                                                                                    <i class="fa fa-money-bill-wave"></i>
                                                                                    &ensp;IDR {{$salary_list->name}}</a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="tag" target="_blank"
                                                                                   href="{{route('search.vacancy',['degrees_ids' => $row->tingkatpend_id])}}">
                                                                                    <i class="fa fa-graduation-cap"></i>
                                                                                    &ensp;{{$degrees_list->name}}</a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="tag" target="_blank"
                                                                                   href="{{route('search.vacancy',['majors_ids' => $row->jurusanpend_id])}}">
                                                                                    <i class="fa fa-user-graduate"></i>
                                                                                    &ensp;{{$majors_list->name}}</a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="tag">
                                                                                    <i class="fa fa-briefcase"></i>
                                                                                    &ensp;At least {{$row->pengalaman > 1 ?
                                                                                $row->pengalaman.' years' :
                                                                                $row->pengalaman.' year'}}
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="tag tag-plans">
                                                                                    <i class="fa fa-paper-plane"></i>&ensp;
                                                                                    <strong>{{$applicants_list}}</strong>
                                                                                    applicants
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                        <table style="font-size: 12px;margin-top: -.5em">
                                                                            <tr>
                                                                                <td><i class="fa fa-users"></i></td>
                                                                                <td>&nbsp;Recruitment Date</td>
                                                                                <td>:
                                                                                    {{$row->recruitmentDate_start &&
                                                                                    $row->recruitmentDate_end != "" ?
                                                                                    \Carbon\Carbon::parse
                                                                                    ($row->recruitmentDate_start)
                                                                                    ->format('j F Y')." - ".
                                                                                    \Carbon\Carbon::parse
                                                                                    ($row->recruitmentDate_end)
                                                                                    ->format('j F Y') : '-'}}
                                                                                </td>
                                                                            </tr>
                                                                            @if($row->plan_id != "" &&
                                                                                    $row->plan_id == 2)
                                                                                <tr>
                                                                                    <td>
                                                                                        <i class="fa fa-grin-beam">
                                                                                        </i>
                                                                                    </td>
                                                                                    <td>&nbsp;Quiz
                                                                                        (Online TPA & TKD) Date
                                                                                    </td>
                                                                                    <td>: {{$row->quizDate_start &&
                                                                                        $row->quizDate_end != "" ?
                                                                                        \Carbon\Carbon::parse
                                                                                        ($row->quizDate_start)
                                                                                        ->format('j F Y')." - ".
                                                                                        \Carbon\Carbon::parse
                                                                                        ($row->quizDate_end)
                                                                                        ->format('j F Y') : '-'}}
                                                                                    </td>
                                                                                </tr>
                                                                            @elseif($row->plan_id != "" &&
                                                                            $row->plan_id == 3)
                                                                                <tr>
                                                                                    <td>
                                                                                        <i class="fa fa-grin-beam"></i>
                                                                                    </td>
                                                                                    <td>&nbsp;Online Quiz (TPA & TKD)
                                                                                        Date
                                                                                    </td>
                                                                                    <td>: {{$row->quizDate_start &&
                                                                                $row->quizDate_end != "" ?
                                                                                \Carbon\Carbon::parse
                                                                                ($row->quizDate_start)->format('j F Y').
                                                                                " - ".\Carbon\Carbon::parse
                                                                                ($row->quizDate_end)->format('j F Y') : '-'}}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <i class="fa fa-comments"></i>
                                                                                    </td>
                                                                                    <td>&nbsp;Psycho Test (Online
                                                                                        Interview)
                                                                                        Date
                                                                                    </td>
                                                                                    <td>:
                                                                                        {{$row->psychoTestDate_start &&
                                                                                        $row->psychoTestDate_end != "" ?
                                                                                        \Carbon\Carbon::parse
                                                                                        ($row->psychoTestDate_start)
                                                                                        ->format('j F Y')." - ".
                                                                                        \Carbon\Carbon::parse
                                                                                        ($row->psychoTestDate_end)
                                                                                        ->format('j F Y') : '-'}}
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                            <tr>
                                                                                <td><i class="fa fa-user-tie"></i>
                                                                                </td>
                                                                                <td>&nbsp;Job Interview Date</td>
                                                                                <td>:
                                                                                    {{$row->interview_date != "" ?
                                                                                    \Carbon\Carbon::parse
                                                                                    ($row->interview_date)
                                                                                    ->format('l, j F Y') : '-'}}
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </blockquote>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="hr-divider">
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-read-more">
                                        <a class="btn btn-link btn-block"
                                           href="{{route('agency.profile',['id'=>$vacancy->agency_id])}}">
                                            <i class="fa fa-building"></i>&ensp;More info {{$user->name}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @auth
        <div class="modal fade login" id="applyModal">
            <div class="modal-dialog login animated">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Hi {{Auth::user()->name}},</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box">
                            <div class="content">
                                <p style="font-size: 17px" align="justify">
                                    Complete data will make you a lot easier to apply for any jobs and the agency (HRD)
                                    is interested with. You will register for this vacancy with the
                                    following details:</p>
                                <hr class="hr-divider">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="media">
                                            <div class="media-left media-middle">
                                                @if($user->ava == ""||$user->ava == "agency.png")
                                                    <img width="100" class="media-object"
                                                         src="{{asset('images/agency.png')}}">
                                                @else
                                                    <img width="100" class="media-object"
                                                         src="{{asset('storage/users/'.$user->ava)}}">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <small class="media-heading" style="font-size: 17px;">
                                                    <a href="{{route('detail.vacancy',['id'=>$vacancy->id])}}"
                                                       style="color: #00ADB5">
                                                        {{$vacancy->judul}}</a>
                                                    <sub style="color: #fa5555;text-transform: none">&ndash; {{$vacancy->updated_at->diffForHumans()}}</sub>
                                                </small>
                                                <blockquote style="font-size: 16px;color: #7f7f7f">
                                                    <ul class="list-inline">
                                                        <li>
                                                            <a class="tag" target="_blank"
                                                               href="{{route('search.vacancy',['loc' => substr($city, 0, 2)=="Ko" ? substr($city,5) : substr($city,10)])}}">
                                                                <i class="fa fa-map-marked"></i>&ensp;
                                                                {{substr($city, 0, 2)=="Ko" ? substr($city,5) : substr($city,10)}}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="tag" target="_blank"
                                                               href="{{route('search.vacancy',['jobfunc_ids' => $vacancy->fungsikerja_id])}}">
                                                                <i class="fa fa-warehouse"></i>&ensp;
                                                                {{$jobfunc->nama}}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="tag" target="_blank"
                                                               href="{{route('search.vacancy',['industry_ids' => $vacancy->industry_id])}}">
                                                                <i class="fa fa-industry"></i>&ensp;
                                                                {{$industry->nama}}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="tag" target="_blank"
                                                               href="{{route('search.vacancy',['salary_ids' => $salary->id])}}">
                                                                <i class="fa fa-money-bill-wave"></i>
                                                                &ensp;IDR {{$salary->name}}</a>
                                                        </li>
                                                        <li>
                                                            <a class="tag" target="_blank"
                                                               href="{{route('search.vacancy',['degrees_ids' => $vacancy->tingkatpend_id])}}">
                                                                <i class="fa fa-graduation-cap"></i>
                                                                &ensp;{{$degrees->name}}</a>
                                                        </li>
                                                        <li>
                                                            <a class="tag" target="_blank"
                                                               href="{{route('search.vacancy',['majors_ids' => $vacancy->jurusanpend_id])}}">
                                                                <i class="fa fa-user-graduate"></i>
                                                                &ensp;{{$majors->name}}</a>
                                                        </li>
                                                        <li>
                                                            <a class="tag">
                                                                <i class="fa fa-briefcase"></i>
                                                                &ensp;At least {{$vacancy->pengalaman > 1 ?
                                                                $vacancy->pengalaman.' years' :
                                                                $vacancy->pengalaman.' year'}}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="tag tag-plans">
                                                                <i class="fa fa-paper-plane"></i>&ensp;
                                                                <strong>{{$applicants}}</strong> applicants
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <table style="font-size: 12px;margin-top: -.5em">
                                                        <tr>
                                                            <td><i class="fa fa-users"></i></td>
                                                            <td>&nbsp;Recruitment Date</td>
                                                            <td>:
                                                                {{$vacancy->recruitmentDate_start &&
                                                                $vacancy->recruitmentDate_end != "" ?
                                                                \Carbon\Carbon::parse($vacancy->recruitmentDate_start)
                                                                ->format('j F Y')." - ".\Carbon\Carbon::parse
                                                                ($vacancy->recruitmentDate_end)->format('j F Y') : '-'}}
                                                            </td>
                                                        </tr>
                                                        @if($vacancy->plan_id != "" && $vacancy->plan_id == 2)
                                                            <tr>
                                                                <td><i class="fa fa-grin-beam"></i></td>
                                                                <td>&nbsp;Online Quiz (TPA & TKD) Date</td>
                                                                <td>: {{$vacancy->quizDate_start &&
                                                                $vacancy->quizDate_end != "" ? \Carbon\Carbon::parse
                                                                ($vacancy->quizDate_start)->format('j F Y')." - ".
                                                                \Carbon\Carbon::parse($vacancy->quizDate_end)
                                                                ->format('j F Y') : '-'}}
                                                                </td>
                                                            </tr>
                                                        @elseif($vacancy->plan_id != "" &&
                                                        $vacancy->plan_id == 3)
                                                            <tr>
                                                                <td><i class="fa fa-grin-beam"></i></td>
                                                                <td>&nbsp;Online Quiz (TPA & TKD) Date</td>
                                                                <td>: {{$vacancy->quizDate_start &&
                                                                $vacancy->quizDate_end != "" ? \Carbon\Carbon::parse
                                                                ($vacancy->quizDate_start)->format('j F Y')." - ".
                                                                \Carbon\Carbon::parse($vacancy->quizDate_end)
                                                                ->format('j F Y') : '-'}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><i class="fa fa-comments"></i></td>
                                                                <td>&nbsp;Psycho Test (Online Interview) Date</td>
                                                                <td>:
                                                                    {{$vacancy->psychoTestDate_start &&
                                                                    $vacancy->psychoTestDate_end != "" ?
                                                                    \Carbon\Carbon::parse($vacancy->psychoTestDate_start)
                                                                    ->format('j F Y')." - ".\Carbon\Carbon::parse
                                                                    ($vacancy->psychoTestDate_end)->format('j F Y') : '-'}}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        <tr>
                                                            <td><i class="fa fa-user-tie"></i></td>
                                                            <td>&nbsp;Job Interview Date</td>
                                                            <td>:
                                                                {{$vacancy->interview_date != "" ? \Carbon\Carbon::parse
                                                                ($vacancy->interview_date)->format('l, j F Y') : '-'}}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </blockquote>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="card-read-more" id="btn-apply">
                            <form method="post" action="{{route('apply.vacancy')}}" id="form-apply">
                                {{csrf_field()}}
                                <input type="hidden" name="vacancy_id" value="{{$vacancy->id}}">
                                <button class="btn btn-link btn-block" type="button">
                                    <i class="fa fa-paper-plane"></i>&ensp;Apply
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade login" id="resumeModal">
            <div class="modal-dialog login animated">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Resume Incomplete</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box">
                            <div class="content" style="font-size: 16px">
                                Required data to be completed before applying:
                                <ol>
                                    <li>Your personal data (gender, phone number, address, and date of birth)</li>
                                    <li>Education or work experience (at least one)</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="card-read-more">
                            <a class="btn btn-link btn-block" href="{{route('seeker.edit.profile')}}">
                                <i class="fa fa-user"></i>&ensp;Go to resume</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endauth
    <div class="modal fade login" id="avaModal">
        <div class="modal-dialog login animated">
            @if($user->ava == ""||$user->ava == "agency.png")
                <img class="img-responsive" src="{{asset('images/agency.png')}}">
            @else
                <img class="img-responsive" src="{{asset('storage/users/'.$user->ava)}}">
            @endif
        </div>
    </div>
@endsection
@push("scripts")
    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIljHbKjgtTrpZhEiHum734tF1tolxI68"></script>
    <script>
        // gmaps address agency
        var google;

        function init() {
            var myLatlng = new google.maps.LatLng('{{$agency->lat}}', '{{$agency->long}}');

            var mapOptions = {
                zoom: 16,
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
                '<div class="iw-title">{{$user->name}}</div>' +
                '<div class="iw-content">' +
                '<div class="iw-subTitle">About Us</div>' +
                '<img src="{{$user->ava == "" || $user->ava == "agency.png" ? asset('images/agency.png') :
                asset('storage/users/'.$user->ava)}}">' +
                '{!!$agency->tentang == "" ? '(empty)' : $agency->tentang!!}' +
                '<div class="iw-subTitle">Contacts</div>' +
                '<p>{{$agency->alamat == "" ? '(empty)' : $agency->alamat}}<br>' +
                '<br>Phone: <a href="tel:{{$agency->phone == "" ? '' : $agency->phone}}">' +
                '{{$agency->phone == "" ? '-' : $agency->phone}}</a>' +
                '<br>E-mail: <a href="mailto:{{$user->email}}">{{$user->email}}</a>' +
                '<br>Website: <a href="{{$agency->link == "" ? '#' : $agency->link}}" target="_blank">' +
                '{{$agency->link == "" ? '-' : $agency->link}}</a>' +
                '</p></div><div class="iw-bottom-gradient"></div></div>';

            var infowindow = new google.maps.InfoWindow({
                content: contentString,
                maxWidth: 350
            });

            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                anchorPoint: new google.maps.Point(0, -29),
                icon: '{{asset('images/pin-agency.png')}}'
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

                iwOuter.css({left: '-30px', top: '15px'});
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
                    right: '-39px',
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

        // apply validation
        var $btnApply = $("#apply button"), $btnBookmark = $("#bm"),
            startDate = '{{$vacancy->recruitmentDate_start}}', endDate = '{{$vacancy->recruitmentDate_end}}',
            $content = '', $style = 'none', $class = '', $attr = false,
            now = new Date(), day = ("0" + now.getDate()).slice(-2), month = ("0" + (now.getMonth() + 1)).slice(-2),
            today = now.getFullYear() + "-" + (month) + "-" + (day);

        @if($vacancy->isPost == false)
            $content = 'This vacancy is INACTIVE.';
        $style = 'inline-block';
        $class = '';
        @else
        if (today < startDate || startDate == "") {
            $content = 'The recruitment date of this vacancy hasn\'t started yet.';
            $style = 'inline-block';
            $class = '';
            $attr = true;
        } else if (today > endDate || endDate == "") {
            $content = 'The recruitment date of this vacancy has been ended.';
            $style = 'inline-block';
            $class = '';
            $attr = true;
        } else {
            $content = '';
            $class = 'ld ld-heartbeat';
            $attr = false;
        }
        @endif
        $(".info").css('display', $style);
        $(".info label").data('content', $content);
        $("#apply").addClass($class);
        $btnApply.attr('disabled', $attr);
        @auth
        @if(Auth::user()->isSeeker())
        @php
            $seeker = \App\Seekers::where('user_id',Auth::user()->id)->first();
            $acc = App\Accepting::where('seeker_id',$seeker->id)->where('vacancy_id',$vacancy->id);
        @endphp
        @if(count($acc->get()))
        @if($acc->first()->isBookmark == true)
        $("#bookmark").prop('checked', true);
        $("#bm .bookmark").removeClass('ld ld-breath');
        $btnBookmark.attr('title', 'Unmark this vacancy');
        @endif
        @if($acc->first()->isApply == true)
        $("#apply").removeClass('ld ld-heartbeat').attr('title', 'Please, check Application Status ' +
            'in your Dashboard.');
        $btnApply.css('background', '#393e46').attr('disabled', true).html('<i class="fa fa-paper-plane">' +
            '</i>&ensp;<strong>Applied</strong>');
        @endif
        @endif
        @endif
        @endauth
        $("#bookmark").on("click", function () {
            $("#bm .bookmark").toggleClass('ld ld-breath');
            @auth
            @if(Auth::user()->isSeeker())
            $("#form-bookmark")[0].submit();
            @else
            $(this).prop('checked', false);
            swal({
                title: 'ATTENTION!',
                text: 'This feature only works when you\'re signed in as a Job Seeker.',
                type: 'warning',
                timer: '3500'
            });
            @endif
            @else
            $(this).prop('checked', false);
            @if(Auth::guard('admin')->check())
            swal({
                title: 'ATTENTION!',
                text: 'This feature only works when you\'re signed in as a Job Seeker.',
                type: 'warning',
                timer: '3500'
            });
            @else
            openLoginModal();
            @endif
            @endauth
        });
        $btnApply.on("click", function () {
            @auth
            @if(Auth::user()->isSeeker())
            $("#applyModal").modal('show');
            $("#btn-apply button").on("click", function () {
                $.get("{{route('get.vacancy.requirement',['id' => $vacancy->id])}}", function (data) {
                    if (data == 0) {
                        $("#resumeModal").modal('show');
                    } else if (data == 1) {
                        swal({
                            title: 'Work Experience Unqualified',
                            text: 'It seems that your work experience for {{$seeker->total_exp}} year(s) isn\'t sufficient for this vacancy.',
                            type: 'warning',
                            timer: '7000'
                        });
                    } else if (data == 2) {
                        swal({
                            title: 'Education Degree Unqualified',
                            text: 'There seems to be none of your education history that has qualified for this vacancy.',
                            type: 'warning',
                            timer: '7000'
                        });
                    } else if (data == 3) {
                        $("#applyModal").modal('hide');
                        $("#apply").toggleClass('ld ld-heartbeat');
                        $btnApply.css('background', '#393e46').attr('disabled', true)
                            .html('<i class="fa fa-paper-plane"></i>&ensp;<strong>Applied</strong>');
                        $('#form-apply')[0].submit();
                    }
                });
            });
            @endif
            @else
            openLoginModal();
            @endauth
        });

        $(document).on('show.bs.modal', '.modal', function (event) {
            var zIndex = 1040 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function () {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        });

        $(".profilebar-brand img").click(function () {
            $("#avaModal").modal('show');
        });
    </script>
@endpush