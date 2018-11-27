@section('title', ''.$user->name.'\'s Dashboard &ndash; Invited Seeker | SISKA &mdash; Sistem Informasi Karier')
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
                                                @if(count($vacancy->getInvitation) > 1)
                                                    Showing <strong>{{count($vacancy->getInvitation)}}</strong>
                                                    invited seekers
                                                @elseif(count($vacancy->getInvitation) == 1)
                                                    Showing an invited seeker
                                                @else
                                                    <em>There seems to be none of the invited seeker was
                                                        found&hellip;</em>
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            @foreach($vacancy->getInvitation as $row)
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
                                                            @if($seeker->phone != "")
                                                                <a href="tel:{{$seeker->phone}}">
                                                                    <sub>| {{$seeker->phone}}</sub></a>
                                                            @endif
                                                            <span class="pull-right" style="color: #00ADB5">
                                                                Invited on {{\Carbon\Carbon::parse($row->created_at)
                                                                ->format('j F Y')}}
                                                            </span>
                                                        </small>
                                                        <blockquote style="font-size: 16px;color: #7f7f7f">
                                                            <span class="label label-default pull-right"
                                                                  style="background: {{$row->isApply == true ? '#00adb5' : '#fa5555'}};padding: 10px 15px;font-size: 14px">
                                                                <i class="fa fa-paper-plane"></i>&ensp;{{$row->isApply
                                                                == true ? 'APPLIED' : 'NOT APPLY'}}
                                                            </span>
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
                                                            @if($row->isApply == false)
                                                                <hr style="margin-bottom: 0">
                                                                <form class="to-animate-2"
                                                                      id="form-invitation-{{$row->id}}"
                                                                      method="post" action="{{route('invite.seeker')}}">
                                                                    {{csrf_field()}}
                                                                    <div class="anim-icon anim-icon-md invitation ld ld-breath"
                                                                         onclick="abortInvitation('{{$row->id}}',
                                                                                 '{{$userSeeker->name}}')"
                                                                         data-toggle="tooltip" data-placement="right"
                                                                         title="Click here to abort this invitation!"
                                                                         style="font-size: 25px">
                                                                        <input type="hidden" name="invitation_id"
                                                                               value="{{$row->id}}">
                                                                        <input id="invitation{{$row->id}}"
                                                                               type="checkbox" checked>
                                                                        <label for="invitation{{$row->id}}"></label>
                                                                    </div>
                                                                </form>
                                                                <small class="to-animate-2">
                                                                    P.S.: You are only permitted to abort this
                                                                    invitation before the seeker that
                                                                    you've invite apply it.
                                                                </small>
                                                            @endif
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

        function abortInvitation(id, name) {
            swal({
                title: 'Are you sure to abort ' + name + '?',
                text: "You won't be able to revert this invitation!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fa5555',
                confirmButtonText: 'Yes, abort it!',
                showLoaderOnConfirm: true,
                allowOutsideClick: false,
            }).then(function () {
                $("#invitation" + id).prop('checked', false);
                $("#form-invitation-" + id)[0].submit();
            }, function (dismiss) {
                if (dismiss == 'cancel') {
                    $("#invitation" + id).prop('checked', true);
                }
            });
        }
    </script>
@endpush