@section('title', ''.$user->name.'\'s Dashboard &ndash; Application Received | SISKA &mdash; Sistem Informasi Karier')
@extends('layouts.auth.mst_agency')
@section('inner-content')
    <div class="row" style="font-family: 'PT Sans', Arial, serif">
        <div class="to-animate col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="nav nav-tabs" id="vac-nav-tabs">
                                @foreach($vacancies as $vacancy)
                                    <li><a data-toggle="tab" href="#vac-{{$vacancy->id}}">{{$vacancy->judul}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 1em">
                        <div class="tab-content" id="vac-tab-content">
                            @foreach($vacancies as $vacancy)
                                <div id="vac-{{$vacancy->id}}" class="tab-pane to-animate">
                                    <div class="row">
                                        <div class="col-lg-12 to-animate">
                                            <small class="pull-right">
                                                @if(count($vacancy->getAccepting) > 1)
                                                    Showing <strong>{{count($vacancy->getAccepting)}}</strong>
                                                    application received
                                                @elseif(count($vacancy->getAccepting) == 1)
                                                    Showing an application received
                                                @else
                                                    <em>There seems to be none of the application received was found&hellip;</em>
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            @foreach($vacancy->getAccepting as $row)
                                                @php
                                                    $seeker = \App\Seekers::find($row->seeker_id);
                                                    $userSeeker = \App\User::find($seeker->user_id);
                                                    $job_title = \App\Experience::where('seeker_id', $seeker->id)
                                                    ->where('end_date', null)->orderby('id', 'desc')->take(1);
                                                    $last_edu = \App\Education::where('seeker_id', $seeker->id)
                                                    ->wherenotnull('end_period')->orderby('tingkatpend_id', 'desc')
                                                    ->take(1);
                                                @endphp
                                                <div class="media to-animate">
                                                    <div class="media-left media-middle">
                                                        <a href="{{route('seeker.profile',['id'=>$seeker->id])}}">
                                                            @if($userSeeker->ava == ""||$userSeeker->ava == "seeker.png")
                                                                <img width="100" class="media-object"
                                                                     src="{{asset('images/seeker.png')}}">
                                                            @else
                                                                <img width="100" class="media-object"
                                                                     src="{{asset('storage/users/'.$userSeeker->ava)}}">
                                                            @endif
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <small class="media-heading" style="font-size: 17px;">
                                                            <a href="{{route('seeker.profile',['id'=>$seeker->id])}}"
                                                               style="color: #00ADB5">
                                                                {{$userSeeker->name}}</a>
                                                            <a href="mailto:{{$userSeeker->email}}">
                                                                <sub>&ndash; {{$user->email}}</sub></a>
                                                            <a href="tel:{{$seeker->phone}}">
                                                                <sub>| {{$seeker->phone}}</sub></a>
                                                            <span class="pull-right" style="color: #00ADB5">
                                                                Applied on {{\Carbon\Carbon::parse($row->created_at)
                                                                ->format('j F Y')}}
                                                            </span>
                                                        </small>
                                                        <blockquote style="font-size: 16px;color: #7f7f7f">
                                                            <ul class="list-inline">
                                                                <li>
                                                                    <a class="tag">
                                                                        <i class="fa fa-user-tie"></i>&ensp;
                                                                        @if(count($job_title->get()) != 0)
                                                                            Current
                                                                            Title: {{$job_title->first()->job_title}}
                                                                        @else
                                                                            Current Status: Looking for a Job
                                                                        @endif
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="tag">
                                                                        <i class="fa fa-briefcase"></i>&ensp;
                                                                        Work Experience: {{$seeker->total_exp}} years
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="tag" id="salary-{{$row->id}}">
                                                                        @if($seeker->lowest_salary != "")
                                                                            <script>
                                                                                var low = ("{{$seeker->lowest_salary}}") / 1000000,
                                                                                    high = ("{{$seeker->highest_salary}}") / 1000000;
                                                                                document.getElementById("salary-{{$row->id}}").innerHTML = "<i class='fa fa-hand-holding-usd'></i>&ensp;Expected Salary: IDR " + low + " to " + high + " millions";
                                                                            </script>
                                                                        @else
                                                                            <i class='fa fa-hand-holding-usd'></i>&ensp;
                                                                            Expected
                                                                            Salary:
                                                                            Anything
                                                                        @endif
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="tag">
                                                                        <i class="fa fa-graduation-cap"></i>&ensp;
                                                                        @if(count($last_edu->get()) != 0)
                                                                            Latest Degree: {{\App\Tingkatpend::find
                                                                        ($last_edu->first()->tingkatpend_id)->name}}
                                                                        @else
                                                                            Latest Degree (-)
                                                                        @endif
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="tag">
                                                                        <i class="fa fa-user-graduate"></i>&ensp;
                                                                        @if(count($last_edu->get()) != 0)
                                                                            Latest Major: {{\App\Jurusanpend::find
                                                                        ($last_edu->first()->jurusanpend_id)->name}}
                                                                        @else
                                                                            Latest Major (-)
                                                                        @endif
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
                                                        </blockquote>
                                                    </div>
                                                </div>
                                                <hr class="hr-divider">
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(function () {
            $("#vac-nav-tabs li").first().addClass('active');
            $("#vac-tab-content .tab-pane").first().addClass('active');
        });
    </script>
@endpush