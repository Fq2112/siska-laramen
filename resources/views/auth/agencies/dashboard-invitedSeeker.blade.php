@section('title', ''.$user->name.'\'s Dashboard &ndash; Invited Seeker | SISKA &mdash; Sistem Informasi Karier')
@extends('layouts.auth.mst_agency')
@section('inner-content')
    <div class="row" style="font-family: 'PT Sans', Arial, serif">
        <div class="to-animate col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 style="margin-bottom: 10px">Invited Seeker</h4>
                            <small>Here is your invited seekers.</small>
                            <hr>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: .5em">
                        <div class="col-lg-3 to-animate-2">
                            <form id="form-time" action="{{route('agency.invited.seeker')}}">
                                <select class="form-control selectpicker" name="time" data-container="body">
                                    <option value="1" {{$time == 1 ? 'selected' : ''}}>All Time</option>
                                    <option value="2" {{$time == 2 ? 'selected' : ''}}>Today</option>
                                    <option value="3" {{$time == 3 ? 'selected' : ''}}>Last 7 Days</option>
                                    <option value="4" {{$time == 4 ? 'selected' : ''}}>Last 30 Days</option>
                                </select>
                            </form>
                        </div>
                        <div class="col-lg-9 to-animate">
                            <small class="pull-right">
                                @if(count($invited) > 1)
                                    Showing <strong>{{count($invited)}}</strong> invited seekers
                                @elseif(count($invited) == 1)
                                    Showing an invited seeker
                                @else
                                    <em>There seems to be none of the invited seeker was found&hellip;</em>
                                @endif
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            @foreach($invited as $row)
                                @php
                                    $vacancy = \App\Vacancies::find($row->vacancy_id);
                                    $seeker = \App\Seekers::find($row->seeker_id);
                                    $userSeeker = \App\User::find($seeker->user_id);
                                    $job_title = \App\Experience::where('seeker_id', $seeker->id)
                                    ->where('end_date', null)->orderby('id', 'desc')->take(1);
                                    $last_edu = \App\Education::where('seeker_id', $seeker->id)
                                    ->wherenotnull('end_period')->orderby('tingkatpend_id', 'desc')->take(1);
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
                                            <a href="{{route('detail.vacancy',['id'=>$vacancy->id])}}"
                                               style="color: #fa5555">
                                                <sub>&ndash; {{$vacancy->judul}}</sub></a>
                                            <span class="pull-right" style="color: #00ADB5">
                                                Invited on {{\Carbon\Carbon::parse($row->created_at)->format('j F Y')}}
                                            </span>
                                        </small>
                                        <blockquote style="font-size: 16px;color: #7f7f7f">
                                            <form class="pull-right to-animate-2" id="form-invitation-{{$row->id}}"
                                                  method="post" action="{{route('invite.seeker')}}">
                                                {{csrf_field()}}
                                                <input type="hidden" name="seeker_id" value="{{$seeker->id}}">
                                                <div class="anim-icon anim-icon-md invitation ld ld-breath"
                                                     onclick="abortInvitation('{{$row->id}}','{{$userSeeker->name}}')"
                                                     data-toggle="tooltip" data-placement="bottom" title="Abort"
                                                     style="font-size: 25px">
                                                    <input type="hidden" name="invitation_id" value="{{$row->id}}">
                                                    <input id="invitation{{$row->id}}" type="checkbox" checked>
                                                    <label for="invitation{{$row->id}}"></label>
                                                </div>
                                            </form>
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
                                                                var low = ("{{$seeker->lowest_salary}}").split(',').join("") / 1000000,
                                                                    high = ("{{$seeker->highest_salary}}").split(',').join("") / 1000000;
                                                                document.getElementById("salary-{{$row->id}}").innerHTML = "<i class='fa fa-hand-holding-usd'></i>&ensp;Expected Salary: IDR " + low + " to " + high + " millions";
                                                            </script>
                                                        @else
                                                            <i class='fa fa-hand-holding-usd'></i>&ensp;Expected Salary:
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
                    <div class="row">
                        <div class="col-lg-12 to-animate-2 myPagination">
                            {{$invited->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
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

        $("#form-time select").on('change', function () {
            $("#form-time")[0].submit();
        });
    </script>
@endpush